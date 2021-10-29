<template>
  <div
    class="modal fade"
    id="member_wallet_modal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="myModalLabel"
    aria-hidden="true"
    data-backdrop="static"
  >
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header" style="justify-content: center">
          <slot name="title"></slot>
          <button class="close" type="button" @click="cancel()">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="">
            <div class="text-center ac_modal_block">
              <el-tabs
                v-model="activeName"
                type="card"
                @tab-click="handleClick"
              >
                <el-tab-pane label="會員卡" name="member_card">
                  <div class="ac_modal_block">
                    <div class="row text-left">
                      <div class="col-lg-12">
                        <div class="row">
                          <div class="col-lg-12"></div>
                          <div class="col-lg-6">
                            <div class="form-group row mb-1">
                              <label class="col-md-auto col-form-label"
                                >狀態:</label
                              >
                              <label class="col-md col-form-label"></label>
                            </div>
                          </div>
                          <div class="col-lg-6">
                            <div class="form-group row mb-1">
                              <label class="col-md-auto col-form-label"
                                >折扣比例:</label
                              >
                              <label class="col-md col-form-label">{{
                                member_card.sale_percent
                              }}</label>
                            </div>
                          </div>
                          <div class="col-lg-6">
                            <div class="form-group row mb-1">
                              <label class="col-md-auto col-form-label"
                                >到期日期:</label
                              >
                              <label class="col-md col-form-label">{{
                                member_card.due_date
                                  ? moment(member_card.due_date)
                                      .locale("zh-tw")
                                      .format("YYYY-MM-DD")
                                  : ""
                              }}</label>
                            </div>
                          </div>
                          <div class="col-lg-6">
                            <div class="form-group row mb-1">
                              <label class="col-md-auto col-form-label"
                                >開卡日期:</label
                              >
                              <label class="col-md col-form-label">{{
                                member_card.start_date
                                  ? moment(member_card.start_date)
                                      .locale("zh-tw")
                                      .format("YYYY-MM-DD")
                                  : ""
                              }}</label>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <hr />
                  <div class="ac_modal_block">
                    <div class="pt-3 pb-4">
                      <h5 class="text-left">歷史紀錄</h5>
                    </div>
                    <v-client-table
                      ref="use_record"
                      v-model="worth_unit_history_list"
                      :columns="worth_unit_history_config_2.columns"
                      :options="worth_unit_history_config_2.options"
                    >
                    </v-client-table>
                  </div>
                </el-tab-pane>

                <el-tab-pane label="儲值卡" name="stored_value_card">
                  <div class="ac_modal_block">
                    <div class="row text-left">
                      <div class="col-lg-12">
                        <div class="row">
                          <div class="col-lg-12">
                            <div class="form-group">
                              <multiselect
                                name="worth_unit"
                                :options="worth_unit_list"
                                :show-labels="false"
                                label="name"
                                track-by="name"
                                v-model="filter_formData.worth_unit"
                              >
                                <span slot="noResult">無此結果</span>
                              </multiselect>
                            </div>
                          </div>
                          <div class="col-lg-6">
                            <div class="form-group row mb-1">
                              <label class="col-md-auto col-form-label"
                                >餘額:</label
                              >
                              <label class="col-md col-form-label">{{
                                filter_formData.worth_unit &&
                                filter_formData.worth_unit.value
                              }}</label>
                            </div>
                          </div>
                          <div class="col-lg-6">
                            <div class="form-group row mb-1">
                              <label class="col-md-auto col-form-label"
                                >折扣比例:</label
                              >
                              <label class="col-md col-form-label">{{
                                stored_value_card.sale_percent
                              }}</label>
                            </div>
                          </div>
                          <div class="col-lg-6">
                            <div class="form-group row mb-1">
                              <label class="col-md-auto col-form-label"
                                >最高儲值金額:</label
                              >
                              <label class="col-md col-form-label">{{
                                stored_value_card.max_stored
                              }}</label>
                            </div>
                          </div>
                          <div class="col-lg-6">
                            <div class="form-group row mb-1">
                              <label class="col-md-auto col-form-label"
                                >最低儲值金額:</label
                              >
                              <label class="col-md col-form-label">{{
                                stored_value_card.min_stored
                              }}</label>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <hr />
                  <div class="ac_modal_block">
                    <div class="pt-3 pb-4">
                      <h5 class="text-left">歷史紀錄</h5>
                    </div>
                    <v-client-table
                      ref="use_record"
                      v-model="worth_unit_history_list"
                      :columns="worth_unit_history_config.columns"
                      :options="worth_unit_history_config.options"
                    >
                      <div slot="value" slot-scope="{ row }">
                        {{ row.value }}元
                      </div>
                    </v-client-table>
                  </div>
                </el-tab-pane>

                <el-tab-pane label="堂數券" name="classes">
                  <div class="ac_modal_block">
                    <div class="row">
                      <div class="col-lg-12">
                        <div class="row text-left">
                          <div class="col-lg-12">
                            <div class="form-group">
                              <multiselect
                                name="worth_unit"
                                :options="worth_unit_list"
                                :show-labels="false"
                                label="name"
                                track-by="name"
                                v-model="filter_formData.worth_unit"
                              >
                                <span slot="noResult">無此結果</span>
                              </multiselect>
                            </div>
                          </div>
                          <div class="col-lg-6">
                            <div class="form-group row mb-1">
                              <label class="col-md-auto col-form-label"
                                >剩餘次數:</label
                              >
                              <label class="col-md col-form-label">{{
                                filter_formData.worth_unit.value
                              }}</label>
                            </div>
                          </div>
                          <div class="col-lg-6">
                            <div class="form-group row mb-1">
                              <label class="col-md-auto col-form-label"
                                >購買次數:</label
                              >
                              <label class="col-md col-form-label">{{
                                filter_formData.worth_unit.history_value
                              }}</label>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <hr />
                  <div class="ac_modal_block">
                    <div class="pt-3 pb-4">
                      <h5 class="text-left">歷史紀錄</h5>
                    </div>
                    <v-client-table
                      ref="use_record"
                      v-model="worth_unit_history_list"
                      :columns="worth_unit_history_config.columns"
                      :options="worth_unit_history_config.options"
                    >
                      <div slot="value" slot-scope="{ row }">
                        {{ row.value }}券
                      </div>
                    </v-client-table>
                  </div>
                </el-tab-pane>
              </el-tabs>
            </div>
          </div>
        </div>
        <div
          class="modal-footer d-flex justify-content-center align-items-center"
        ></div>
      </div>
    </div>
  </div>
