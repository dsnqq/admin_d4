<template>
  <div class="card">
    <div class="card-header py-3">
      фильтра
    </div>
    <div class="card-body">
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
                v-for="(auto, i) in AUTO_TIRES"
                :key="i"
            >
              <td>
                <a
                    :href="domain + `/image/` + auto.images[0].imageBig"
                    :data-title="auto.autoTires.name"
                    :data-lightbox="auto.product_id"
                    class="product-box-image"
                >
                  <img
                      :src="auto.images[i].imageMini"
                      :alt="auto.autoTires.name"
                  />
                </a>
                <div class="product-box-image-flex">
                  <a
                      :data-lightbox="auto.product_id"
                      v-for="(image, i) in auto.images"
                      :key="i"
                      :data-title="auto.autoTires.name"
                      :href="domain + `/image/` + image.imageBig"
                      class="product-box-image--small"
                      v-show="image.imageShow"
                  >
                    <img
                        :src="image.imageMini"
                        :alt="auto.autoTires.name"
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
                  <h6 class="mb-0 product-title">{{auto.autoTires.name}}</h6>
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
              <td class="text-center">
                <div class="d-flex align-items-center gap-2 fs-6">
                  <a
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
                  <a class="text-primary cursor-pointer">
                    <i class="bi bi-camera"></i>
                  </a>
                  <a
                      v-on:click.prevent="autoTiresRemove(auto.product_id, i)"
                      class="text-danger"
                  >
                    <i class="bi bi-trash-fill"></i>
                  </a>
                </div>
                <div class="td-viewed">
                  Просмотров: {{auto.view}}
                </div>
                <div class="btn btn-info">Печать QR</div>
              </td>
            </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="row">
        <v-pagination
            v-model="param.pageNum"
            :records="autoTiresTotal"
            :per-page="20"
            @paginate="setPageByTotal"
            :options="paginationOptions"
        ></v-pagination>
      </div>
    </div>
  </div>
</template>

<script>
  import {DOMAIN} from "../../../constants/constants";
  import {mapActions, mapGetters} from "vuex";
  import Jquery from 'jquery'; // eslint-disable-line no-unused-vars
  import lightbox from 'lightbox2'; // eslint-disable-line no-unused-vars

  export default {
    name: "AutoTires",

    mounted() {
      this.GET_AUTO_TIRES_FROM_API(this.param.pageNum);
      this.GET_AUTO_TIRES_TOTALS();
    },

    computed: {
      ...mapGetters('autoTires', [
        'AUTO_TIRES',
        'AUTO_TIRES_TOTALS'
      ]),

      autoTiresTotal() {
        return parseInt(this.AUTO_TIRES_TOTALS);
      }
    },


    methods: {
      ...mapActions('autoTires', [
        'GET_AUTO_TIRES_FROM_API',
        'GET_AUTO_TIRES_TOTALS',
        'SET_SHOW_ALL_IMAGE',
        'GET_AUTO_TIRES_HISTORY',
        'DELET_AUTO_TIRES_BY_API'
      ]),

      setPageByTotal(page) {
        this.param.pageNum = page;
        this.GET_AUTO_TIRES_FROM_API(this.param.pageNum);
      },

      getStatus(status) {
        return (status == 1) ? 'Активно' : 'Неактивно';
      },

      showImageAll(id) {
        this.SET_SHOW_ALL_IMAGE(id);
      },

      autoTiresRemove(id, index) {
        if(confirm("Вы действительно хотите удалить данную шину ?")) {
          let param = {
            autoTiresId: id,
            autoTiresNumber: index
          };

          this.DELET_AUTO_TIRES_BY_API(param);
        }
      },
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
@import "./src/components/autoTires/components/style/auto-tires-list";
@import "/node_modules/lightbox2/dist/css/lightbox.min.css";
</style>
