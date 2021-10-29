<template>
  <div class="imgfile_Area">
    <div class="barcode_Area">
      <label for="barcode-input">{{ label }}</label>
      <div class="barcode_input">
        <input
          class="form-control"
          :id="name"
          :type="type"
          :name="name"
          :value="currentValue"
          @input="onInputEvent($event.target.value)"
          :placeholder="placeholder"
          :data-vv-as="label"
          v-validate="validate"
        />
        <!-- <button class="btn btn-outline-dark">產生圖片</button> -->
      </div>
      <div class="barcode_Image">
        <!-- <img :src="barcode" /> -->
        <barcode :value="currentValue" v-if="currentValue"> </barcode>
      </div>
      <div
        style="width: 100%; margin-top: 0.25rem; font-size: 80%; color: #e55353"
        v-show="errors.has(name)"
      >
        {{ errors.first(name) }}
      </div>
    </div>
  </div>
</template>

<script>
import formMixins from "../../../mixins/form-model";
import VueBarcode from "vue-barcode";
export default {
  $_veeValidate: {
    validator: "new",
  },
  inject: ["$validator"],
  name: "BarCode",
  components: {
    barcode: VueBarcode,
  },
  props: ["placeholder", "label", "name", "value", "type", "validate","obj_key"],
  mixins: [formMixins],
  data() {
    return {
      currentValue: this.value,
      barcode: "",
    };
  },
  methods: {},
};
</script>


<style scoped>
</style>
