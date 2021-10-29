<template>
  <div
    class="modal fade"
    id="del_modal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="myModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header" style="justify-content: center">
          <slot name="title"></slot>
          <!-- <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button> -->
        </div>
        <div class="modal-body">
          <div class="">
            <div class="text-center ac_modal_block">
              <slot name="body"></slot>
            </div>
          </div>
        </div>
        <div
          class="modal-footer d-flex justify-content-center align-items-center"
        >
          <button
            class="btn btn-outline-secondary btn-lg"
            type="button"
            data-dismiss="modal"
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
  methods: {
    del() {
      this.$emit("del");
    },
  },
};
</script>
