<template>
  <div class="card">
    <div class="card-header py-2">
      <Filters
        :options="optionsFilters"
        :storageCache="storageCache"
        @setFilterOnAutoPartsPage="setFilterOnAutoPartsPage"
        @resetFilters="resetFilters"
      />
    </div>
    <div class="card-body">
      <div class="row">
        <div>
          <table class="table align-middle table-striped table-border-1 rwd-table middle-responsive">
            <thead>
            <tr>
              <th
                  v-for="(c, index) in COLUMNS"
                  :key="index"
              >
                {{c.title}}
              </th>
            </tr>
            </thead>
            <tbody class="card-body__grid">
              <tr
                  v-for="(auto, i) in AUTO_PARTS"
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
                      :images="auto.images"
                      :title="auto.autoParts.name"
                      :index="i"
                      :id="auto.product_id"
                      :showAll="auto.imagesShowAllImage"
                      :content="auto[c.content]"
                      :contentExtension="auto[c.contentExtension]"
                      :priceUSD="auto.priceUSD"
                      :priceBYN="auto.priceBYN"
                      :status="auto.status"
                      :linkToSite="auto.linkToSite"
                      :view="auto.view"
                  ></component>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <Pagination
          :totals="AUTO_PARTS_TOTALS"
          :storageCache="storageCache"
          @setPageByTotal="setPageByTotal"
      />
      <BaseButtonFixedAdd
         component="autoPartsCreate"
      />
    </div>
  </div>
</template>

