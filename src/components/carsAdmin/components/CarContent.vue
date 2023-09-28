<template>
  <div class="car-content">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="table-responsive">
            <table class="table align-middle table-striped">
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
          <pagination
              v-model="pageNum"
              :records="getCarsTotals"
              :per-page="10"
              @paginate="setPageByTotal"
              :options="paginationOptions"
          ></pagination>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import CarListItem from './CarListItem.vue';
import CarListItemHead from "./CarListItemHead.vue";
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
        chunk: 6,
        texts: {
          count: 'Отображается с {from} по {to} (всего {count} шт.)|{count}',
        }
      },
    };
  }
}
</script>