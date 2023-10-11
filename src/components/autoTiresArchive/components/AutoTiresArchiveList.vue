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
                v-for="(autoTire, i) in AUTO_TIRES_ARCHIVE"
                :key="i"
            >
              <td>
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
                      v-on:click="showImageAll(i)"
                      class="product-more-photo"
                  >Ещё фото</span>
                </div>
              </td>
              <td>{{autoTire.year}}</td>
              <td class="productlist">
                <h6
                    v-html="autoTire.name"
                    class="mb-0 product-title"
                ></h6>
              </td>
              <td>{{autoTire.model}}</td>
              <td>{{autoTire.priceUSD}}$</td>
              <td>{{autoTire.dateAvailable}}</td>
              <td>
                <span
                    class="badge rounded-pill"
                    :class="autoTire.status == 1 ? 'alert-success' : 'alert-danger'"
                >
                  {{getStatus(autoTire.status)}}
                </span>
              </td>
              <td class="td-description">
                {{autoTire.description}}
              </td>
              <td class="text-center">
                <div class="d-flex align-items-center gap-2 fs-6">
                  <a
                      class="text-primary cursor-pointer"
                  >
                    <i class="bi bi-archive"></i>
                  </a>
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
                      v-on:click.prevent="autoTiresRemove(autoTire.product_id, i)"
                      class="text-danger"
                  >
                    <i class="bi bi-trash-fill"></i>
                  </a>
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
            :records="autoTiresArchiveTotal"
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
  name: "AutoTiresArchiveList",

  mounted() {
    this.GET_AUTO_TIRES_ARCHIVE_FROM_API(this.param.pageNum);
    this.GET_AUTO_TIRES_ARCHIVE_TOTALS();

    this.test = this.$store.state.autoTiresArchive;
  },

  computed: {
    ...mapGetters('autoTiresArchive', [
      'AUTO_TIRES_ARCHIVE',
      'AUTO_TIRES_ARCHIVE_TOTALS'
    ]),

    autoTiresArchiveTotal() {
      return parseInt(this.AUTO_TIRES_ARCHIVE_TOTALS);
    }
  },


  methods: {
    ...mapActions('autoTiresArchive', [
      'GET_AUTO_TIRES_ARCHIVE_FROM_API',
      'GET_AUTO_TIRES_ARCHIVE_TOTALS',
      'SET_SHOW_ALL_IMAGE',
      'GET_AUTO_TIRES_ARCHIVE_HISTORY',
      'RESTORE_AUTO_TIRES_ARCHIVE_BY_API'
    ]),

    setPageByTotal(page) {
      this.param.pageNum = page;
      this.GET_AUTO_TIRES_ARCHIVE_FROM_API(this.param.pageNum);
    },

    showImageAll(id) {
      this.SET_SHOW_ALL_IMAGE(id);
    },

    autoPartsRestore(id, index) {
      if(confirm("Вы действительно хотите восстановить данную шину ?")) {
        let param = {
          autoPartsId: id,
          autoPartsNumber: index
        };

        this.RESTORE_AUTO_TIRES_ARCHIVE_BY_API(param);
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
@import "./src/components/autoTiresArchive/components/style/auto-tires-archive-list";
@import "/node_modules/lightbox2/dist/css/lightbox.min.css";
</style>
