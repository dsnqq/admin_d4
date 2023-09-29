<template>
  <div>
    <div class="row">
      <div class="table-responsive">
        <table class="table align-middle table-striped table-border-1">
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
            <td>
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
                    v-for="(image, i) in auto.images"
                    :key="i"
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
                    v-on:click="showImageAll(i)"
                    class="product-more-photo"
                >Ещё фото</span>
              </div>
            </td>
            <td>{{ auto.name.marka + ' ' + auto.name.model}}</td>
            <td>{{auto.year}}</td>
            <td>{{auto.value}}</td>
            <td>{{auto.fuel + " " + auto.typeEngines}}</td>
            <td class="productlist">
              <span class="d-flex align-items-center gap-2">
                <h6 class="mb-0 product-title">{{auto.autoParts.name}}</h6>
              </span>
            </td>
            <td>{{auto.model}}</td>
            <td>{{auto.priceUSD}}$</td>
            <td>{{auto.sparePartNumber}}</td>
            <td>{{auto.dateAvailable}}</td>
            <td>
              <span class="badge rounded-pill alert-success">{{getStatus(auto.status)}}</span>
            </td>
            <td class="td-description">
              {{auto.description}}
            </td>
            <td>
              <div class="d-flex align-items-center gap-3 fs-6">
                <a class="text-primary"><i class="bi bi-eye-fill"></i></a>
                <a class="text-warning"><i class="bi bi-pencil-fill"></i></a>
                <a class="text-danger"><i class="bi bi-trash-fill"></i></a>
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
</template>

<script>
  import {DOMAIN} from "../../../constants/constants";
  import {mapActions, mapGetters} from "vuex";
  import Jquery from 'jquery'; // eslint-disable-line no-unused-vars
  import lightbox from 'lightbox2'; // eslint-disable-line no-unused-vars

  export default {
    name: "AutoPartsList",

    mounted() {
      this.GET_AUTO_PARTS_FROM_API(this.param.pageNum);
      this.GET_AUTO_PARTS_TOTALS();
    },

    computed: {
      ...mapGetters('autoParts', [
        'AUTO_PARTS',
        'AUTO_PARTS_TOTALS'
      ]),

      autoPartsTotal() {
        return parseInt(this.AUTO_PARTS_TOTALS);
      }
    },


    methods: {
      ...mapActions('autoParts', [
        'GET_AUTO_PARTS_FROM_API',
        'GET_AUTO_PARTS_TOTALS',
        'SET_SHOW_ALL_IMAGE'
      ]),

      setPageByTotal(page) {
        this.param.pageNum = page;
        this.GET_AUTO_PARTS_FROM_API(this.param.pageNum);
      },

      getStatus(status) {
        return (status == 1) ? 'Активно' : 'Неактивно';
      },

      showImageAll(id) {
        this.SET_SHOW_ALL_IMAGE(id);
      }
    },

    data() {
      return {
        domain: DOMAIN,
        param: {
          pageNum: 1,
        },
        paginationOptions: {
          chunk: 6,
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
</style>
