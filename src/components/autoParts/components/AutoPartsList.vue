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
        <div class="table-responsive">
          <table class="table align-middle table-striped table-border-1 rwd-table">
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
              <th>Дата создания</th>
              <th>Статус</th>
              <th>Описание</th>
              <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            <tr
                v-for="(auto, i) in AUTO_PARTS"
                :key="i"
            >
              <td data-th="Изображение">
                <template v-if="auto.images">
                  <a
                      :href="domain + `/image/` + auto.images[0].imageBig"
                      :data-title="auto.autoParts.name"
                      :data-lightbox="auto.product_id"
                      class="product-box-image"
                  >
                    <img
                        :src="auto.images[0].imageMini"
                        :alt="auto.autoParts.name"
                    />
                  </a>
                  <div class="product-box-image-flex">
                    <a
                        :data-lightbox="auto.product_id"
                        v-for="(image, index) in auto.images"
                        :key="index"
                        :data-title="auto.autoParts.name"
                        :href="domain + `/image/` + image.imageBig"
                        class="product-box-image--small"
                        v-show="image.imageShow"
                    >
                      <img
                          :src="image.imageMini"
                          :alt="auto.autoParts.name"
                      >
                    </a>
                    <span
                        v-if="!auto.imagesShowAllImage"
                        @click="showImageAll(i)"
                        class="product-more-photo"
                    >Ещё фото</span>
                  </div>
                </template>
              </td>
              <td data-th="Марка и модель">{{ auto.name.marka + ' ' + auto.name.model}}</td>
              <td data-th="Год">{{auto.year}}</td>
              <td data-th="Объём">{{auto.value}}</td>
              <td data-th="Тип топлива">{{auto.fuel + " " + auto.typeEngines}}</td>
              <td
                  data-th="Название запчасти"
                  class="productlist"
              >
                <span class="d-flex align-items-center gap-2">
                  <h6 class="mb-0 product-title">{{auto.autoParts.name}}</h6>
                </span>
              </td>
              <td data-th="Артикул">{{auto.model}}</td>
              <td data-th="Цена">
                <div>
                  <template v-if="!columnEdit">
                  {{auto.priceUSD}} $
                  </template>
                  <span
                      class="auto-parts-list-wrapper-column__edits auto-parts-list-wrapper-column-edits"
                  >
                  <input
                      v-if="columnEdit"
                      placeholder="Туть что-то"
                      v-model="auto.priceUSD"
                      class="auto-parts-list-wrapper-column-edits__input"
                      type="text"
                  >
                  <button
                      @click.prevent="setEditThisColumnOnList"
                      class="auto-parts-list-wrapper-column-edits__button auto-parts-list-wrapper-column-edit"
                  >
                    <i
                        v-if="!columnEdit"
                        class="bx bx-pencil p-2 text-warning"></i>
                    <i
                        v-else
                        class="lni lni-save p-2 text-warning"></i>
                  </button>
                </span>
                </div>
                <div>{{auto.priceBYN}} руб.</div>
              </td>
              <td data-th="Номер запчасти">{{auto.sparePartNumber}}</td>
              <td data-th="Дата создания">
                {{auto.dateAdded}}
              </td>
              <td data-th="Статус">
                <span
                    @click="changeStatus(auto.product_id, auto.status, i)"
                    class="badge rounded-pill cursor-pointer"
                    :class="auto.status == 1 ? 'alert-success' : 'alert-danger'"
                >
                  {{getStatus(auto.status)}}
                </span>
              </td>
              <td
                  data-th="Описание"
                  class="td-description"
              >
                {{auto.description}}
              </td>
              <td
                  data-th="Действия"
                  class="text-center"
              >
                <div class="actions-mobile">
                  <div class="d-flex align-items-center gap-2 fs-6">
                    <a
                        @click="getHistoryAuto(auto.product_id)"
                        class="text-primary cursor-pointer"
                    >
                      <i class="bi bi-archive"></i>
                    </a>
                    <a
                        :href="domain + auto.linkToSite"
                        target="_blank"
                        class="text-primary"
                        title="Открыть на сайте"
                    >
                      <i class="bi bi-eye-fill"></i>
                    </a>
                    <router-link
                        :to="`/auto/${auto.product_id}`"
                        class="text-warning"
                        title="Редактировать"
                    >
                      <i class="bi bi-pencil-fill"></i>
                    </router-link>
                    <a
                        @click="getPhotoAutoParts(auto.product_id)"
                        class="text-primary cursor-pointer"
                    >
                      <i class="bi bi-camera"></i>
                    </a>
                    <a
                        @click.prevent="autoPartsRemove(auto.product_id, i)"
                        class="text-danger"
                    >
                      <i class="bi bi-trash-fill"></i>
                    </a>
                  </div>
                  <div class="td-viewed">
                    Просмотров: {{auto.view}}
                  </div>
                  <div
                      @click="getPrintQrCodeAutoParts(auto.qrCode)"
                      class="btn btn-info"
                  >
                    Печать QR
                  </div>
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
            :records="autoPartsTotal"
            :per-page="20"
            @paginate="setPageByTotal"
            :options="paginationOptions"
        ></v-pagination>
      </div>
    </div>
  </div>
