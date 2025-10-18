<template>
  <LayoutTableRow>
    <template #header>
      <h6 class="mb-0 text-uppercase">
        {{ DICTIONARY.pageStatisticsTires }}
      </h6>
    </template>
    <template #tableThead>
      <th v-for="(c, index) in COLUMNS_MAIN" :key="index" scope="col">
        {{ c.title }}
      </th>
    </template>
    <template #tableTbody>
      <tr v-for="(tireStatisticsItem, i) in tireStatistics" :key="i">
        <td v-for="(c, index) in COLUMNS_MAIN" :key="index" :data-th="c.title">
          {{ renderContentText(tireStatisticsItem[c.content], c.content) }}
        </td>
      </tr>
    </template>
    <template #pagination>
      <Pagination
        :count-chunk="isMobile ? 4 : 5"
        :class="{ 'card-body-pagination-mobile': isMobile }"
        :totals="totalsTireStatistics"
        @setPageByTotal="setPageByTotal"
      />
    </template>
  </LayoutTableRow>
</template>

<script setup>
import { COLUMNS_MAIN } from '@/components/tireStatistics/constants/constants';
import { DICTIONARY } from '@/constants/constants';
import LayoutTableRow from '@/layouts/LayoutTableRow';
import Pagination from '@/components/UI/BasePagination';
import { computed, onMounted, ref } from 'vue';
import { useStore } from '@/composables/useStore';
import { useDevice } from '@/composables/useDevice';

const store = useStore();
const pageNum = ref(1);
const isMobile = useDevice();

onMounted(() => {
  store.dispatch('tireStatistics/GET_TIRE_STATISTICS', pageNum.value);
  store.dispatch('tireStatistics/GET_TIRE_STATISTICS_TOTALS');
});

const renderContentText = (content, type) => {
  return type == 'status' ? setStatusByApi(content) : content;
};

const setStatusByApi = (status) => (status == 1 ? 'Активно' : 'Неактивно');

const setPageByTotal = (page) => {
  pageNum.value = page;
  store.dispatch('tireStatistics/GET_TIRE_STATISTICS', pageNum.value);
};

const tireStatistics = computed(
  () => store.getters['tireStatistics/TIRE_STATISTICS'],
);
const totalsTireStatistics = computed(
  () => store.getters['tireStatistics/TOTALS_TIRE_STATISTICS'],
);
</script>

<style lang="scss" scoped>
@import './src/components/tireStatistics/components/style/tire-statistics-main';
</style>
