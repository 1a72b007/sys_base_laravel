<template>
  <v-pagination
    v-model="props.page"
    :page-count="props.totalPages"
    :classes="bootstrapPaginationClasses"
    @input="(page) => props.setPage(page)"
    :labels="paginationAnchorTexts"
  />
</template>

<script>
import vPagination from "vue-plain-pagination";

export default {
  name: "VtPagination",
  data() {
    return {
      bootstrapPaginationClasses: {
        ul: "pagination",
        li: "page-item",
        liActive: "active",
        liDisable: "disabled",
        button: "page-link",
      },
      paginationAnchorTexts: {
        first: false,
        prev: "上頁",
        next: "下頁",
        last: false,
      },
    };
  },
  components: {
    vPagination,
  },
  props: ["props"],
};
</script>

<style scoped>
</style>
