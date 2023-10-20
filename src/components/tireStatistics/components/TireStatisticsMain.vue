<template>
  <div>
    <h6 class="mb-0 text-uppercase">Статистика просмотров шин</h6>
    <hr>
    <div class="card">
      <div class="card-body">
        <div class="row">
          <table class="table table-border-1 mb-0 rwd-table">
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
                    class="p-2 theme-icons text-primary"
                    :href="domain + tireStatisticsItem.linkSite"
                >
                  <i class="bx bx-show"></i>
                </a>
                <router-link
                    :to="{name: 'dashboardAdmin'}"
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
              :records="tireStatisticsTotal"
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
    name: "TireStatisticsMain",

    mounted() {
      this.GET_TIRE_STATISTICS(this.pageNum);
      this.GET_TIRE_STATISTICS_TOTALS();
    },

    computed: {
      ...mapGetters('tireStatistics', [
        'TIRE_STATISTICS',
        'TOTALS_TIRE_STATISTICS',
        'IS_UI_LOCKED',
      ]),

      tireStatisticsTotal() {
        return parseInt(this.TOTALS_TIRE_STATISTICS);
      },
    },


    methods: {
      ...mapActions('tireStatistics', [
        'GET_TIRE_STATISTICS',
        'GET_TIRE_STATISTICS_TOTALS'
      ]),

      setPageByTotal(page) {
        this.pageNum = page;
        window.scrollTo(0, 0);
        this.GET_TIRE_STATISTICS(this.pageNum);
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
@import "./src/components/tireStatistics/components/style/tire-statistics-main";
@import "@/assets/scss/table-adaptive.scss";
</style>