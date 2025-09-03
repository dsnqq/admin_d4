<template>
  <LayoutDefault>
    <template #tableThead>
      <th v-for="(column, index) in COLUMNS" :key="index">
        {{ column.title }}
      </th>
    </template>
    <template #tableTbody>
      <tr v-for="(autoTireArchive, i) in AUTO_TIRES_ARCHIVE" :key="i">
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
      </tr>
    </template>
    <template #pagination>
      <Pagination
        :totals="AUTO_TIRES_ARCHIVE_TOTALS"
        :count-chunk="isMobile ? 4 : 5"
        :class="{ 'card-body-pagination-mobile': isMobile }"
        @setPageByTotal="setPageByTotal"
      />
    </template>
  </LayoutDefault>
</template>

<script>
import Pagination from '@/components/UI/BasePagination.vue';
import LayoutDefault from '@/layouts/LayoutDefault.vue';
import { mapActions, mapGetters } from 'vuex';
import { mixins } from '@/mixins/mixins';
import { COLUMNS } from '@/components/autoTiresArchive/constants/constants';

export default {
  name: 'AutoTiresArchiveList',

  components: {
    LayoutDefault,
    Pagination,
  },

  mixins: [mixins],

  mounted() {
    this.GET_AUTO_TIRES_ARCHIVE_FROM_API(this.param.pageNum);
    this.GET_AUTO_TIRES_ARCHIVE_TOTALS();
  },

  computed: {
    ...mapGetters('autoTiresArchive', [
      'AUTO_TIRES_ARCHIVE',
      'AUTO_TIRES_ARCHIVE_TOTALS',
    ]),
  },

  methods: {
    ...mapActions('autoTiresArchive', [
      'GET_AUTO_TIRES_ARCHIVE_FROM_API',
      'GET_AUTO_TIRES_ARCHIVE_TOTALS',
    ]),

    setPageByTotal(page) {
      this.param.pageNum = page;
      this.GET_AUTO_TIRES_ARCHIVE_FROM_API(this.param.pageNum);
    },
  },

  data() {
    return {
      COLUMNS,
      param: {
        pageNum: 1,
      },
    };
  },
};
</script>

<style lang="scss" scoped>
@import './src/components/autoTiresArchive/style/auto-tires-archive-list';
</style>
