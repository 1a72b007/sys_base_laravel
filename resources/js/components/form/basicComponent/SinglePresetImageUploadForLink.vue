<template>
  <div class="imgfile_Area">
    <label for="imgfile-input">{{ label }}</label>
    <span class="text-danger ml-1" v-show="validate.indexOf('required') != -1"
      >*</span
    >
    <input
      class="btn btn-block btn-outline-secondary"
      id="imgfile-input"
      type="file"
      name="file-input"
      accept=".jpg, .png"
      @change="previewImage"
    />
    <div class="imgfile_Image">
      <button
        type="button"
        class="imgfile_remove"
        v-if="show_button"
        @click="reset"
      >
        <i class="c-icon cil-x"></i>
      </button>
      <img v-if="currentValue" :name="name" :src="currentValue" />
      <img v-if="otherParameter" :src="otherParameter" />
    </div>
  </div>
</template>

<script>
import formMixins from "../../../mixins/form-model";

const stored_value_card_img = "assets/img/stored_value_card.png";
const classes_img = "assets/img/classes.png";
const member_card_img = "assets/img/member_card.png";

export default {
  $_veeValidate: {
    validator: "new",
  },
  inject: ["$validator"],
  name: "SinglePresetImageUploadForLink",
  props: [
    "placeholder",
    "label",
    "name",
    "value",
    "type",
    "validate",
    "show_button",
    "otherParameter",
    "obj_key",
    "preset_image",
  ],
  mixins: [formMixins],
  data() {
    return {
      currentValue: this.value,
      stored_value_card_img: stored_value_card_img,
      classes_img: classes_img,
      member_card_img: member_card_img,
      // show_button  : this.show_button
    };
  },
  mounted() {
    if (!this.otherParameter) {
      switch (this.preset_image) {
        case "stored_value_card_img":
          this.toDataURL(this.stored_value_card_img, (dataUrl) => {
            this.currentValue = dataUrl;
            this.$emit("input", this.obj_key, dataUrl);
          });
          break;
        case "classes_img":
          this.toDataURL(this.classes_img, (dataUrl) => {
            this.currentValue = dataUrl;
            this.$emit("input", this.obj_key, dataUrl);
          });
          break;
        case "member_card_img":
          this.toDataURL(this.member_card_img, (dataUrl) => {
            this.currentValue = dataUrl;
            this.$emit("input", this.obj_key, dataUrl);
          });
          break;
      }
    }
  },
  methods: {
    previewImage: function (event) {
      this.otherParameter = "";
      for (var i = 0; i < event.target.files.length; i++) {
        var input = event.target.files[i];
        if (input) {
          var reader = new FileReader();
          reader.onload = (e) => {
            this.currentValue = e.target.result;
            this.$emit("input", this.obj_key, e.target.result);
          };
          reader.readAsDataURL(input);
        }
      }
    },

    toDataURL: function (src, callback, outputFormat) {
      var img = new Image();
      img.crossOrigin = "Anonymous";
      img.onload = function () {
        var canvas = document.createElement("CANVAS");
        var ctx = canvas.getContext("2d");
        var dataURL;
        canvas.height = this.naturalHeight;
        canvas.width = this.naturalWidth;
        ctx.drawImage(this, 0, 0);
        dataURL = canvas.toDataURL(outputFormat);
        callback(dataURL);
      };
      img.src = src;
    },

    reset() {
      this.currentValue = "";
      this.otherParameter = "";
      this.$emit("input", this.obj_key, "");
    },
  },
};
</script>

<style scoped>
</style>
