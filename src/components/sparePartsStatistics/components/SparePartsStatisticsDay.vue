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
                v-for="(sparePartsStatisticsDay, i) in SPARE_PARTS_STATISTICS_DAY"
                :key="i"
            >
              <td>
                {{sparePartsStatisticsDay.date}}
              </td>
              <td>
                {{sparePartsStatisticsDay.count}} шт.
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
  name: "SparePartsStatisticsDay",

  mounted() {
    this.GET_SPARE_PARTS_STATISTICS_DAY();
  },

  computed: {
    ...mapGetters('sparePartsStatistics', [
      'SPARE_PARTS_STATISTICS_DAY'
    ])
  },

  methods: {
    ...mapActions('sparePartsStatistics', [
      'GET_SPARE_PARTS_STATISTICS_DAY'
    ]),
  },
}
</script>