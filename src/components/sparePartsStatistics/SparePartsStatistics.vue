<template>
  <div class="card">
    <div class="card-body">
      <div class="row">
        <table class="table mb-0">
          <thead>
          <tr>
            <th scope="col">#</th>
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
            <th scope="row">
              {{ sparePartsStatisticsItem.num }}
            </th>
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
      <div class="row">
        <div class="col-sm-12 col-md-5">
          <div class="dataTables_info" id="example_info" role="status" aria-live="polite">Showing 1 to 10 of 57 entries</div>
        </div>
        <div class="col-sm-12 col-md-7">
          <div class="dataTables_paginate paging_simple_numbers" id="example_paginate">
            <ul class="pagination">
              <li class="paginate_button page-item previous disabled" id="example_previous"><a href="#" aria-controls="example" data-dt-idx="0" tabindex="0" class="page-link">Prev</a></li>
              <li class="paginate_button page-item active"><a href="#" aria-controls="example" data-dt-idx="1" tabindex="0" class="page-link">1</a></li>
              <li class="paginate_button page-item "><a href="#" aria-controls="example" data-dt-idx="2" tabindex="0" class="page-link">2</a></li>
              <li class="paginate_button page-item "><a href="#" aria-controls="example" data-dt-idx="3" tabindex="0" class="page-link">3</a></li>
              <li class="paginate_button page-item "><a href="#" aria-controls="example" data-dt-idx="4" tabindex="0" class="page-link">4</a></li>
              <li class="paginate_button page-item "><a href="#" aria-controls="example" data-dt-idx="5" tabindex="0" class="page-link">5</a></li>
              <li class="paginate_button page-item "><a href="#" aria-controls="example" data-dt-idx="6" tabindex="0" class="page-link">6</a></li>
              <li class="paginate_button page-item next" id="example_next"><a href="#" aria-controls="example" data-dt-idx="7" tabindex="0" class="page-link">Next</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import {DOMAIN} from "../../../src/constants/constants";

export default {
  name: "SparePartsStatistics",

  mounted() {
    this.GET_SPARE_PARTS_STATISTICS();
  },

  computed: {
    ...mapGetters([
      'SPARE_PARTS_STATISTICS'
    ])
  },

  methods: {
    ...mapActions([
      'GET_SPARE_PARTS_STATISTICS'
    ]),

    setStatusByApi(status) {
      return (status == 1) ? 'Активно' : 'Неактивно';
    }
  },

  data() {
    return {
      domain: DOMAIN
    };
  }
}
</script>