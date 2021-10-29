<template>
  <table class="table table-striped datatable display"></table>
</template>

<script>
export default {
  name: "DataTable",
  props: ["columns", "data"],
  data() {
    return {
      instance: null,
    };
  },
  mounted() {
    // https://jsfiddle.net/ejmwobp2/4/
    this.instance = $(this.$el).DataTable({
      dom: "ftip",
      stateSave: true,
      fixedColumns: true,
      fixedColumns: {
        leftColumns: 2,
      },
      columns: this.columns,
      data: this.data,
      // scrollY: "40vh",
      scrollCollapse: true,
      scrollX: true,
      searching: false,
    });
  },
  methods: {},
  watch: {
    data: function (newData) {
      if (this.instance) {
        this.instance.clear();
        this.instance.rows.add(newData);
        this.instance.draw();
      }
    },
  },
};
</script>
