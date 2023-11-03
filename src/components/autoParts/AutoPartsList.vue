<template>
  <div class="card">
    <div class="card-header py-2">
      <Filters
        :options="optionsFilters"
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
          :countChunk="isMobile ? 4 : 5"
          @setPageByTotal="setPageByTotal"
          :class="{'card-body-pagination-mobile' : isMobile}"
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
  import {mobileCheckMixin} from "@/mixins/mixins";
  import {YEARS} from "@/constants/constants";
  import {mapActions, mapGetters} from "vuex";

  export default {
    name: "AutoPartsList",

    mixins: [mobileCheckMixin],

    mounted() {
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

      isMobile() {
        return this.mobileCheck();
      },

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
        this.GET_AUTO_PARTS_FROM_API(this.param);
      },

      resetFilters() {
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
@import "./src/components/autoParts/style/auto-parts-list";
@import "@/assets/scss/table-adaptive.scss";
</style>
