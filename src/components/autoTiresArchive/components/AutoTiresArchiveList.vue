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
              <th>Дата удаления</th>
              <th>Описание</th>
              <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            <tr
                v-for="(autoTireArchive, i) in AUTO_TIRES_ARCHIVE"
                :key="i"
            >
              <td data-th="Изображение">
                <template v-if="autoTireArchive.images">
                  <a
                      :href="domain + `/image/` + autoTireArchive.images[0].imageBig"
                      :data-title="autoTireArchive.name"
                      :data-lightbox="autoTireArchive.product_id"
                      class="product-box-image"
                  >
                    <img
                        :src="autoTireArchive.images[0].imageMini"
                        :alt="autoTireArchive.name"
                    />
                  </a>
                  <div class="product-box-image-flex">
                    <a
                        :data-lightbox="autoTireArchive.product_id"
                        v-for="(image, i) in autoTireArchive.images"
                        :key="i"
                        :data-title="autoTireArchive.name"
                        :href="domain + `/image/` + image.imageBig"
                        class="product-box-image--small"
                        v-show="image.imageShow"
                    >
                      <img
                          :src="image.imageMini"
                          :alt="autoTireArchive.name"
                      >
                    </a>
                    <span
                        v-if="!autoTireArchive.imagesShowAllImage"
                        @click="showImageAll(i)"
                        class="product-more-photo"
                    >Ещё фото</span>
                  </div>
                </template>
              </td>
              <td data-th="Год">{{autoTireArchive.year}}</td>
              <td
                  data-th="Название шины"
                  class="productlist"
              >
                <h6
                    v-html="autoTireArchive.name"
                    class="mb-0 product-title"
                ></h6>
              </td>
              <td data-th="Артикул">{{autoTireArchive.model}}</td>
              <td data-th="Цена">{{autoTireArchive.priceUSD}}$</td>
              <td data-th="Дата удаления">{{autoTireArchive.dateDeleted}}</td>
              <td
                  data-th="Описание"
                  class="td-description"
              >
                {{autoTireArchive.description}}
              </td>
              <td
                  data-th="Действия"
                  class="text-center"
              >
                <div class="d-flex align-items-center justify-content-center gap-1 fs-6">
                  <a
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
import {DOMAIN} from "@/constants/constants";
import {mapActions, mapGetters} from "vuex";
import Jquery from 'jquery'; // eslint-disable-line no-unused-vars
import lightbox from 'lightbox2'; // eslint-disable-line no-unused-vars

export default {
  name: "AutoTiresArchiveList",

  mounted() {
    this.GET_AUTO_TIRES_ARCHIVE_FROM_API(this.param.pageNum);
    this.GET_AUTO_TIRES_ARCHIVE_TOTALS();
  },

  computed: {
    ...mapGetters('autoTiresArchive', [
      'AUTO_TIRES_ARCHIVE',
      'AUTO_TIRES_ARCHIVE_TOTALS',
    ]),

    autoTiresArchiveTotal() {
      return parseInt(this.AUTO_TIRES_ARCHIVE_TOTALS);
    }
  },


  methods: {
    ...mapActions('autoTiresArchive', [
      'GET_AUTO_TIRES_ARCHIVE_FROM_API',
      'GET_AUTO_TIRES_ARCHIVE_TOTALS',
    ]),

    setPageByTotal(page) {
      this.param.pageNum = page;
      window.scrollTo(0, 0);
      this.GET_AUTO_TIRES_ARCHIVE_FROM_API(this.param.pageNum);
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
@import "./src/components/autoTiresArchive/components/style/auto-tires-archive-list";
@import "/node_modules/lightbox2/dist/css/lightbox.min.css";
@import "@/assets/scss/table-adaptive.scss";
</style>