</template>

<script>
  import {DOMAIN, YEARS} from "@/constants/constants";
  import {mapActions, mapGetters} from "vuex";
  import Jquery from 'jquery'; // eslint-disable-line no-unused-vars
  import lightbox from 'lightbox2';

  export default {
    name: "AutoPartsList",

    mounted() {
      this.GET_AUTO_PARTS_FROM_API(this.param);
      this.GET_AUTO_PARTS_TOTALS(this.param);
      this.GET_TYPES_OF_AUTO_PARTS();
      this.GET_BREND_MODEL_CAR_AUTO_PARTS();
    },

    computed: {
      ...mapGetters('autoParts', [
        'AUTO_PARTS',
        'AUTO_PARTS_TOTALS',
        'TYPES_OF_AUTO_PARTS',
        'BREND_MODEL_CAR_AUTO_PARTS'
      ]),

      autoPartsTotal() {
        return parseInt(this.AUTO_PARTS_TOTALS);
      }
    },

    methods: {
      ...mapActions('autoParts', [
        'GET_AUTO_PARTS_FROM_API',
        'GET_AUTO_PARTS_TOTALS',
        'SET_SHOW_ALL_IMAGE',
        'GET_AUTO_PARTS_HISTORY',
        'DELET_AUTO_PARTS_BY_API',
        'GET_TYPES_OF_AUTO_PARTS',
        'GET_BREND_MODEL_CAR_AUTO_PARTS',
        'CHANGE_AUTO_PARTS_STATUS'
      ]),

      customLabelTypes({ name }) {
        return name;
      },

      customLabelModelBrand({ name }) {
        return name;
      },

      setEditThisColumnOnList() {
        this.columnEdit = !this.columnEdit;
      },

      setFilterOnAutoPartsPage() {
        this.GET_AUTO_PARTS_FROM_API(this.param);
        this.GET_AUTO_PARTS_TOTALS(this.param);
      },

      setPageByTotal(page) {
        this.param.pageNum = page;
        window.scrollTo(0, 0);
        this.GET_AUTO_PARTS_FROM_API(this.param);
      },

      getHistoryAuto(id) {
        this.$emit('getHistoryAuto');
        this.GET_AUTO_PARTS_HISTORY(id);
      },

      getPhotoAutoParts(id) {
        this.$emit('getPhotoAutoParts', id);
      },

      getStatus(status) {
        return (status == 1) ? 'Активно' : 'Неактивно';
      },

      getPrintQrCodeAutoParts(qr) {
        this.$emit('getPrintQrCodeAutoParts', qr);
      },

      changeStatus(id, status, i) {
        let param = {
          id: id,
          status: status,
          index: i
        };

        this.CHANGE_AUTO_PARTS_STATUS(param);
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

      autoPartsRemove(id, index) {
        if(confirm("Вы действительно хотите удалить данную запчасть ?")) {
          let param = {
            autoPartsId: id,
            autoPartsNumber: index
          };

          this.DELET_AUTO_PARTS_BY_API(param);
        }
      },
    },

    data() {
      return {
        domain: DOMAIN,
        years: YEARS,
        columnEdit: false,
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
@import "./src/components/autoParts/components/style/auto-parts-list";
@import "/node_modules/lightbox2/dist/css/lightbox.min.css";
@import "../../../../node_modules/vue-multiselect/dist/vue-multiselect.min.css";
@import "@/assets/scss/table-adaptive.scss";
</style>