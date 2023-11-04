<template>
  <LayoutDefault>
    <template v-slot:tableThead>
        <th
            v-for="(column, index) in COLUMNS"
            :key="index"
        >
          {{column.title}}
        </th>
    </template>
    <template v-slot:tableTbody>
      <tr
          v-for="(autoTireArchive, i) in AUTO_TIRES_ARCHIVE"
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
              :images="autoTireArchive.images"
              :title="autoTireArchive.name"
              :index="i"
              :id="autoTireArchive.product_id"
              :showAll="autoTireArchive.imagesShowAllImage"
              :content="autoTireArchive[c.content]"
              :contentExtension="autoTireArchive[c.contentExtension]"
              :priceUSD="autoTireArchive.priceUSD"
          ></component>
        </td>
      </tr>
    </template>
    <template v-slot:pagination>
      <Pagination
          :totals="AUTO_TIRES_ARCHIVE_TOTALS"
          :countChunk="isMobile ? 4 : 5"
          @setPageByTotal="setPageByTotal"
          :class="{'card-body-pagination-mobile' : isMobile}"
      />
    </template>
  </LayoutDefault>
</template>

<script>
import Pagination from "@/components/UI/BasePagination.vue";
import LayoutDefault from "@/layouts/LayoutDefault.vue";
import {mapActions, mapGetters} from "vuex";
import {mixins} from "@/mixins/mixins";
import {COLUMNS} from "@/components/autoTiresArchive/constants/constants";

export default {
  name: "AutoTiresArchiveList",

  mounted() {
    this.GET_AUTO_TIRES_ARCHIVE_FROM_API(this.param.pageNum);
    this.GET_AUTO_TIRES_ARCHIVE_TOTALS();
  },

  mixins: [mixins],

  components: {
    LayoutDefault,
    Pagination
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
  }

}
</script>

<style lang="scss" scoped>
@import "./src/components/autoTiresArchive/style/auto-tires-archive-list";
</style>
