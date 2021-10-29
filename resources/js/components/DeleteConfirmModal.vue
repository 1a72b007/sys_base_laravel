<template>
  <div
    class="modal fade"
    id="del_confirm_modal"
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
              <slot name="body"></slot>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <div class="col-md-12">
                      <input
                        class="form-control"
                        type="text"
                        v-model="confirm_again_text"
                      />
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
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
          <button class="btn btn-danger btn-lg" type="button" @click="del">
            刪除
          </button>
        </div>
      </div>
      <!-- /.modal-content-->
    </div>
    <!-- /.modal-dialog-->
  </div>
</template>

<script>
export default {
  props: ["confirm_text"],
  data() {
    return {
      confirm_again_text: "",
    };
  },
  methods: {
    del() {
      if (this.confirm_again_text == this.confirm_text) {
        this.$emit("del");
      }
      else{
        alert('請輸入正確的確認文字')
      }
    },
    cancel() {
      this.$emit("cancel", "del_status", "del_confirm_modal");
    },
  },
};
</script>
