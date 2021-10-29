export default {
  props: ["config", "value", "action"],
  data() {
    return {
      formData: this.value,
    };
  },
  methods: {
    updateForm(fieldName, value) {
      if (fieldName.indexOf(".") > 0) {
        fieldName.split(".").reduce((old, now, index, arr) => {
          if (index == arr.length - 1) {
            old[now] = value;
            return old[now];
          } else {
            if (now.indexOf("[") > -1 && now.indexOf("]") > -1) {
              if (Object.prototype.toString.call(old) === "[object Object]") {
                const prototype_value = now.split("[")[0];
                const index = now.split("[")[1].split("]")[0];
                return old[prototype_value][index];
              }
            } else {
              return old[now];
            }
          }
        }, this.formData);
      } else {
        this.formData[fieldName] = value;
      }
    },
  },
  computed: {
    get_value: function () {
      return function (obj_key) {
        if (obj_key) {
          if (obj_key.indexOf(".") > 0) {
            let value = obj_key.split(".").reduce((old, now) => {
              if (now.indexOf("[") > -1 && now.indexOf("]") > -1) {
                if (Object.prototype.toString.call(old) === "[object Object]") {
                  const prototype_value = now.split("[")[0];
                  const index = now.split("[")[1].split("]")[0];
                  return old[prototype_value][index];
                }
              } else {
                return old[now];
              }
            }, this.formData);
            return value;
          } else {
            return this.formData[obj_key];
          }
        } else {
          return "";
        }
      };
    },
  },
};
