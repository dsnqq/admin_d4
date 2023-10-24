<template>
  <div class="card">
    <div class="card-header py-2">
      <div class="card-filter shadow-none bg-light border py-4">
        <div class="row">
          <div class="card-filter__rows">
            <div class="card-filter__item card-filter-item">
              <div class="card-filter-item__label">
                Марка и Модель
              </div>

              <div class="card-filter-item__form d-flex justify-content-sm-between align-items-center">
                <v-multiselect
                    v-model="param.filters.car"
                    :options="BREND_MODEL_CAR_AUTO_PARTS"
                    :custom-label="customLabelModelBrand"
                    :selectedLabel="`Выбрано`"
                    :deselectLabel="`Клик, чтобы удалить`"
                    :selectLabel="`Клик, чтобы выбрать`"
                    :placeholder="`Марка`"
                    class="card-filter-item__select"
                >
                  <template v-slot:noResult>
                    Пусто...
                  </template>
                </v-multiselect>
              </div>
            </div>
            <div class="card-filter__item card-filter-item">
              <div class="card-filter-item__label">
                Название запчасти
              </div>
              <div class="card-filter-item__form">
                <v-multiselect
                    v-model="param.filters.types"
                    :options="TYPES_OF_AUTO_PARTS"
                    :custom-label="customLabelTypes"
                    :selectedLabel="`Выбрано`"
                    :deselectLabel="`Клик, чтобы удалить`"
                    :selectLabel="`Клик, чтобы выбрать`"
                    :placeholder="`Название запчасти`"
                    class="card-filter-item__select"
                >
                  <template v-slot:noResult>
                    Пусто...
                  </template>
                </v-multiselect>
              </div>
            </div>
            <div class="card-filter__item card-filter-item">
              <div class="card-filter-item__label">
                Номер запчасти
              </div>
              <div class="card-filter-item__form">
                <input
                    v-model="param.filters.sparePartNumber"
                    type="text"
                    id="sparePartNumber"
                    placeholder="Номер запчасти"
                    class="card-filter-item__input"
                    autocomplete="off"
                />
              </div>
            </div>
            <div class="card-header__item card-filter-item">
              <div class="card-filter-item__label">
                Артикул
              </div>
              <div class="card-filter-item__form">
                <input
                   v-model="param.filters.model"
                   type="text"
                   id="model"
                   placeholder="Артикул"
                   class="card-filter-item__input"
                   autocomplete="off"
                />
              </div>
            </div>
            <div class="card-header__item card-filter-item">
              <div class="card-filter-item__label">
                Тип топлива
              </div>
              <div class="card-filter-item__form">
                <v-multiselect
                    v-model="param.filters.fuel"
                    :options="['Не выбрано', 'дизель', 'бензин', 'гибрид', 'электро']"
                    :selectedLabel="`Выбрано`"
                    :deselectLabel="`Клик, чтобы удалить`"
                    :selectLabel="`Клик, чтобы выбрать`"
                    :placeholder="`Тип топлива`"
                    class="card-filter-item__select"
                >
                  <template v-slot:noResult>
                    Пусто...
                  </template>
                </v-multiselect>
              </div>
            </div>
            <div class="card-header__item card-filter-item">
              <div class="card-filter-item__label">
                Объём
              </div>
              <div class="card-filter-item__form">
                <input
                   v-model="param.filters.value"
                   type="text"
                   id="value"
                   placeholder="Объём"
                   class="card-filter-item__input"
                   autocomplete="off"
                />
              </div>
            </div>
            <div class="card-header__item card-filter-item">
              <div class="card-filter-item__label">
                Статус
              </div>
              <div class="card-filter-item__form">
                <v-multiselect
                    v-model="param.filters.status"
                    :options="['Все объявления', 'Активно', 'Неактивно']"
                    :selectedLabel="`Выбрано`"
                    :deselectLabel="`Клик, чтобы удалить`"
                    :selectLabel="`Клик, чтобы выбрать`"
                    :placeholder="`Статус`"
                    class="card-filter-item__select"
                >
                  <template v-slot:noResult>
                    Пусто...
                  </template>
                </v-multiselect>
              </div>
            </div>
            <div class="card-header__item card-filter-item">
              <div class="card-filter-item__label">
                Год
              </div>
              <div class="card-filter-item__form card-filter-item__form--is-year">
                <span class="m-1">от</span>
                <v-multiselect
                    v-model="param.filters.yearStart"
                    :options="YEARS"
                    :selectedLabel="`Выбрано`"
                    :deselectLabel="`Клик, чтобы удалить`"
                    :selectLabel="`Клик, чтобы выбрать`"
                    :placeholder="`Год`"
                    class="card-filter-item__select card-filter-item__select--is-year"
                >
                  <template v-slot:noResult>
                    Пусто...
                  </template>
                </v-multiselect>
                <span class="m-1">до</span>
                <v-multiselect
                    v-model="param.filters.yearLast"
                    :options="YEARS"
                    :selectedLabel="`Выбрано`"
                    :deselectLabel="`Клик, чтобы удалить`"
                    :selectLabel="`Клик, чтобы выбрать`"
                    :placeholder="`Год`"
                    class="card-filter-item__select card-filter-item__select--is-year"
                >
                  <template v-slot:noResult>
                    Пусто...
                  </template>
                </v-multiselect>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="card-filter__buttons">
            <button
                @click.prevent="setFilterOnAutoPartsPage"
                type="button"
                class="btn btn-success card-filter__search"
            >
              Поиск
            </button>
            <button
                @click="resetFilters"
                type="button"
                class="btn btn-warning card-filter__refresh"
            >
              Сброс
            </button>
          </div>
        </div>
      </div>
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
            <tbody>
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
      <PaginationAdmin
          :totals="AUTO_PARTS_TOTALS"
          @setPageByTotal="setPageByTotal"
      />
    </div>
  </div>
</template>

<script>
  import PaginationAdmin from "@/components/UI/PaginationAdmin.vue";
  import {COLUMNS} from "@/components/autoParts/constants/constants";
  import {YEARS} from "@/constants/constants";
  import {mapActions, mapGetters} from "vuex";

  export default {
    name: "AutoPartsList",

    mounted() {
      this.GET_AUTO_PARTS_FROM_API(this.param);
      this.GET_AUTO_PARTS_TOTALS(this.param);
      this.GET_TYPES_OF_AUTO_PARTS();
      this.GET_BREND_MODEL_CAR_AUTO_PARTS();
    },

    components: {
      PaginationAdmin
    },

    computed: {
      ...mapGetters('autoParts', [
        'AUTO_PARTS',
        'AUTO_PARTS_TOTALS',
        'TYPES_OF_AUTO_PARTS',
        'BREND_MODEL_CAR_AUTO_PARTS'
      ]),
    },

    methods: {
      ...mapActions('autoParts', [
        'GET_AUTO_PARTS_FROM_API',
        'GET_AUTO_PARTS_TOTALS',
        'GET_TYPES_OF_AUTO_PARTS',
        'GET_BREND_MODEL_CAR_AUTO_PARTS'
      ]),

      customLabelTypes({ name }) {
        return name;
      },

      customLabelModelBrand({ name }) {
        return name;
      },

      setFilterOnAutoPartsPage() {
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
@import "./src/components/autoParts/components/style/auto-parts-list";
@import "../../../../node_modules/vue-multiselect/dist/vue-multiselect.min.css";
@import "@/assets/scss/table-adaptive.scss";
</style>