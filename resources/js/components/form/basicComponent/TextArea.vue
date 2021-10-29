<template>
  <div>
    <label for="text-input">{{ label }}</label>
    <span class="text-danger ml-1" v-show="validate.indexOf('required') != -1"
      >*</span
    >
    <textarea
      class="form-control"
      :id="name"
      :name="name"
      :type="type"
      :value="currentValue"
      :placeholder="placeholder"
      :data-vv-as="label"
      :disabled="is_disabled"
      v-validate="validate"
      :data-vv-scope="data_vv_scope"
      rows="4"
      @input="onInputEvent($event.target.value)"
    ></textarea>
    <div
      style="width: 100%; margin-top: 0.25rem; font-size: 80%; color: #e55353"
      v-show="errors.has(error_param)"
    >
      {{ errors.first(error_param) }}
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
  name: "TextArea",
  props: ["placeholder", "label", "name", "value", "type", "validate", "is_disabled","obj_key","data_vv_scope"],
  mixins: [formMixins],
  data() {
    return {
      currentValue: this.value,
    };
  },
};
</script>



<style scoped>
</style>
