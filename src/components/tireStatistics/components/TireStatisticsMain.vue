<template>
  <LayoutTableRow>
    <template v-slot:header>
      <h6 class="mb-0 text-uppercase">
        {{ DICTIONARY.pageStatisticsTires }}
      </h6>
    </template>
    <template v-slot:tableThead>
      <th v-for="(c, index) in COLUMNS_MAIN" :key="index" scope="col">
        {{ c.title }}
      </th>
    </template>
    <template v-slot:tableTbody>
      <tr v-for="(tireStatisticsItem, i) in TIRE_STATISTICS" :key="i">
        <td v-for="(c, index) in COLUMNS_MAIN" :key="index" :data-th="c.title">
          {{ renderContentText(tireStatisticsItem[c.content], c.content) }}
        </td>
      </tr>
    </template>
    <template v-slot:pagination>
      <Pagination
        :countChunk="isMobile ? 4 : 5"
        :class="{ 'card-body-pagination-mobile': isMobile }"
        :totals="TOTALS_TIRE_STATISTICS"
        @setPageByTotal="setPageByTotal"
      />
    </template>
  </LayoutTableRow>
</template>

<script>
import { COLUMNS_MAIN } from "@/components/tireStatistics/constants/constants";
import { DICTIONARY } from "@/constants/constants";
import LayoutTableRow from "@/layouts/LayoutTableRow.vue";
import Pagination from "@/components/UI/BasePagination.vue";
import { mixins } from "@/mixins/mixins";
import { mapActions, mapGetters } from "vuex";
import { DOMAIN } from "@/constants/constants";

export default {
  name: "TireStatisticsMain",

  mounted() {
    this.GET_TIRE_STATISTICS(this.pageNum);
    this.GET_TIRE_STATISTICS_TOTALS();
  },

  mixins: [mixins],

  components: {
    Pagination,
    LayoutTableRow,
  },

  computed: {
    ...mapGetters("tireStatistics", [
      "TIRE_STATISTICS",
      "TOTALS_TIRE_STATISTICS",
    ]),
  },

  methods: {
    ...mapActions("tireStatistics", [
      "GET_TIRE_STATISTICS",
      "GET_TIRE_STATISTICS_TOTALS",
    ]),

    renderContentText(content, type) {
      return type == "status" ? this.setStatusByApi(content) : content;
    },

    setPageByTotal(page) {
      this.pageNum = page;
      this.GET_TIRE_STATISTICS(this.pageNum);
    },

    setStatusByApi(status) {
      return status == 1 ? "Активно" : "Неактивно";
    },
  },

  data() {
    return {
      DOMAIN,
      COLUMNS_MAIN,
      DICTIONARY,
      pageNum: 1,
    };
  },
};
</script>

<style lang="scss" scoped>
@import "./src/components/tireStatistics/components/style/tire-statistics-main";
</style>
