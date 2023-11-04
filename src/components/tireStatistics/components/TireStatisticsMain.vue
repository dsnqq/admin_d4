<template>
  <LayoutDefault>
    <template v-slot:header>
      <h6 class="mb-0 text-uppercase">
        Статистика просмотров шин
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
          v-for="(tireStatisticsItem, i) in TIRE_STATISTICS"
          :key="i"
      >
        <td data-th="Дата">
          {{ tireStatisticsItem.date }}
        </td>
        <td data-th="Название">
          {{ tireStatisticsItem.name }}
        </td>
        <td data-th="Артикул">
          {{ tireStatisticsItem.article }}
        </td>
        <td data-th="Статус З/Ч">
          {{ setStatusByApi(tireStatisticsItem.status) }}
        </td>
        <td data-th="Кол-во просмотров">
          {{ tireStatisticsItem.views }}
        </td>
        <td
            data-th="Действие"
        >
          <a
              target="_blank"
              class="p-2 text-primary"
              :href="DOMAIN + tireStatisticsItem.linkSite"
          >
            <i class="bx bx-show"></i>
          </a>
          <router-link
              :to="{name: 'dashboardAdmin'}"
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
          :countChunk="isMobile ? 4 : 5"
          :class="{'card-body-pagination-mobile' : isMobile}"
          :totals="TOTALS_TIRE_STATISTICS"
          @setPageByTotal="setPageByTotal"
      />
    </template>
  </LayoutDefault>
</template>

<script>
  import LayoutDefault from "@/layouts/LayoutDefault.vue";
  import Pagination from "@/components/UI/BasePagination.vue";
  import {mixins} from "@/mixins/mixins";
  import {mapActions, mapGetters} from "vuex";
  import {DOMAIN} from "@/constants/constants";

  export default {
    name: "TireStatisticsMain",

    mounted() {
      this.GET_TIRE_STATISTICS(this.pageNum);
      this.GET_TIRE_STATISTICS_TOTALS();
    },

    mixins: [mixins],

    components: {
      Pagination,
      LayoutDefault
    },

    computed: {
      ...mapGetters('tireStatistics', [
        'TIRE_STATISTICS',
        'TOTALS_TIRE_STATISTICS'
      ]),
    },


    methods: {
      ...mapActions('tireStatistics', [
        'GET_TIRE_STATISTICS',
        'GET_TIRE_STATISTICS_TOTALS'
      ]),

      setPageByTotal(page) {
        this.pageNum = page;
        this.GET_TIRE_STATISTICS(this.pageNum);
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
@import "./src/components/tireStatistics/components/style/tire-statistics-main";
</style>