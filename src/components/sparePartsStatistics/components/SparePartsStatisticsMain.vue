<template>
  <LayoutDefault>
    <template v-slot:header>
      <h6 class="mb-0 text-uppercase">
        Статистика просмотров З/Ч
      </h6>
    </template>
    <template v-slot:tableThead>
      <tr>
        <th scope="col">Дата</th>
        <th scope="col">Название</th>
        <th scope="col">Артикул</th>
        <th scope="col">Статус З/Ч</th>
        <th scope="col">Кол-во просмотров</th>
        <th scope="col">Действие</th>
      </tr>
    </template>
    <template v-slot:tableTbody>
      <tr
          v-for="(sparePartsStatisticsItem, i) in SPARE_PARTS_STATISTICS"
          :key="i"
      >
        <td data-th="Дата">
          {{ sparePartsStatisticsItem.date }}
        </td>
        <td data-th="Название">
          {{ sparePartsStatisticsItem.name }}
        </td>
        <td data-th="Артикул">
          {{ sparePartsStatisticsItem.article }}
        </td>
        <td data-th="Статус З/Ч">
          {{ setStatusByApi(sparePartsStatisticsItem.status) }}
        </td>
        <td data-th="Кол-во просмотров">
          {{ sparePartsStatisticsItem.views }}
        </td>
        <td data-th="Действие">
          <a
              target="_blank"
              class="p-2 text-primary"
              :href="DOMAIN + sparePartsStatisticsItem.linkSite"
          >
            <i class="bx bx-show"></i>
          </a>
          <router-link
              :to="{name: 'autoPartsDetail', params: {id: sparePartsStatisticsItem.product_id}}"
              target="_blank"
              class="p-2 text-warning cursor-pointer"
          >
            <i class="bx bx-pencil"></i>
          </router-link>
        </td>
      </tr>
    </template>
    <template v-slot:pagination>
      <Pagination
          :totals="TOTALS_SPARE_PARTS_STATISTICS"
          @setPageByTotal="setPageByTotal"
          :countChunk="isMobile ? 4 : 5"
          :class="{'card-body-pagination-mobile' : isMobile}"
      />
    </template>
  </LayoutDefault>
</template>

<script>
  import LayoutDefault from "@/layouts/LayoutDefault.vue";
  import Pagination from "@/components/UI/BasePagination.vue";
  import {mapActions, mapGetters} from "vuex";
  import {DOMAIN} from "@/constants/constants";
  import {mixins} from "@/mixins/mixins";

  export default {
    name: "SparePartsStatisticsMain",

    mounted() {
      this.GET_SPARE_PARTS_STATISTICS(this.pageNum);
      this.GET_SPARE_PARTS_STATISTICS_TOTALS();
    },

    mixins: [mixins],

    components: {
      Pagination,
      LayoutDefault
    },

    computed: {
      ...mapGetters('sparePartsStatistics', [
        'SPARE_PARTS_STATISTICS',
        'TOTALS_SPARE_PARTS_STATISTICS'
      ]),
    },


    methods: {
      ...mapActions('sparePartsStatistics', [
        'GET_SPARE_PARTS_STATISTICS',
        'GET_SPARE_PARTS_STATISTICS_TOTALS'
      ]),

      setPageByTotal(page) {
        this.pageNum = page;
        this.GET_SPARE_PARTS_STATISTICS(this.pageNum);
      },

      setStatusByApi(status) {
        return (status == 1) ? 'Активно' : 'Неактивно';
      },
    },

    data() {
      return {
        DOMAIN,
        pageNum: 1,
      };
    }
  }
</script>

<style lang="scss" scoped>
@import "./src/components/sparePartsStatistics/components/style/spare-parts-statistics-main";
</style>