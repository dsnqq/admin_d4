<template>
  <LayoutDefault>
    <template v-slot:header>
      <Filters
          :options="optionsFilters"
          @setFilterOnAutoPartsPage="setFilterOnAutoPartsPage"
          @resetFilters="resetFilters"
      />
    </template>
    <template v-slot:tableThead>
      <th
          v-for="(c, index) in COLUMNS"
          :key="index"
      >
        {{c.title}}
      </th>
    </template>
    <template v-slot:tableTbody>
      <tr
          v-for="(autoPartsArchive, i) in AUTO_PARTS_ARCHIVE"
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
              :images="autoPartsArchive.images"
              :title="autoPartsArchive.autoParts.name"
              :index="i"
              :id="autoPartsArchive.product_id"
              :showAll="autoPartsArchive.imagesShowAllImage"
              :content="autoPartsArchive[c.content]"
              :contentExtension="autoPartsArchive[c.contentExtension]"
              :priceUSD="autoPartsArchive.priceUSD"
              :priceBYN="autoPartsArchive.priceBYN"
              :status="autoPartsArchive.status"
              :linkToSite="autoPartsArchive.linkToSite"
              :view="autoPartsArchive.view"
          ></component>
        </td>
      </tr>
    </template>
    <template v-slot:pagination>
      <Pagination
          :totals="AUTO_PARTS_ARCHIVE_TOTALS"
          :countChunk="isMobile ? 4 : 5"
          @setPageByTotal="setPageByTotal"
          :class="{'card-body-pagination-mobile' : isMobile}"
      />
    </template>
  </LayoutDefault>
</template>

<script>
import LayoutDefault from "@/layouts/LayoutDefault.vue";
import Filters from "@/components/UI/BaseFilters.vue";
import Pagination from "@/components/UI/BasePagination.vue";
import {COLUMNS} from "@/components/autoPartsArchive/constants/constants";
import {mapActions, mapGetters} from "vuex";
import {mixins} from "@/mixins/mixins";
import {autoPartsArchiveListOptionsFilters} from "@/components/autoPartsArchive/mixins/autoPartsArchiveListOptionsFilters.mixins";

export default {
  name: "AutoPartsArchiveList",

  mixins: [autoPartsArchiveListOptionsFilters, mixins],

  mounted() {
    this.loadAutoPartsArchive();
  },

  components: {
    Pagination,
    Filters,
    LayoutDefault
  },

  computed: {
    ...mapGetters('autoPartsArchive', [
      'AUTO_PARTS_ARCHIVE',
      'AUTO_PARTS_ARCHIVE_TOTALS'
    ]),
  },

  methods: {
    ...mapActions('autoPartsArchive', [
      'GET_AUTO_PARTS_ARCHIVE_FROM_API',
      'GET_AUTO_PARTS_ARCHIVE_TOTALS'
    ]),

    loadAutoPartsArchive() {
      this.GET_AUTO_PARTS_ARCHIVE_FROM_API(this.param);
      this.GET_AUTO_PARTS_ARCHIVE_TOTALS(this.param);
    },

    setPageByTotal(page) {
      this.param.pageNum = page;
      this.GET_AUTO_PARTS_ARCHIVE_FROM_API(this.param);
    },

    setFilterOnAutoPartsPage(param) {
      for (let key in param) {
        if(param[key] !== undefined) {
          this.param.filters[key] = param[key];
        }
      }

      this.loadAutoPartsArchive();
    },

    resetFilters() {
      this.param = {
        pageNum: this.param.pageNum,
        filters: {
          sparePartNumber: '',
          model: '',
          fuel: 'Не выбрано',
          value: '',
          yearStart: '',
          yearLast: '',
          types: {},
          car: {},
        }
      }

      this.loadAutoPartsArchive();
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
        }
      },
    };
  }

}
</script>

<style lang="scss" scoped>
@import "@/components/autoPartsArchive/style/auto-parts-archive-list.scss";
</style>
