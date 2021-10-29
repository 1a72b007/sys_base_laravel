<template>
  <div>
    <label for="text-input">{{ label }}</label>
    <!-- 如果是同一個問題的單選 記得name的命名要一樣 -->
    <div class="ac_radiobtn_global radiobtn_style01">
      <label
        class="option_element"
        v-for="(options_dto, index) in options"
        :key="index"
      >
        {{ options_dto.name }}
        <input
          type="radio"
          :name="name + '_radio_01'"
          :value="options_dto.sid"
          v-validate="validate"
          @input="onInputEvent($event.target.value)"
          :checked="options_dto.sid == currentValue"
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
  name: "Radio",
  props: ["options", "name", "label", "value", "validate","obj_key"],
  mixins: [formMixins],
  data() {
    return {
      currentValue: this.value,
    };
  },
};
</script>