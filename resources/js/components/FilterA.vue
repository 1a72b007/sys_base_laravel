<template>
  <div
    class="modal fade"
    id="allfilter_Modal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="allfilter_Label"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">條件篩選</h4>
        </div>
        <div class="modal-body">
          <form onsubmit="return false">
            <div class="ac_modal_block">
              <div
                :class="block_dto.block_class"
                v-for="(block_dto, block_index) in config.blocksConfig"
                v-bind:key="block_index"
              >
                <div
                  :class="field.field_class"
                  v-for="(field, field_index) in block_dto.fieldsConfig"
                  v-bind:key="field_index"
                >
                  <div class="form-group">
                    <component
                      :key="field_index"
                      :is="field.fieldType"
                      :label="field.label"
                      :value="get_value(field.obj_key)"
                      :name="field.name"
                      :obj_key="field.obj_key"
                      :multiple="field.multiple"
                      @input="updateForm"
                      v-bind="field"
                      :options="field.options"
                      :ref="field.name"
                      :type="field.type"
                      :validate="field.validate"
                    >
                    </component>
                  </div>
                </div>
              </div>
            </div>
            <div class="d-flex justify-content-center align-items-center mb-5">
              <!-- <p class="mb-0">
                <span class="text-remarks-blue">已設條件1項</span
                ><span> / 可設條件3項</span>
              </p> -->
              <button
                class="btn btn-outline-dark ml-2"
                type="button"
                @click="reset"
              >
                清除所有條件
              </button>
            </div>
          </form>
        </div>
        <div
          class="modal-footer d-flex justify-content-center align-items-center"
        >
          <button
            class="btn btn-secondary btn-lg"
            type="button"
            data-dismiss="modal"
          >
            取消
          </button>
          <button class="btn btn-info btn-lg" type="button" @click="submit">
            確認
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import TextInput from "./form/basicComponent/TextInput";
import SingleSelect from "./form/basicComponent/SingleSelect";
import MultipleSelect from "./form/basicComponent/MultipleSelect";
import Radio from "./form/basicComponent/Radio";
export default {
  name: "FilterA",
  components: { TextInput, SingleSelect, MultipleSelect, Radio },
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
          }
          return old[now];
        }, this.formData);
      } else {
        this.formData[fieldName] = value;
      }
    },
    submit() {
      $("#allfilter_Modal").modal("hide");
      this.$emit("save");
    },
    reset() {
      for (var name in this.formData) {
        if (name != "store") {
          if (typeof this.formData === "String") {
            this.formData[name] = "";
          } else {
            this.formData[name] = null;
          }
        }
      }
    },
  },
  computed: {
    get_value: function () {
      return function (obj_key) {
        if (obj_key) {
          if (obj_key.indexOf(".") > 0) {
            let value = obj_key.split(".").reduce((old, now) => {
              return old[now];
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
</script>
