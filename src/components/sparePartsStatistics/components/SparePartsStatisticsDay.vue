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
      <tr v-for="(item, i) in sparePartsStatisticsDay" :key="i">
        <td v-for="(c, index) in COLUMNS_DAY" :key="index" :data-th="c.title">
          {{ item[c.content] + c.prefix }}
        </td>
      </tr>
    </template>
  </LayoutTableRow>
</template>

<script setup>
import { COLUMNS_DAY } from '@/components/sparePartsStatistics/constants/constants';
import { DICTIONARY } from '@/constants/constants';
import LayoutTableRow from '@/layouts/LayoutTableRow.vue';
import { computed, onMounted } from 'vue';
import { useStore } from '@/composables/useStore';

const store = useStore();

onMounted(() => {
  store.dispatch('sparePartsStatistics/GET_SPARE_PARTS_STATISTICS_DAY');
});

const sparePartsStatisticsDay = computed(
  () => store.getters['sparePartsStatistics/SPARE_PARTS_STATISTICS_DAY'],
);
</script>
