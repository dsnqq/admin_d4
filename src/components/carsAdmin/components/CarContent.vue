<template>
  <div class="car-content">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="table-responsive">
            <table class="table align-middle table-striped rwd-table">
              <thead>
                <CarListItemHead
                    class="car-list__head"
                />
              </thead>
              <tbody>
                <CarListItem
                    v-for="(carItem, i) in CARS"
                    :key="i"
                    :number="i"
                    :store="carItem"
                />
              </tbody>
            </table>
          </div>
        </div>
        <Pagination
            :totals="TOTALS"
            @setPageByTotal="setPageByTotal"
        />
      </div>
    </div>
  </div>
</template>

<script>
import Pagination from "@/components/UI/BasePagination.vue";
import CarListItem from '@/components/carsAdmin/components/CarListItem.vue';
import CarListItemHead from "@/components/carsAdmin/components/CarListItemHead.vue";
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
@import "@/assets/scss/table-adaptive.scss";
</style>