</template>

<script>
require("../../bootstrap.js");

//自定義元件
import MySortControl from "../../components/datatable/MySortControl";
import MyPagination from "../../components/datatable/MyPagination";

//自定義共用js
import api from "../../api.js";
import async_await from "../../async_await.js";

//套件
import { ServerTable, ClientTable, Event } from "vue-tables-2";
import Multiselect from "vue-multiselect";
import "vue-multiselect/dist/vue-multiselect.min.css";
import moment from "moment";

Vue.use(ClientTable, {}, false, "bootstrap3", {
  sortControl: MySortControl,
  pagination: MyPagination,
});
Vue.prototype.$api = api; // 定義api這個常數給AXIOS存取json-server或實際api環境用

//儲值卡、堂數卡使用紀錄datatable設定檔
const worth_unit_history_config = {
  columns: ["created_at", "status", "product_item_name", "value", "user_name"],
  options: {
    filterByColumn: false,
    headings: {
      created_at: "紀錄日期",
      status: "狀態",
      product_item_name: "使用項目",
      value: "使用",
      user_name: "結帳人員",
    },
    sortable: [
      "created_at",
      "status",
      "product_item_name",
      "value",
      "user_name",
    ],
  },
};

//會員卡歷史紀錄datatable設定檔
const worth_unit_history_config_2 = {
  columns: ["created_at", "action", "value"],
  options: {
    filterByColumn: false,
    headings: {
      created_at: "紀錄日期",
      action: "狀態",
      value: "使用",
    },
    sortable: ["created_at", "action", "value"],
    templates: {
      value(h, row) {
        return `${row.value}元`;
      },
    },
  },
};

