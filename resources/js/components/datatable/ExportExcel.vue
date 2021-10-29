<template>
  <a
    class="btn btn-outline-dark"
    type="primary"
    size="mini"
    @click="exportExcel"
    >資料匯出</a
  >
</template>


<script>
import Xlsx from "xlsx";

export default {
  name: "ExportExcel",
  props: {
    // excel 檔名
    filename: String,

    // Json to download
    data: {
      type: Array,
      required: false,
      default: null,
    },
    // fields inside the Json Object that you want to export
    // if no given, all the properties in the Json are exported
    fields: {
      type: Object,
      default: () => null,
    },
    // this prop is used to fix the problem with other components that use the
    // variable fields, like vee-validate. exportFields works exactly like fields
    exportFields: {
      type: Object,
      default: () => null,
    },

    fetch: {
      type: Function,
    },
  },
  computed: {
    downloadFields() {
      if (this.fields) return this.fields;

      if (this.exportFields) return this.exportFields;
    },
  },
  methods: {
    async exportExcel() {
      // 將資料轉化成 excel 所需的資料格式
      let headers = [Object.keys(this.downloadFields)];
      let data = this.data;
      if (typeof this.fetch === "function" || !data) data = await this.fetch();

      if (!data || !data.length) {
        return;
      }

      let tpm_data = [];
      let json = this.getProcessedJson(data, this.downloadFields);

      json.forEach((element) => {
        tpm_data.push(Object.values(element));
      });

      var today = new Date();
      var currentDateTime =
        today.getFullYear() +
        (today.getMonth() + 1 < 10 ? '0'+(today.getMonth() + 1) :today.getMonth() + 1 ) +
        today.getDate() +
        "_"+
        (today.getHours() < 10 ? '0' + (today.getHours()) :today.getHours()) +
        (today.getMinutes() < 10  ? '0' + (today.getMinutes()) :today.getMinutes());

      let ws = Xlsx.utils.aoa_to_sheet(headers);
      Xlsx.utils.sheet_add_aoa(ws, tpm_data, { origin: this.beginRow || "A2" });
      let wb = Xlsx.utils.book_new();
      Xlsx.utils.book_append_sheet(wb, ws, "Sheet1");
      Xlsx.writeFile(wb, (this.filename || "export") +"_" + currentDateTime+".xlsx");
    },

    /*
		getProcessedJson
		---------------
		Get only the data to export, if no fields are set return all the data
		*/
    getProcessedJson(data, header) {
      let keys = this.getKeys(data, header);
      let newData = [];
      let _self = this;
      data.map(function (item, index) {
        let newItem = {};
        for (let label in keys) {
          let property = keys[label];
          newItem[label] = _self.getValue(property, item);
        }
        newData.push(newItem);
      });

      return newData;
    },
    getKeys(data, header) {
      if (header) {
        return header;
      }

      let keys = {};
      for (let key in data[0]) {
        keys[key] = key;
      }
      return keys;
    },
    /*
		parseExtraData
		---------------
		Parse title and footer attribute to the csv format
		*/
    parseExtraData(extraData, format) {
      let parseData = "";
      if (Array.isArray(extraData)) {
        for (var i = 0; i < extraData.length; i++) {
          if (extraData[i])
            parseData += format.replace("${data}", extraData[i]);
        }
      } else {
        parseData += format.replace("${data}", extraData);
      }
      return parseData;
    },

    getValue(key, item) {
      const field = typeof key !== "object" ? key : key.field;
      let indexes = typeof field !== "string" ? [] : field.split(".");
      let value = this.defaultValue;

      if (!field) value = item;
      else if (indexes.length > 1)
        value = this.getValueFromNestedItem(item, indexes);
      else value = this.parseValue(item[field]);

      if (key.hasOwnProperty("callback"))
        value = this.getValueFromCallback(value, key.callback);

      return value;
    },

    /*
    convert values with newline \n characters into <br/>
    */
    valueReformattedForMultilines(value) {
      if (typeof value == "string") return value.replace(/\n/gi, "<br/>");
      else return value;
    },
    preprocessLongNum(value) {
      if (this.stringifyLongNum) {
        if (String(value).startsWith("0x")) {
          return value;
        }
        if (!isNaN(value) && value != "") {
          if (value > 99999999999 || value < 0.0000000000001) {
            return '="' + value + '"';
          }
        }
      }
      return value;
    },
    getValueFromNestedItem(item, indexes) {
      let nestedItem = item;
      for (let index of indexes) {
        if (nestedItem) nestedItem = nestedItem[index];
      }
      return this.parseValue(nestedItem);
    },

    getValueFromCallback(item, callback) {
      if (typeof callback !== "function") return this.defaultValue;
      const value = callback(item);
      return this.parseValue(value);
    },
    parseValue(value) {
      return value || value === 0 || typeof value === "boolean"
        ? value
        : this.defaultValue;
    },
    base64ToBlob(data, mime) {
      let base64 = window.btoa(window.unescape(encodeURIComponent(data)));
      let bstr = atob(base64);
      let n = bstr.length;
      let u8arr = new Uint8ClampedArray(n);
      while (n--) {
        u8arr[n] = bstr.charCodeAt(n);
      }
      return new Blob([u8arr], { type: mime });
    },
  },
};
</script>