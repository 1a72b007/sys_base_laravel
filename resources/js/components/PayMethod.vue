<template>
  <div class="row">
      <div v-for="(value, index) in list" v-bind:key="value.id" class="col-sm-3 col-lg-3">
          <div class="card text-center">
            <div :class="{ 'text-white bg-info': index % 2 != 0 }">
                  <div class="medium py-2 text-uppercase font-weight-bold">{{value.title}}</div>
                  <div class="text-value-xl py-2">{{value.value}} 元</div>
            </div>
          </div>
      </div>
  </div>
</template>

<script>
  export default {
    name: "PayMethod",
    props: ["list"],
    data() {
      return {
      };
    },
    mounted() {
        console.log(this.list)
    }
  }
</script>
