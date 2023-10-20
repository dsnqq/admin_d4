<template>
  <div>
    <h6 class="mb-0 text-uppercase">Статистика просмотров З/Ч</h6>
    <hr>
    <div class="card">
      <div class="card-body">
        <div class="row">
          <table class="table table-border-1 mb-0">
            <thead>
            <tr>
              <th scope="col">Дата</th>
              <th scope="col">Название</th>
              <th scope="col">Артикул</th>
              <th scope="col">Статус З/Ч</th>
              <th scope="col">Кол-во просмотров</th>
              <th scope="col">Действие</th>
            </tr>
            </thead>
            <tbody>
            <tr
                v-for="(sparePartsStatisticsItem, i) in SPARE_PARTS_STATISTICS"
                :key="i"
            >
              <td>
                {{ sparePartsStatisticsItem.date }}
              </td>
              <td>
                {{ sparePartsStatisticsItem.name }}
              </td>
              <td>
                {{ sparePartsStatisticsItem.article }}
              </td>
              <td>
                {{ setStatusByApi(sparePartsStatisticsItem.status) }}
              </td>
              <td>
                {{ sparePartsStatisticsItem.views }}
              </td>
              <td class="fs-6">
                <a
                    target="_blank"
                    class="p-2 theme-icons text-primary"
                    :href="domain + sparePartsStatisticsItem.linkSite"
                >
                  <i class="bx bx-show"></i>
                </a>
                <router-link
                    :to="{name: 'autoPartsDetail', params: {id: sparePartsStatisticsItem.product_id}}"
                    target="_blank"
                    class="p-2 theme-icons text-warning cursor-pointer"
                >
                  <i class="bx bx-pencil"></i>
                </router-link>
              </td>
            </tr>
            </tbody>
          </table>
        </div>
        <div class="row">
          <v-pagination
              v-model="pageNum"
              :records="sparePartsStatisticsTotal"
              :per-page="100"
              @paginate="setPageByTotal"
              :options="paginationOptions"
          ></v-pagination>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import {mapActions, mapGetters} from "vuex";
  import {DOMAIN} from "@/constants/constants";

  export default {
    name: "SparePartsStatisticsMain",

    mounted() {
      this.GET_SPARE_PARTS_STATISTICS(this.pageNum);
      this.GET_SPARE_PARTS_STATISTICS_TOTALS();
    },

    computed: {
      ...mapGetters('sparePartsStatistics', [
        'SPARE_PARTS_STATISTICS',
        'TOTALS_SPARE_PARTS_STATISTICS',
        'IS_UI_LOCKED',
      ]),

      sparePartsStatisticsTotal() {
        return parseInt(this.TOTALS_SPARE_PARTS_STATISTICS);
      },
    },


    methods: {
      ...mapActions('sparePartsStatistics', [
        'GET_SPARE_PARTS_STATISTICS',
        'GET_SPARE_PARTS_STATISTICS_TOTALS'
      ]),

      setPageByTotal(page) {
        this.pageNum = page;
        window.scrollTo(0, 0);
        this.GET_SPARE_PARTS_STATISTICS(this.pageNum);
      },

      setStatusByApi(status) {
        return (status == 1) ? 'Активно' : 'Неактивно';
      },
    },

    data() {
      return {
        domain: DOMAIN,
        pageNum: 1,
        paginationOptions: {
          chunk: 5,
          texts: {
            count: 'Отображается с {from} по {to} (всего {count} шт.)|{count}',
          }
        },
      };
    }
  }
</script>

<style lang="scss" scoped>
@import "./src/components/sparePartsStatistics/components/style/spare-parts-statistics-main";
</style>