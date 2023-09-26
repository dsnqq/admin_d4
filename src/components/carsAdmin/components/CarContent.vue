<template>
  <div class="car-content">
    <div class="car-content__header car-content-header">
      <CarPagination
          v-if="TOTALS > 10"
          :pageNum="pageNum"
          :totals="TOTALS"
          @setPageByTotal="setPageByTotal"
          class="car-list-header__pagination"
      />
      <CarListTotals
          class="car-list-header__totals"
      />
    </div>
    <CarListFilter
        class="car-content__filter"
    />
    <div class="car-content__list car-list">
      <CarListItemHead
          class="car-list__head"
      />
      <CarListItem
          class="car-list__wrapper car-list-wrapper"
          v-for="(carItem, i) in CARS"
          :key="i"
          :number="i"
          :store="carItem"
      />
    </div>
  </div>
</template>

<script>
import CarListItem from './CarListItem.vue';
import CarListFilter from "./CarListFilter.vue";
import CarPagination from "../UI/CarPagination.vue";
import CarListItemHead from "./CarListItemHead.vue";
import CarListTotals from "./CarListTotals.vue";
import {mapActions, mapGetters} from "vuex";

export default {
  name: "CarContent",

  mounted() {
    this.GET_CARS_FROM_API(this.pageNum);
    this.GET_CARS_TOTALS_FROM_API();
  },

  computed: {
    ...mapGetters('carAdmin', [
        'CARS',
        'TOTALS'
    ])
  },

  methods: {
    setPageByTotal: function(page) {
      this.pageNum = page;
      this.GET_CARS_FROM_API(this.pageNum);
    },

    ...mapActions('carAdmin', [
      'GET_CARS_FROM_API',
      'GET_CARS_TOTALS_FROM_API'
    ]),
  },

  components: {
    CarListTotals,
    CarListItemHead,
    CarListFilter,
    CarPagination,
    CarListItem,
  },

  data() {
    return {
      pageNum: 1
    };
  }
}
</script>

<style scoped lang="scss">
@import "./src/components/carsAdmin/style/car-list.scss";
</style>