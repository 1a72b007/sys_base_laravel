<template>
  <!-- <font-awesome-icon v-if="props.sortable" :icon="icon" class="fa-pull-right" /> -->
  <!-- <span v-if="props.sortable" style="margin-left:10px"> <span style="opacity: 0.3;">&#8593;</span><span style="opacity: 0.3;">&#8595;</span> </span> -->
  <span v-if="props.sortable" style="margin-left:10px" v-html="icon"></span>
</template>

<script>
import { library } from "@fortawesome/fontawesome-svg-core";
import {
  faSort,
  faSortUp,
  faSortDown,
} from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

library.add(faSort);
library.add(faSortUp);
library.add(faSortDown);

export default {
  name: "VtSortControl",
  props: ["props"],
  components: {
    FontAwesomeIcon,
  },
  computed: {
    icon() {
      // sortStatus = { sorted: Boolean, asc: Boolean }

      // if not sorted return base icon
      // if (!this.props.sortStatus.sorted) return "sort";

      // // return sort direction icon
      // return this.props.sortStatus.asc ? "sort-up" : "sort-down";
      
      if (!this.props.sortStatus.sorted) return `<span style="opacity: 0.3;">&#8593;</span><span style="opacity: 0.3;">&#8595;</span>`;
      return this.props.sortStatus.asc ? `<span style="opacity: 1;">&#8593;</span><span style="opacity: 0.3;">&#8595;</span>` : `<span style="opacity: 0.3;">&#8593;</span><span style="opacity: 1;">&#8595;</span>`;
      
    },
  },
};
</script>