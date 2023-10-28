<template>
  <div class="app-car-dismantling">
    <div class="app-car-dismantling__car car">
      <div class="car-content">
        <div class="card">
          <div class="card-body">
            <div class="row">
                <table class="table align-middle table-striped table-border-1 rwd-table middle-responsive">
                  <thead>
                    <CarListItemHead
                        class="car-list__head"
                    />
                  </thead>
                  <tbody class="card-body__grid">
                    <CarListItem
                        v-for="(carItem, i) in CARS"
                        :key="i"
                        :number="i"
                        :store="carItem"
                    />
                  </tbody>
                </table>
            </div>
            <Pagination
                :totals="TOTALS"
                @setPageByTotal="setPageByTotal"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Pagination from "@/components/UI/BasePagination.vue";
import CarListItem from '@/components/carsAdmin/CarListItem.vue';
import CarListItemHead from "@/components/carsAdmin/CarListItemHead.vue";
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
    ]),
  },

  methods: {
    setPageByTotal(page) {
      this.pageNum = page;
      this.GET_CARS_FROM_API(this.pageNum);
    },

    ...mapActions('carAdmin', [
      'GET_CARS_FROM_API',
      'GET_CARS_TOTALS_FROM_API'
    ]),
  },

  components: {
    CarListItemHead,
    CarListItem,
    Pagination
  },

  data() {
    return {
      pageNum: 1,
    };
  }
}
</script>

<style lang="scss">
@import "@/components/carsAdmin/style/car-content.scss";
@import "@/assets/scss/table-adaptive.scss";
</style>
