<template>
  <div
    class="modal fade"
    id="add_edit_modal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="myModalLabel"
    aria-hidden="true"
    data-backdrop="static"
  >
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <slot name="title"></slot>
          <button class="close" type="button" @click="cancel()">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="ac_modal_block" onsubmit="return false">
            <div
              class="row"
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
                    v-bind="field"
                    :options="field.options"
                    :ref="field.name"
                    :type="field.type"
                    :validate="field.validate"
                    :placeholder="field.placeholder"
                    :is_disabled="field.is_disabled"
                    :otherParameter="get_value(field.otherParameter)"
                    :preset_image="field.preset_image"
                    :data_vv_scope="field.data_vv_scope"
                    @input="updateForm"
                    @add_tag="add_tag"
                  >
                  </component>
                </div>
              </div>
            </div>
            <slot name="extended_block"></slot>
          </form>         
        </div>
        <div
          class="modal-footer d-flex justify-content-center align-items-center"
        >
          <button
            class="btn btn-outline-secondary btn-lg"
            type="button"
            @click="cancel()"
          >
            取消
          </button>
          <button class="btn btn-info btn-lg" type="button" @click="submit">
            {{ action == "add" ? "新增" : "儲存" }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
//套件
import Vue from "vue";
import ElementUI from "element-ui";
import "element-ui/lib/theme-chalk/index.css";
import VeeValidate, { Validator } from "vee-validate";
import zh_TW from "vee-validate/dist/locale/zh_TW";

//自定義元件
import TextInput from "./form/basicComponent/TextInput";
import SingleSelect from "./form/basicComponent/SingleSelect";
import MultipleSelect from "./form/basicComponent/MultipleSelect";
import Label from "./form/basicComponent/Label";
import SingleImageUpload from "./form/basicComponent/SingleImageUpload";
import SinglePresetImageUploadForLink from "./form/basicComponent/SinglePresetImageUploadForLink";
import SingleImageUploadForLink from "./form/basicComponent/SingleImageUploadForLink";
import BarCode from "./form/basicComponent/BarCode";
import Radio from "./form/basicComponent/Radio";
import TextArea from "./form/basicComponent/TextArea";
import SingleSelectAddTag from "./form/basicComponent/SingleSelectAddTag";

//js
import form_modal_drawer_mixins from "../mixins/form_modal_drawer_mixins";

const veeValidateConfig = {
  locale: "zh_TW",
  inject: false,
};

Vue.use(ElementUI);
Vue.use(VeeValidate, veeValidateConfig);
Validator.localize("zh_TW", zh_TW);

export default {
  $_veeValidate: {
    validator: "new",
  },
  inject: ["$validator"],
  name: "AddEditModal",
  components: {
    TextInput,
    SingleSelect,
    MultipleSelect,
    Label,
    SingleImageUpload,
    SinglePresetImageUploadForLink,
    SingleImageUploadForLink,
    BarCode,
    Radio,
    TextArea,
    SingleSelectAddTag,
  },
  mixins: [form_modal_drawer_mixins],
  methods: {
    submit() {
      this.$validator.validateAll("add_edit_modal").then(async (result) => {
        if (result) {
          this.$emit("save");
        } else {
        }
      });
    },
    reset() {
      for (var name in this.formData) {
        if (typeof this.formData === "String") {
          this.formData[name] = "";
        } else {
          this.formData[name] = null;
        }
      }
    },
    cancel() {
      this.$emit("cancel", "status", "add_edit_modal");
    },
    add_tag(newTag) {
      if (confirm("是否新增這個選項?")) {
        this.$emit("add_tag", newTag);
      }
    },
  },
};
</script>
