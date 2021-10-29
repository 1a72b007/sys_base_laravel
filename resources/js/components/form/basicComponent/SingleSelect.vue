<template>
  <div>
    <label for="text-input">{{ label }}</label>
    <span class="text-danger ml-1" v-show="validate.indexOf('required') != -1">*</span>
    <multiselect
      v-model="currentValue"
      :id="name"
      :name="name"
      :options="options"
      :show-labels="false"
      label="name"
      track-by="name"
      :data-vv-as="label"
      v-validate="validate"
      :disabled="is_disabled"
      :data-vv-scope="data_vv_scope"
      @input="onInputEvent"
    >
      <span slot="noResult">無此結果</span>
    </multiselect>
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
import Multiselect from "vue-multiselect";
export default {
  $_veeValidate: {
    validator: "new",
  },
  inject: ["$validator"],
  name: "SingleSelect",
  props: ["placeholder", "options", "name", "label", "value", "validate", "is_disabled","obj_key","data_vv_scope"],
  components: { Multiselect },
  mixins: [formMixins],
  data() {
    return {
      currentValue: this.value,
    };
  },
};
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
