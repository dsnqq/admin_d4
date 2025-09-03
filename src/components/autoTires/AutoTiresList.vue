<template>
  <LayoutDefault>
    <template #tableThead>
      <th v-for="(c, index) in COLUMNS" :key="index">
        {{ c.title }}
      </th>
    </template>
    <template #tableTbody>
      <tr v-for="(autoTire, i) in AUTO_TIRES" :key="i">
        <td
          v-for="(c, index) in COLUMNS"
          :key="index"
          :data-th="c.title"
          :class="c.className"
        >
          <component
            :is="c.components"
            :id="autoTire.product_id"
            :images="autoTire.images"
            :title="autoTire.name"
            :index="i"
            :show-all="autoTire.imagesShowAllImage"
            :content="autoTire[c.content]"
            :content-extension="autoTire[c.contentExtension]"
            :price-u-s-d="autoTire.priceUSD"
            :price-b-y-n="autoTire.priceBYN"
            :status="autoTire.status"
            :link-to-site="autoTire.linkToSite"
          ></component>
        </td>
      </tr>
    </template>
    <template #pagination>
      <Pagination
        :totals="AUTO_TIRES_TOTALS"
        :count-chunk="isMobile ? 4 : 5"
        :class="{ 'card-body-pagination-mobile': isMobile }"
        @setPageByTotal="setPageByTotal"
      />
      <BaseButtonFixedAdd component="autoTiresCreate" />
    </template>
  </LayoutDefault>
</template>

<script>
import LayoutDefault from '@/layouts/LayoutDefault.vue';
import { COLUMNS } from '@/components/autoTires/constants/constants';
import Pagination from '@/components/UI/BasePagination.vue';
import { mapActions, mapGetters } from 'vuex';
import { mixins } from '@/mixins/mixins';

export default {
  name: 'AutoTiresList',

  components: {
    Pagination,
    LayoutDefault,
    BaseButtonFixedAdd: () => import('@/components/UI/BaseButtonFixedAdd.vue'),
  },

  mixins: [mixins],

  mounted() {
    this.GET_AUTO_TIRES_FROM_API(this.param.pageNum);
    this.GET_AUTO_TIRES_TOTALS();
  },

  computed: {
    ...mapGetters('autoTires', ['AUTO_TIRES', 'AUTO_TIRES_TOTALS']),
  },

  methods: {
    ...mapActions('autoTires', [
      'GET_AUTO_TIRES_FROM_API',
      'GET_AUTO_TIRES_TOTALS',
    ]),

    setPageByTotal(page) {
      this.param.pageNum = page;
      this.GET_AUTO_TIRES_FROM_API(this.param.pageNum);
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
@import '@/components/autoTires/style/auto-tires-list.scss';
</style>
