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
        v-if="currentValue || otherParameter"
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
export default {
  $_veeValidate: {
    validator: "new",
  },
  inject: ["$validator"],
  name: "SingleImageUpload",
  props: [
    "placeholder",
    "label",
    "name",
    "value",
    "type",
    "validate",
    "otherParameter",
    "obj_key",
  ],
  mixins: [formMixins],
  data() {
    return {
      currentValue: this.value,
    };
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
