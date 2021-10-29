export default {
  props: ['name', 'value', "obj_key"],

  data() {
    return {
      currentValue: this.value
    };
  },
  methods: {
    onInputEvent(event) {
      this.$emit('input', this.obj_key, event);
    },
    reset() {
      this.currentValue = "";
    }
  },
  computed: {
    error_param() {
      return `${this.data_vv_scope}.${this.name}`
    },
  },
  watch: {
    value(val) {
      this.currentValue = val;
    }
  }
};
