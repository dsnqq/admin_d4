<template>
  <div class="card">
    <div class="card-header py-3">
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
            <th
                v-for="(c, index) in COLUMNS"
                :key="index"
            >
              {{c.title}}
            </th>
            </thead>
            <tbody class="card-body__grid">
            <tr
                v-for="(autoPartsArchive, i) in AUTO_PARTS_ARCHIVE"
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
                    :images="autoPartsArchive.images"
                    :title="autoPartsArchive.autoParts.name"
                    :index="i"
                    :id="autoPartsArchive.product_id"
                    :showAll="autoPartsArchive.imagesShowAllImage"
                    :content="autoPartsArchive[c.content]"
                    :contentExtension="autoPartsArchive[c.contentExtension]"
                    :priceUSD="autoPartsArchive.priceUSD"
                    :priceBYN="autoPartsArchive.priceBYN"
                    :status="autoPartsArchive.status"
                    :linkToSite="autoPartsArchive.linkToSite"
                    :view="autoPartsArchive.view"
                ></component>
              </td>
            </tr>
            </tbody>
          </table>
        </div>
      </div>
      <Pagination
          :totals="AUTO_PARTS_ARCHIVE_TOTALS"
          @setPageByTotal="setPageByTotal"
      />
    </div>
  </div>
</template>

<script>
import Filters from "@/components/UI/BaseFilters.vue";
import Pagination from "@/components/UI/BasePagination.vue";
import {COLUMNS} from "@/components/autoPartsArchive/constants/constants";
import {YEARS} from "@/constants/constants";
import {mapActions, mapGetters} from "vuex";

export default {
  name: "AutoPartsArchiveList",

  mounted() {
    this.loadAutoPartsArchive();
    this.GET_TYPES_OF_AUTO_PARTS_ARCHIVE();
    this.GET_BREND_MODEL_CAR_AUTO_PARTS();
  },

  components: {
    Pagination,
    Filters
  },

  computed: {
    ...mapGetters('autoPartsArchive', [
      'AUTO_PARTS_ARCHIVE',
      'AUTO_PARTS_ARCHIVE_TOTALS',
      'TYPES_OF_AUTO_PARTS_ARCHIVE',
      'BREND_MODEL_CAR_AUTO_PARTS'
    ]),

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
          params: this.TYPES_OF_AUTO_PARTS_ARCHIVE,
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
          params: ['Не выбрано', 'дизель', 'бензин', 'гибрид', 'электро'],
        },
        {
          title: 'Объём',
          type: 'input',
          inputType: "text",
          vModel: "value",
          autocomplete: "off"
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
    ...mapActions('autoPartsArchive', [
      'GET_AUTO_PARTS_ARCHIVE_FROM_API',
      'GET_AUTO_PARTS_ARCHIVE_TOTALS',
      'GET_TYPES_OF_AUTO_PARTS_ARCHIVE',
      'GET_BREND_MODEL_CAR_AUTO_PARTS',
    ]),

    loadAutoPartsArchive() {
      this.GET_AUTO_PARTS_ARCHIVE_FROM_API(this.param);
      this.GET_AUTO_PARTS_ARCHIVE_TOTALS(this.param);
    },

    setPageByTotal(page) {
      this.param.pageNum = page;
      this.GET_AUTO_PARTS_ARCHIVE_FROM_API(this.param.pageNum);
    },

    setFilterOnAutoPartsPage(param) {
      this.param.filters.car = (param.car != undefined) ? param.car : {};
      this.param.filters.types = (param.types != undefined) ? param.types : {};
      this.param.filters.yearLast = (param.yearLast != undefined) ? param.yearLast : '';
      this.param.filters.yearStart = (param.yearStart != undefined) ? param.yearStart : '';
      this.param.filters.sparePartNumber = (param.sparePartNumber != undefined) ? param.sparePartNumber : '';
      this.param.filters.model = (param.model != undefined) ? param.model : '';
      this.param.filters.fuel = (param.fuel != undefined) ? param.fuel : 'Не выбрано';
      this.param.filters.value = (param.value != undefined) ? param.value : '';

      this.loadAutoPartsArchive();
    },

    resetFilters() {
      this.param = {
        pageNum: this.param.pageNum,
        filters: {
          sparePartNumber: '',
          model: '',
          fuel: 'Не выбрано',
          value: '',
          yearStart: '',
          yearLast: '',
          types: {},
          car: {},
        }
      }

      this.loadAutoPartsArchive();
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
@import "@/components/autoPartsArchive/style/auto-parts-archive-list.scss";
@import "@/assets/scss/table-adaptive.scss";
</style>
