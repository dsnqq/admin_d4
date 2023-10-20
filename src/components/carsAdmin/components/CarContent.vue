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
        <div
            v-if="this.TOTALS > 10"
            class="row"
        >
          <v-pagination
              v-model="pageNum"
              :records="getCarsTotals"
              :per-page="10"
              @paginate="setPageByTotal"
              :options="paginationOptions"
          ></v-pagination>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
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

    getCarsTotals() {
      return parseInt(this.TOTALS);
    }
  },

  methods: {
    setPageByTotal(page) {
      this.pageNum = page;
      window.scrollTo(0, 0);
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
  },

  data() {
    return {
      pageNum: 1,
      paginationOptions: {
        chunk: 5,
        texts: {
          count: 'Отображается с {from} по {to} (всего {count} шт.)|{count}',
        }
      },
    };
  }
}
</script>

<style lang="scss">
@import "@/assets/scss/table-adaptive.scss";
</style>
