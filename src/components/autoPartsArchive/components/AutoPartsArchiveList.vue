<template>
  <div class="card">
    <div class="card-header py-3">
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
                    :options="TYPES_OF_AUTO_PARTS_ARCHIVE"
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
                Год
              </div>
              <div class="card-filter-item__form d-flex justify-content-sm-between align-items-center">
                <span class="m-1">от</span>
                <v-multiselect
                    v-model="param.filters.yearStart"
                    :options="years"
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
                    :options="years"
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
                @click.prevent="loadAutoPartsArchive"
                type="button"
                class="btn btn-success card-filter__search"
            >
              Поиск
            </button>
            <button
                @click.prevent="resetFilters"
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
              <th>Изображение</th>
              <th>Марка и модель</th>
              <th>Год</th>
              <th>Объём</th>
              <th>Тип топлива</th>
              <th>Название запчасти</th>
              <th>Артикул</th>
              <th>Цена</th>
              <th>Номер запчасти</th>
              <th>Дата удаления</th>
              <th>Описание</th>
              <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            <tr
                v-for="(autoPartsArchive, i) in AUTO_PARTS_ARCHIVE"
                :key="i"
            >
              <td data-th="Изображение">
                <template v-if="autoPartsArchive.images">
                  <a
                      :href="domain + `/image/` + autoPartsArchive.images[0].imageBig"
                      :data-title="autoPartsArchive.autoParts.name"
                      :data-lightbox="autoPartsArchive.product_id"
                      class="product-box-image"
                  >
                    <img
                        :src="autoPartsArchive.images[0].imageMini"
                        :alt="autoPartsArchive.autoParts.name"
                    />
                  </a>
                  <div class="product-box-image-flex">
                    <a
                        :data-lightbox="autoPartsArchive.product_id"
                        v-for="(image, index) in autoPartsArchive.images"
                        :key="index"
                        :data-title="autoPartsArchive.autoParts.name"
                        :href="domain + `/image/` + image.imageBig"
                        class="product-box-image--small"
                        v-show="image.imageShow"
                    >
                      <img
                          :src="image.imageMini"
                          :alt="autoPartsArchive.autoParts.name"
                      >
                    </a>
                    <span
                        v-if="!autoPartsArchive.imagesShowAllImage"
                        @click="showImageAll(i)"
                        class="product-more-photo"
                    >Ещё фото</span>
                  </div>
                </template>
              </td>
              <td data-th="Марка и модель">{{autoPartsArchive.name.marka + ' ' + autoPartsArchive.name.model}}</td>
              <td data-th="Год">{{autoPartsArchive.year}}</td>
              <td data-th="Объём">{{autoPartsArchive.value}}</td>
              <td data-th="Тип топлива">{{autoPartsArchive.fuel + " " + autoPartsArchive.typeEngines}}</td>
              <td
                  data-th="Название запчасти"
                  class="productlist"
              >
                <span class="d-flex align-items-center gap-2">
                  <h6 class="mb-0 product-title">{{autoPartsArchive.autoParts.name}}</h6>
                </span>
              </td>
              <td data-th="Артикул">{{autoPartsArchive.model}}</td>
              <td data-th="Цена">{{autoPartsArchive.priceUSD}}$</td>
              <td data-th="Номер запчасти">{{autoPartsArchive.sparePartNumber}}</td>
              <td data-th="Дата удаления">{{autoPartsArchive.dateDeleted}}</td>
              <td
                  data-th="Описание"
                  class="td-description"
              >
                {{autoPartsArchive.description}}
              </td>
              <td
                  data-th="Действия"
                  class="text-center"
              >
                <div class="d-flex align-items-center justify-content-center gap-2 fs-6">
                  <a
                      @click="getHistoryAuto(autoPartsArchive.product_id)"
                      class="text-primary cursor-pointer"
                  >
                    <i class="bi bi-archive"></i>
                  </a>
                  <a
                      @click.prevent="autoPartsRestore(autoPartsArchive.product_id, i)"
                      class="text-success cursor-pointer"
                  >
                    <i class="bi bi-arrow-clockwise"></i>
                  </a>
                </div>
              </td>
            </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="row">
        <v-pagination
            v-model="param.pageNum"
            :records="autoPartsArchiveTotal"
            :per-page="20"
            @paginate="setPageByTotal"
            :options="paginationOptions"
        ></v-pagination>
      </div>
    </div>
  </div>
</template>

<script>
import {DOMAIN, YEARS} from "../../../constants/constants";
import {mapActions, mapGetters} from "vuex";
import Jquery from 'jquery'; // eslint-disable-line no-unused-vars
import lightbox from 'lightbox2'; // eslint-disable-line no-unused-vars

export default {
  name: "AutoPartsArchiveList",

  mounted() {
    this.loadAutoPartsArchive();
    this.GET_TYPES_OF_AUTO_PARTS_ARCHIVE();
    this.GET_BREND_MODEL_CAR_AUTO_PARTS();
  },

  computed: {
    ...mapGetters('autoPartsArchive', [
      'AUTO_PARTS_ARCHIVE',
      'AUTO_PARTS_ARCHIVE_TOTALS',
      'TYPES_OF_AUTO_PARTS_ARCHIVE',
      'BREND_MODEL_CAR_AUTO_PARTS'
    ]),

    autoPartsArchiveTotal() {
      return parseInt(this.AUTO_PARTS_ARCHIVE_TOTALS);
    }
  },

  methods: {
    ...mapActions('autoPartsArchive', [
      'GET_AUTO_PARTS_ARCHIVE_FROM_API',
      'GET_AUTO_PARTS_ARCHIVE_TOTALS',
      'SET_SHOW_ALL_IMAGE',
      'GET_AUTO_PARTS_ARCHIVE_HISTORY',
      'RESTORE_AUTO_PARTS_ARCHIVE_BY_API',
      'GET_TYPES_OF_AUTO_PARTS_ARCHIVE',
      'GET_BREND_MODEL_CAR_AUTO_PARTS',
    ]),

    loadAutoPartsArchive() {
      this.GET_AUTO_PARTS_ARCHIVE_FROM_API(this.param);
      this.GET_AUTO_PARTS_ARCHIVE_TOTALS(this.param);
    },

    setPageByTotal(page) {
      this.param.pageNum = page;
      window.scrollTo(0, 0);
      this.GET_AUTO_PARTS_ARCHIVE_FROM_API(this.param.pageNum);
    },

    customLabelTypes({ name }) {
      return name;
    },

    customLabelModelBrand({ name }) {
      return name;
    },

    getHistoryAuto(id) {
      this.$emit('getHistoryAuto');
      this.GET_AUTO_PARTS_ARCHIVE_HISTORY(id);
    },

    showImageAll(id) {
      this.SET_SHOW_ALL_IMAGE(id);
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

    autoPartsRestore(id, index) {
      if(confirm("Вы действительно хотите восстановить данную запчасть ?")) {
        let param = {
          autoPartsId: id,
          autoPartsNumber: index
        };

        this.RESTORE_AUTO_PARTS_ARCHIVE_BY_API(param);
      }
    },
  },

  data() {
    return {
      domain: DOMAIN,
      years: YEARS,
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
@import "./src/components/autoPartsArchive/components/style/auto-parts-archive-list";
@import "/node_modules/lightbox2/dist/css/lightbox.min.css";
@import "../../../../node_modules/vue-multiselect/dist/vue-multiselect.min.css";
@import "@/assets/scss/table-adaptive.scss";
</style>
