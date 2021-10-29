<template>
  <div>
    <label for="text-input">{{ label }}</label>
    <p class="form-control-static">{{ currentValue }}</p>
  </div>
</template>

<script>
import formMixins from "../../../mixins/form-model";
export default {
  name: "Label",
  props: ["placeholder", "label", "name", "value","type"],
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
