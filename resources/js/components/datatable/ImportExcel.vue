
<template>
  <div class="btn btn-outline-dark" @click="input_import_excel_click()">
    資料匯入
    <input
      type="file"
      style="display: none"
      accept=".xlsx"
      @change="import_excel()"
      ref="input_import_excel"
    />
  </div>
</template>


<script>
import axios from "axios";
export default {
  name: "ImportExcel",
  props: {
    api_url: {
      type: String,
    },
    import_params: {
      type: Object,
      default: () => null,
    },
  },
  computed: {},
  methods: {
    import_excel() {
      const form_data = new FormData();
      for (var i = 0; i < event.target.files.length; i++) {
        const input = event.target.files[i];
        if (input) {
          form_data.append("file", input);
          if (this.import_params) {
            Object.keys(this.import_params).forEach((element) => {
              form_data.append(element, this.import_params[element]);
            });
          }
        }
      }
      axios({
        method: "post",
        url: this.api_url,
        data: form_data,
        headers: { "Content-Type": "multipart/form-data" },
      })
        .then((response) => { 
          alert("匯入成功")
          this.$emit("callback");
        })
        .catch((error) => {
          alert(error.response.data.message)
        });
    },

    input_import_excel_click() {
      this.$refs.input_import_excel.click();
    },

  },
};
</script>