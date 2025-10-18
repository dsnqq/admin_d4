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

<script setup>
import LayoutTableRow from '@/layouts/LayoutTableRow.vue';
import Pagination from '@/components/UI/BasePagination.vue';
import { DICTIONARY } from '@/constants/constants';
import { COLUMNS_MAIN } from '@/components/sparePartsStatistics/constants/constants';

import { useDevice } from '@/composables/useDevice';
import { computed, onMounted, ref } from 'vue';
import { useStore } from '@/composables/useStore';

const isMobile = useDevice();
const store = useStore();

const pageNum = ref(1);

onMounted(() => {
  store.dispatch(
    'sparePartsStatistics/GET_SPARE_PARTS_STATISTICS',
    pageNum.value,
  );
  store.dispatch('sparePartsStatistics/GET_SPARE_PARTS_STATISTICS_TOTALS');
});

const SPARE_PARTS_STATISTICS = computed(
  () => store.getters['sparePartsStatistics/TOTALS_SPARE_PARTS_STATISTICS'],
);
const TOTALS_SPARE_PARTS_STATISTICS = computed(
  () => store.getters['sparePartsStatistics/TOTALS_SPARE_PARTS_STATISTICS'],
);

const renderContentText = (content, type) => {
  return type === 'status' ? setStatusByApi(content) : content;
};

const setPageByTotal = (page) => {
  pageNum.value = page;
  store.dispatch(
    'sparePartsStatistics/GET_SPARE_PARTS_STATISTICS',
    pageNum.value,
  );
};

const setStatusByApi = (status) => {
  return status == 1 ? 'Активно' : 'Неактивно';
};
</script>

<style lang="scss" scoped>
@import './src/components/sparePartsStatistics/components/style/spare-parts-statistics-main';
</style>
