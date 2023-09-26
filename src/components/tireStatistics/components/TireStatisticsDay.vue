<template>
  <div>
    <h6 class="mb-0 text-uppercase">Статистика по датам</h6>
    <hr>
    <div class="card">
      <div class="card-body">
        <div class="row">
          <table class="table mb-0 table-border-1">
            <thead>
            <tr>
              <th scope="col">Дата</th>
              <th scope="col">Количество просмотров</th>
            </tr>
            </thead>
            <tbody>
            <tr
                v-for="(tireStatisticsDay, i) in TIRE_STATISTICS_DAY"
                :key="i"
            >
              <td>
                {{tireStatisticsDay.date}}
              </td>
              <td>
                {{tireStatisticsDay.count}} шт.
              </td>
            </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
  name: "TireStatisticsDay",

  mounted() {
    this.GET_TIRE_STATISTICS_DAY();
  },

  computed: {
    ...mapGetters('tireStatistics', [
      'TIRE_STATISTICS_DAY'
    ])
  },

  methods: {
    ...mapActions('tireStatistics', [
      'GET_TIRE_STATISTICS_DAY'
    ]),
  },
}
</script>

<style lang="scss" scoped>
@import "./src/components/tireStatistics/components/style/tire-statistics-day";
</style>