<template>
  <div>
    <label for="text-input">{{ label }}</label>
    <span class="text-danger ml-1" v-show="validate.indexOf('required') != -1">*</span>
    <multiselect
      v-model="currentValue"
      :id="name"
      :name="name"
      @input="onInputEvent"
      :options="options"
      :show-labels="false"
      label="name"
      track-by="name"
      :data-vv-as="label"
      v-validate="validate"
      :disabled="is_disabled"
      :data-vv-scope="data_vv_scope"
      :taggable="true"
      tag-placeholder="新增這個選項"
      @tag="add_tag"
    >
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
  name: "SingleSelectAddTag",
  props: ["placeholder", "options", "name", "label", "value", "validate", "is_disabled","obj_key","data_vv_scope"],
  components: { Multiselect },
  mixins: [formMixins],
  data() {
    return {
      currentValue: this.value,
    };
  },
  methods: {
    add_tag (newTag) {
      this.$emit('add_tag', newTag);
    }
  }
};
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