export default {
  name: "MemberWalletModal",
  props: ["member_id"],
  data() {
    return {
      activeName: "member_card",
      worth_unit_history_config: worth_unit_history_config,
      worth_unit_history_config_2: worth_unit_history_config_2,
      worth_unit_history_list: [],
      worth_unit_list: [],
      filter_formData: {
        worth_unit_type: "price",
        worth_unit: "",
      },
      member_card: {
        due_date: "",
        start_date: "",
        sale_percent: "",
      },
      stored_value_card: "",
      moment: moment,
    };
  },
  components: {
    Multiselect,
  },
  mounted() {
    this.get_member_card();
  },

  methods: {
    async get_worth_unit_sum() {
      const url = `/member/${this.member_id}/worth_unit/sum`;
      const [error, res] = await async_await.safeAwait(
        this.$api.get(url, {
          worth_unit_type: this.filter_formData.worth_unit_type,
        })
      );
      if (res) {
        let worth_unit_list = [];
        if (res.data.length > 0) {
          worth_unit_list = res.data.map((element) => {
            const tmp_obj = {
              id: element.worth_unit._id,
              name: element.worth_unit.name,
              value: element.value,
              history_value: element.history_value,
            };
            return tmp_obj;
          });
        }
        this.$set(this, "worth_unit_list", worth_unit_list);
      }
    },

    async get_worth_unit_history() {
      const url = `/member/${this.member_id}/worth_unit/history`;
      const [error, res] = await async_await.safeAwait(
        this.$api.get(url, {
          worth_unit_id: this.filter_formData.worth_unit.id,
        })
      );
      if (res) {
        let worth_unit_history_list = [];
        if (res.data.length > 0) {
          worth_unit_history_list = res.data.map((element) => {
            const tmp_obj = {
              created_at: moment(element.created_at)
                .locale("zh-tw")
                .format("YYYY-MM-DD"),
              status: element.value >= 0 ? "儲值" : "付款",
              product_item_name: element.order_item
                ? element.order_item.history__product_item_name
                : "",
              value: Math.abs(element.value),
              user_name: element.order.user.name,
            };
            return tmp_obj;
          });
        }
        this.$set(this, "worth_unit_history_list", worth_unit_history_list);
      }
    },

    async get_stored_value_card() {
      const url = "/stored_value_card/" + this.filter_formData.worth_unit.id;
      const [error, res] = await async_await.safeAwait(this.$api.get(url));
      if (res) {
        this.$set(this, "stored_value_card", res.data);
      }
    },

    async get_member_card() {
      const url = `/member/${this.member_id}/member_card`;
      const [error, res] = await async_await.safeAwait(this.$api.get(url));
      if (res) {
        let worth_unit_history_list = [];
        if (res.data.history.length > 0) {
          worth_unit_history_list = res.data.history.map((element) => {
            const tmp_obj = {
              created_at: moment(element.created_at)
                .locale("zh-tw")
                .format("YYYY-MM-DD"),
              action: element.action,
              value: Math.abs(element.price),
            };
            return tmp_obj;
          });
        }
        this.$set(this, "worth_unit_history_list", worth_unit_history_list);
        this.$set(
          this,
          "member_card",
          base.params_to_obj(res.data || this.member_card, [
            "due_date",
            "start_date",
            "sale_percent",
          ])
        );
      }
    },

    handleClick(tab, event) {
      this.filter_formData.worth_unit = "";
      this.member_card = "";
      this.stored_value_card = "";
      this.worth_unit_history_list = [];
      switch (this.activeName) {
        case "stored_value_card":
          this.filter_formData.worth_unit_type = "price";
          this.get_worth_unit_sum();
          break;
        case "classes":
          this.filter_formData.worth_unit_type = "class";
          this.get_worth_unit_sum();
          break;
        case "member_card":
          this.get_member_card();
          break;
      }
    },

    cancel() {
      this.$emit("cancel", "wallet_status", "member_wallet_modal");
    },
  },
  watch: {
    "filter_formData.worth_unit": {
      handler(newValue, oldValue) {
        if (newValue) {
          if (this.activeName == "stored_value_card") {
            this.get_stored_value_card();
          }
          this.get_worth_unit_history();
        } else {
          this.filter_formData.worth_unit = "";
          this.worth_unit_history_list = [];
        }
      },
    },
  },
};
</script>
