<template>
  <LayoutTableRow>
    <template #header>
      <h6 class="mb-0 text-uppercase">
        {{ DICTIONARY.pageStatistics }}
      </h6>
    </template>
    <template #tableThead>
      <th v-for="(c, index) in COLUMNS_DAY" :key="index" scope="col">
        {{ c.title }}
      </th>
    </template>
    <template #tableTbody>
      <tr v-for="(tireStatisticsDay, i) in TIRE_STATISTICS_DAY" :key="i">
        <td v-for="(c, index) in COLUMNS_DAY" :key="index" :data-th="c.title">
          {{ tireStatisticsDay[c.content] + c.prefix }}
        </td>
      </tr>
    </template>
  </LayoutTableRow>
</template>

<script>
import { COLUMNS_DAY } from '@/components/tireStatistics/constants/constants';
import LayoutTableRow from '@/layouts/LayoutTableRow.vue';
import { DICTIONARY } from '@/constants/constants';
import { mapActions, mapGetters } from 'vuex';

export default {
  name: 'TireStatisticsDay',

  components: {
    LayoutTableRow,
  },

  mounted() {
    this.GET_TIRE_STATISTICS_DAY();
  },

  computed: {
    ...mapGetters('tireStatistics', ['TIRE_STATISTICS_DAY']),
  },

  methods: {
    ...mapActions('tireStatistics', ['GET_TIRE_STATISTICS_DAY']),
  },

  data() {
    return {
      COLUMNS_DAY,
      DICTIONARY,
    };
  },
};
</script>