<script>
  import BaseButtonFixedAdd from "@/components/UI/BaseButtonFixedAdd.vue";
  import Filters from "@/components/UI/BaseFilters.vue";
  import Pagination from "@/components/UI/BasePagination.vue";
  import {COLUMNS} from "@/components/autoParts/constants/constants";
  import {YEARS} from "@/constants/constants";
  import {mapActions, mapGetters} from "vuex";

  export default {
    name: "AutoPartsList",

    mounted() {
      if(localStorage.getItem('localCacheFilters') !== null) {
        let localCacheFilters = JSON.parse(localStorage.localCacheFilters);

        if (localCacheFilters.length !== 0) {
          this.param.pageNum = (localCacheFilters.page) ? localCacheFilters.page : 1;
          this.param.filters.types = (localCacheFilters.types) ? localCacheFilters.types : {};
          this.param.filters.sparePartNumber = (localCacheFilters.sparePartNumber) ? localCacheFilters.sparePartNumber : '';
          this.param.filters.model = (localCacheFilters.model) ? localCacheFilters.model : '';
          this.param.filters.status = (localCacheFilters.status) ? localCacheFilters.status : 'Все объявления';
          this.param.filters.fuel = (localCacheFilters.fuel) ? localCacheFilters.fuel : 'Не выбрано';
          this.param.filters.value = (localCacheFilters.value) ? localCacheFilters.value : '';
          this.param.filters.yearStart = (localCacheFilters.yearStart) ? localCacheFilters.yearStart : '';
          this.param.filters.yearLast = (localCacheFilters.yearLast) ? localCacheFilters.yearLast : '';
          this.param.filters.types = (localCacheFilters.types) ? localCacheFilters.types : {};
          this.param.filters.car = (localCacheFilters.car) ? localCacheFilters.car : {};

        }
      }

      this.GET_AUTO_PARTS_FROM_API(this.param);
      this.GET_AUTO_PARTS_TOTALS(this.param);
      this.GET_TYPES_OF_AUTO_PARTS();
      this.GET_BREND_MODEL_CAR_AUTO_PARTS();
    },

    components: {
      Pagination,
      Filters,
      BaseButtonFixedAdd
    },

    computed: {
      ...mapGetters('autoParts', [
        'AUTO_PARTS',
        'AUTO_PARTS_TOTALS',
        'TYPES_OF_AUTO_PARTS',
        'BREND_MODEL_CAR_AUTO_PARTS'
      ]),

      storageCache() {
        if(localStorage.getItem('localCacheFilters') !== null) {
          return JSON.parse(localStorage.localCacheFilters);
        } else {
          return {};
        }
      },

      optionsFilters() {
        return [
          {
            title: 'Марка и Модель',
            type: 'select',
            vModel: "car",
            params: this.BREND_MODEL_CAR_AUTO_PARTS,
            className: "d-flex justify-content-sm-between align-items-center",
            customLabel: "name"
          },
          {
            title: 'Название запчасти',
            type: 'select',
            vModel: "types",
            params: this.TYPES_OF_AUTO_PARTS,
            customLabel: "name"
          },
          {
            title: 'Номер запчасти',
            type: 'input',
            inputType: "text",
            vModel: "sparePartNumber",
            autocomplete: "off"
          },
          {
            title: 'Артикул',
            type: 'input',
            inputType: "text",
            vModel: "model",
            autocomplete: "off"
          },
          {
            title: 'Тип топлива',
            type: 'select',
            vModel: "fuel",
            params: ['Не выбрано', 'дизель', 'бензин', 'гибрид', 'электро']
          },
          {
            title: 'Объём',
            type: 'input',
            inputType: "text",
            vModel: "value",
            autocomplete: "off"
          },
          {
            title: 'Статус',
            type: 'select',
            vModel: "status",
            params: ['Все объявления', 'Активно', 'Неактивно']
          },
          [
            {
              title: 'Год',
              textLabel: "от",
              type: 'select',
              vModel: "yearStart",
              params: YEARS,
              className: "card-filter-item__form--is-year",
              classNameItem: "card-filter-item__select--is-year"
            },
            {
              title: 'Год',
              textLabel: "до",
              type: 'select',
              vModel: "yearLast",
              params: YEARS,
              className: "card-filter-item__form--is-year",
              classNameItem: "card-filter-item__select--is-year"
            }
          ],
        ]
      }
    },

    methods: {
      ...mapActions('autoParts', [
        'GET_AUTO_PARTS_FROM_API',
        'GET_AUTO_PARTS_TOTALS',
        'GET_TYPES_OF_AUTO_PARTS',
        'GET_BREND_MODEL_CAR_AUTO_PARTS'
      ]),

      setFilterOnAutoPartsPage(param) {
        let localCacheFilters = {
          page: this.param.pageNum,
          car: param.car,
          types: param.types,
          yearLast: param.yearLast,
          yearStart: param.yearStart,
          sparePartNumber: param.sparePartNumber,
          model: param.model,
          status: param.status,
          fuel: param.fuel,
          value: param.value
        }

        localStorage.localCacheFilters = JSON.stringify(localCacheFilters);

        this.param.pageNum = (localCacheFilters.page) ? localCacheFilters.page : 1;
        this.param.filters.car = (param.car != undefined) ? param.car : {};
        this.param.filters.types = (param.types != undefined) ? param.types : {};
        this.param.filters.yearLast = (param.yearLast != undefined) ? param.yearLast : '';
        this.param.filters.yearStart = (param.yearStart != undefined) ? param.yearStart : '';
        this.param.filters.sparePartNumber = (param.sparePartNumber != undefined) ? param.sparePartNumber : '';
        this.param.filters.model = (param.model != undefined) ? param.model : '';
        this.param.filters.status = (param.status != undefined) ? param.status : 'Все объявления';
        this.param.filters.fuel = (param.fuel != undefined) ? param.fuel : 'Не выбрано';
        this.param.filters.value = (param.value != undefined) ? param.value : '';

        this.GET_AUTO_PARTS_FROM_API(this.param);
        this.GET_AUTO_PARTS_TOTALS(this.param);
      },

      setPageByTotal(page) {
        this.param.pageNum = page;

        let localCacheFilters = {
          page: page,
        }
        localStorage.localCacheFilters = JSON.stringify(localCacheFilters);

        this.GET_AUTO_PARTS_FROM_API(this.param);
      },

      resetFilters() {
        localStorage.removeItem("localCacheFilters");

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
          }
        }

        this.GET_AUTO_PARTS_FROM_API(this.param);
        this.GET_AUTO_PARTS_TOTALS(this.param);
      },
    },

    data() {
      return {
        YEARS,
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
@media screen and (max-width: 560px) {

    ::v-deep .card-filter__rows {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      grid-template-rows: repeat(6, 1fr);
      grid-column-gap: 10px;
      grid-row-gap: 0px;
    }
    ::v-deep .card-filter-item__label {
      min-width:100% !important;
    }
    ::v-deep .card-filter__item:nth-child(1) { grid-area: 1 / 1 / 2 / 3; }
    ::v-deep .card-filter__item:nth-child(2) { grid-area: 2 / 1 / 3 / 3; }
    ::v-deep .card-filter__item:nth-child(3) { grid-area: 3 / 1 / 4 / 3; }
    ::v-deep .card-filter__item:nth-child(4) { grid-area: 4 / 1 / 5 / 2; }
    ::v-deep .card-filter__item:nth-child(5) { grid-area: 4 / 2 / 5 / 3; }
    ::v-deep .card-filter__item:nth-child(6) { grid-area: 5 / 1 / 6 / 2; }
    ::v-deep .card-filter__item:nth-child(7) { grid-area: 5 / 2 / 6 / 3; }
    ::v-deep .card-filter__item:nth-child(8) { grid-area: 6 / 1 / 7 / 3; }
}
</style>
<style lang="scss" scoped>
@import "./src/components/autoParts/style/auto-parts-list";
@import "@/assets/scss/table-adaptive.scss";
</style>
