<template>
  <div class="card">
    <div class="card-body">
      <div class="row">
        <div>
          <table class="table align-middle table-striped table-border-1 rwd-table middle-responsive">
            <thead>
            <tr>
              <th>Изображение</th>
              <th>Год</th>
              <th>Название шины</th>
              <th>Артикул</th>
              <th>Цена за штуку</th>
              <th>Дата создания</th>
              <th>Статус</th>
              <th>Описание</th>
              <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            <tr
                v-for="(autoTire, i) in AUTO_TIRES"
                :key="i"
            >
              <td data-th="Изображение">
                <a
                    :href="domain + `/image/` + autoTire.images[0].imageBig"
                    :data-title="autoTire.name"
                    :data-lightbox="autoTire.product_id"
                    class="product-box-image"
                >
                  <img
                      :src="autoTire.images[i].imageMini"
                      :alt="autoTire.name"
                  />
                </a>
                <div class="product-box-image-flex">
                  <a
                      :data-lightbox="autoTire.product_id"
                      v-for="(image, i) in autoTire.images"
                      :key="i"
                      :data-title="autoTire.name"
                      :href="domain + `/image/` + image.imageBig"
                      class="product-box-image--small"
                      v-show="image.imageShow"
                  >
                    <img
                        :src="image.imageMini"
                        :alt="autoTire.name"
                    >
                  </a>
                  <span
                      v-if="!autoTire.imagesShowAllImage"
                      @click="showImageAll(i)"
                      class="product-more-photo"
                  >Ещё фото</span>
                </div>
              </td>
              <td data-th="Год">{{autoTire.year}}</td>
              <td
                  data-th="Название шины"
                  class="productlist"
              >
                  <h6
                      v-html="autoTire.name"
                      class="mb-0 product-title"
                  ></h6>
              </td>
              <td data-th="Артикул">{{autoTire.model}}</td>
              <td data-th="Цена за штуку">{{autoTire.priceUSD}}$</td>
              <td data-th="Дата создания">{{autoTire.dateAvailable}}</td>
              <td data-th="Статус">
                <span
                    class="badge rounded-pill"
                    :class="autoTire.status == 1 ? 'alert-success' : 'alert-danger'"
                >
                  {{getStatus(autoTire.status)}}
                </span>
              </td>
              <td
                  data-th="Описание"
                  class="td-description"
              >
                {{autoTire.description}}
              </td>
              <td
                  data-th="Действия"
                  class="text-center"
              >
                <div>
                  <div class="d-flex align-items-center justify-content-center gap-2 fs-6">
                    <a
                        :href="domain + autoTire.linkToSite"
                        target="_blank"
                        class="text-primary"
                        title="Открыть на сайте"
                    >
                      <i class="bi bi-eye-fill"></i>
                    </a>
                    <router-link
                        :to="`/auto/${autoTire.product_id}`"
                        class="text-warning"
                        title="Редактировать"
                    >
                      <i class="bi bi-pencil-fill"></i>
                    </router-link>
                    <a class="text-primary cursor-pointer">
                      <i class="bi bi-camera"></i>
                    </a>
                    <a
                        @click.prevent="autoTiresRemove(autoTire.product_id, i)"
                        class="text-danger"
                    >
                      <i class="bi bi-trash-fill"></i>
                    </a>
                  </div>
                  <div class="btn btn-info">Печать QR</div>
                </div>
              </td>
            </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div
          v-if="autoTiresTotal >= 20"
          class="row"
      >
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
  import {DOMAIN} from "@/constants/constants";
  import {mapActions, mapGetters} from "vuex";
  import Jquery from 'jquery'; // eslint-disable-line no-unused-vars
  import lightbox from 'lightbox2'; // eslint-disable-line no-unused-vars

  export default {
    name: "AutoTiresList",

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
        window.scrollTo(0, 0);
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
@import "./src/components/autoTires/components/style/auto-tires-list";
@import "/node_modules/lightbox2/dist/css/lightbox.min.css";
@import "@/assets/scss/table-adaptive.scss";
</style>
