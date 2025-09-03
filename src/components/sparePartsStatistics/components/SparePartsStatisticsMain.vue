<template>
  <LayoutTableRow>
    <template #header>
      <h6 class="mb-0 text-uppercase">
        {{ DICTIONARY.pageStatisticsSpareParts }}
      </h6>
    </template>
    <template #tableThead>
      <th v-for="(c, index) in COLUMNS_MAIN" :key="index" scope="col">
        {{ c.title }}
      </th>
    </template>
    <template #tableTbody>
      <tr
        v-for="(sparePartsStatisticsItem, i) in SPARE_PARTS_STATISTICS"
        :key="i"
      >
        <td v-for="(c, index) in COLUMNS_MAIN" :key="index" :data-th="c.title">
          {{
            renderContentText(sparePartsStatisticsItem[c.content], c.content)
          }}
        </td>
      </tr>
    </template>
    <template #pagination>
      <Pagination
        :totals="TOTALS_SPARE_PARTS_STATISTICS"
        :count-chunk="isMobile ? 4 : 5"
        :class="{ 'card-body-pagination-mobile': isMobile }"
        @setPageByTotal="setPageByTotal"
      />
    </template>
  </LayoutTableRow>
</template>

<script>
import LayoutTableRow from '@/layouts/LayoutTableRow.vue';
import Pagination from '@/components/UI/BasePagination.vue';
import { mapActions, mapGetters } from 'vuex';
import { DICTIONARY, DOMAIN } from '@/constants/constants';
import { mixins } from '@/mixins/mixins';
import { COLUMNS_MAIN } from '@/components/sparePartsStatistics/constants/constants';

export default {
  name: 'SparePartsStatisticsMain',

  components: {
    Pagination,
    LayoutTableRow,
  },

  mixins: [mixins],

  mounted() {
    this.GET_SPARE_PARTS_STATISTICS(this.pageNum);
    this.GET_SPARE_PARTS_STATISTICS_TOTALS();
  },

  computed: {
    ...mapGetters('sparePartsStatistics', [
      'SPARE_PARTS_STATISTICS',
      'TOTALS_SPARE_PARTS_STATISTICS',
    ]),
  },

  methods: {
    ...mapActions('sparePartsStatistics', [
      'GET_SPARE_PARTS_STATISTICS',
      'GET_SPARE_PARTS_STATISTICS_TOTALS',
    ]),

    renderContentText(content, type) {
      return type == 'status' ? this.setStatusByApi(content) : content;
    },

    setPageByTotal(page) {
      this.pageNum = page;
      this.GET_SPARE_PARTS_STATISTICS(this.pageNum);
    },

    setStatusByApi(status) {
      return status == 1 ? 'Активно' : 'Неактивно';
    },
  },

  data() {
    return {
      DOMAIN,
      DICTIONARY,
      COLUMNS_MAIN,
      pageNum: 1,
    };
  },
};
</script>

<style lang="scss" scoped>
@import './src/components/sparePartsStatistics/components/style/spare-parts-statistics-main';
</style>
