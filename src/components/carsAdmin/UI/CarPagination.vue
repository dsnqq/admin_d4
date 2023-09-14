<template>
  <ul
      class="pagination"
  >
    <li
        v-for="(total, index) in totals"
        :key="index"
        :class="{'active': index + 1 == pageNum}"
    >
      <a
          v-on:click.prevent="setPageByTotal(index)"
      >{{index + 1}}</a>
    </li>
  </ul>
</template>

<script>
  export default {
    name: "CarPagination",

    methods: {
      setPageByTotal: function (total) {
        let param = total + 1;
        this.$emit('setPageByTotal', param);
      }
    },

    props: {
      pageNum: {
        type: Number,
      },

      totals: {
        type: String,
      }
    }
  }
</script>

<style scoped lang="scss">
@import "./src/components/carsAdmin/style/ui/pagination.scss";
</style>