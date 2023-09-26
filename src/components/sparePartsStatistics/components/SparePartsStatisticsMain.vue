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
              <td>
                <a
                    target="_blank"
                    class="p-2 theme-icons"
                    :href="domain + sparePartsStatisticsItem.linkSite"
                >
                  <i class="bx bx-show"></i>
                </a>
                <a
                    target="_blank"
                    class="p-2 theme-icons"
                    :href="domain + sparePartsStatisticsItem.linkEdit"
                >
                  <i class="bx bx-pencil"></i>
                </a>
              </td>
            </tr>
            </tbody>
          </table>
        </div>
        <div
            class="row"
            v-if="TOTALS_SPARE_PARTS_STATISTICS > 10"
        >
          <div class="col-sm-12 col-md-5">
            <div class="dataTables_paginate paging_simple_numbers">
              <ul class="pagination">
                <li
                    class="paginate_button page-item"
                    v-for="(total, index) in allPage"
                    :key="index"
                    :class="{'active': total == pageNum}"
                >
                  <a
                      class="page-link"
                      v-on:click.prevent="setPageByTotal(total)"
                  >
                    {{total}}
                  </a>
                </li>
              </ul>
            </div>
          </div>
          <div class="col-sm-12 col-md-7">
            <div class="dataTables_info">
              Показано с 1 по 10 (всего {{TOTALS_SPARE_PARTS_STATISTICS}} записей)
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import {mapActions, mapGetters} from "vuex";
  import {DOMAIN} from "../../../../src/constants/constants";

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
      ])
    },


    methods: {
      ...mapActions('sparePartsStatistics', [
        'GET_SPARE_PARTS_STATISTICS',
        'GET_SPARE_PARTS_STATISTICS_TOTALS'
      ]),

      getPaginationPagesList: function (){
        let addPage = 1;

        if(this.pageNum != this.allPage[0] && this.pageNum != this.allPage[1]) {
          let lastElement = this.allPage.at(-1);
          this.allPage = this.allPage.slice(1);

          while (addPage) {
            lastElement++;
            this.allPage.push(lastElement);
            addPage--;
          }
        } else if(this.pageNum == this.allPage[0]) {
          let firstElement = this.allPage.at(0);

          if(firstElement >= 2) {
            this.allPage.pop();

            while (addPage) {
              firstElement--;
              this.allPage.unshift(firstElement);
              addPage--;
            }
          }
        }
      },

      setPageByTotal: function(page) {
        this.pageNum = page;
        this.getPaginationPagesList();
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
        allPage: [1,2,3,4,5,6],
      };
    }
  }
</script>

<style lang="scss" scoped>
@import "./src/components/sparePartsStatistics/components/style/spare-parts-statistics-main";
</style>