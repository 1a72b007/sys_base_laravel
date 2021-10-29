<template>
  <div>
    <label for="text-input">{{ label }}</label>
    <!-- 如果是同一個問題的單選 記得name的命名要一樣 -->
    <div class="ac_checkbox_global checkbox_style01">
      <label
        class="option_element"
        v-for="(options_dto, index) in options"
        :key="index"
        >一段長長的文字
        <input
          type="checkbox"
          name="checkbox_01"
          :value="options_dto.id"
          v-validate="validate"
          @input="onInputEvent($event.target.value)"
          :checked="options_dto.id == currentValue"
        />
        <span class="forms_indicator"></span>
      </label>
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
  name: "CheckBox",
  props: ["options", "name", "label", "value", "validate"],
  mixins: [formMixins],
  data() {
    return {
      currentValue: this.value,
    };
  },
};
</script>