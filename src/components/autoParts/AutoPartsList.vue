<template>
  <LayoutDefault>
    <template #header>
      <Filters
        :options="optionsFilters"
        @setFilterOnAutoPartsPage="setFilterOnAutoPartsPage"
        @resetFilters="resetFilters"
      />
    </template>
    <template #tableThead>
      <th v-for="(c, index) in COLUMNS" :key="index">
        {{ c.title }}
      </th>
    </template>
    <template #tableTbody>
      <tr v-for="(auto, i) in AUTO_PARTS" :key="i">
        <td
          v-for="(c, index) in COLUMNS"
          :key="index"
          :data-th="c.title"
          :class="c.className"
        >
          <component
            :is="c.components"
            :id="auto.product_id"
            :images="auto.images"
            :title="auto.autoParts.name"
            :index="i"
            :show-all="auto.imagesShowAllImage"
            :content-the-note="auto.theNote"
            :content="auto[c.content]"
            :content-extension="auto[c.contentExtension]"
            :price-u-s-d="auto.priceUSD"
            :price-b-y-n="auto.priceBYN"
            :status="auto.status"
            :link-to-site="auto.linkToSite"
            :view="auto.view"
          ></component>
        </td>
      </tr>
    </template>
    <template #pagination>
      <Pagination
        :totals="AUTO_PARTS_TOTALS"
        :storage-cache="storageCache"
        :count-chunk="isMobile ? 4 : 5"
        :class="{ 'card-body-pagination-mobile': isMobile }"
        @setPageByTotal="setPageByTotal"
      />
      <BaseButtonFixedAdd component="autoPartsCreate" />
    </template>
  </LayoutDefault>
</template>

<script>
import LayoutDefault from '@/layouts/LayoutDefault.vue';
import { COLUMNS } from '@/components/autoParts/constants/constants';
import { autoPartsListOptionsFilters } from '@/components/autoParts/mixins/autoPartsListOptionsFilters.mixins';
import { mixins } from '@/mixins/mixins';
import { mapActions, mapGetters } from 'vuex';

export default {
  name: 'AutoPartsList',

  components: {
    LayoutDefault,
    Filters: () => import('@/components/UI/BaseFilters.vue'),
    BaseButtonFixedAdd: () => import('@/components/UI/BaseButtonFixedAdd.vue'),
    Pagination: () => import('@/components/UI/BasePagination.vue'),
  },

  mixins: [mixins, autoPartsListOptionsFilters],

  mounted() {
    this.GET_AUTO_PARTS_FROM_API(this.param);
    this.GET_AUTO_PARTS_TOTALS(this.param);
  },

  computed: {
    ...mapGetters('autoParts', ['AUTO_PARTS', 'AUTO_PARTS_TOTALS']),

    storageCache() {
      return localStorage.getItem('localCacheFilters') !== null
        ? JSON.parse(localStorage.localCacheFilters)
        : {};
    },
  },

  methods: {
    ...mapActions('autoParts', [
      'GET_AUTO_PARTS_FROM_API',
      'GET_AUTO_PARTS_TOTALS',
    ]),

    setFilterOnAutoPartsPage(param) {
      for (let key in param) {
        if (param[key] !== undefined) {
          this.param.filters[key] = param[key];
        }
      }

      this.GET_AUTO_PARTS_FROM_API(this.param);
      this.GET_AUTO_PARTS_TOTALS(this.param);
    },

    setPageByTotal(page) {
      this.param.pageNum = page;
      this.GET_AUTO_PARTS_FROM_API(this.param);
    },

    resetFilters() {
      this.param = {
        pageNum: this.param.pageNum,
        filters: {
          sparePartNumber: '',
          model: '',
          status: 'Все объявления',
          fuel: 'Не выбрано',
          value: '',
          yearStart: '',
          yearLast: '',
          types: {},
          car: {},
        },
      };

      this.GET_AUTO_PARTS_FROM_API(this.param);
      this.GET_AUTO_PARTS_TOTALS(this.param);
    },
  },

  data() {
    return {
      COLUMNS,
      param: {
        pageNum: 1,
        filters: {
          sparePartNumber: '',
          model: '',
          status: 'Все объявления',
          fuel: 'Не выбрано',
          value: '',
          yearStart: '',
          yearLast: '',
          types: {},
          car: {},
        },
      },
    };
  },
};
</script>

<style lang="scss" scoped>
@import './src/components/autoParts/style/auto-parts-list';
</style>
