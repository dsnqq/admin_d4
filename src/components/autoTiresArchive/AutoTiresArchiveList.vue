<template>
  <LayoutDefault>
    <template #tableThead>
      <th v-for="(column, index) in COLUMNS" :key="index">
        {{ column.title }}
      </th>
    </template>
    <template #tableTbody>
      <AutoTiresArchiveListRow
        v-for="(autoTireArchive, i) in autoTiresArchive"
        :key="i"
      >
        <td
          v-for="(c, index) in COLUMNS"
          :key="index"
          :data-th="c.title"
          :class="c.className"
        >
          <component
            :is="c.components"
            :id="autoTireArchive.product_id"
            :images="autoTireArchive.images"
            :title="autoTireArchive.name"
            :index="i"
            :show-all="autoTireArchive.imagesShowAllImage"
            :content="autoTireArchive[c.content]"
            :content-extension="autoTireArchive[c.contentExtension]"
            :price-u-s-d="autoTireArchive.priceUSD"
          ></component>
        </td>
      </AutoTiresArchiveListRow>
    </template>
    <template #pagination>
      <Pagination
        :totals="autoTiresArchiveTotals"
        :count-chunk="isMobile ? 4 : 5"
        :class="{ 'card-body-pagination-mobile': isMobile }"
        @setPageByTotal="setPageByTotal"
      />
    </template>
  </LayoutDefault>
</template>

<script setup>
import Pagination from '@/components/UI/BasePagination';
import LayoutDefault from '@/layouts/LayoutDefault';
import AutoTiresArchiveListRow from '@/components/autoTiresArchive/AutoTiresArchiveListRow.vue';
import { COLUMNS } from '@/components/autoTiresArchive/constants/constants';
import { useDevice } from '@/composables/useDevice';
import { useStore } from '@/composables/useStore';
import { computed, onMounted, ref } from 'vue';

const isMobile = useDevice();
const store = useStore();

const param = ref({
  pageNum: 1,
});

onMounted(() => {
  store.dispatch(
    'autoTiresArchive/GET_AUTO_TIRES_ARCHIVE_FROM_API',
    param.value.pageNum,
  );
  store.dispatch('autoTiresArchive/GET_AUTO_TIRES_ARCHIVE_TOTALS');
});

const autoTiresArchive = computed(
  () => store.getters['autoTiresArchive/AUTO_TIRES_ARCHIVE'],
);
const autoTiresArchiveTotals = computed(
  () => store.getters['autoTiresArchive/AUTO_TIRES_ARCHIVE_TOTALS'],
);

const setPageByTotal = (page) => {
  param.value.pageNum = page;

  store.dispatch(
    'autoTiresArchive/GET_AUTO_TIRES_ARCHIVE_FROM_API',
    param.value.pageNum,
  );
};
</script>

<style lang="scss" scoped>
@import './src/components/autoTiresArchive/style/auto-tires-archive-list';
</style>
