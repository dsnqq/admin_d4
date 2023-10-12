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
              <td>
                <a
                    :href="domain + `/image/` + autoPartsArchive.images[0].imageBig"
                    :data-title="autoPartsArchive.autoParts.name"
                    :data-lightbox="autoPartsArchive.product_id"
                    class="product-box-image"
                >
                  <img
                      :src="autoPartsArchive.images[i].imageMini"
                      :alt="autoPartsArchive.autoParts.name"
                  />
                </a>
                <div class="product-box-image-flex">
                  <a
                      :data-lightbox="autoPartsArchive.product_id"
                      v-for="(image, i) in autoPartsArchive.images"
                      :key="i"
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
                      v-on:click="showImageAll(i)"
                      class="product-more-photo"
                  >Ещё фото</span>
                </div>
              </td>
              <td>{{autoPartsArchive.name.marka + ' ' + autoPartsArchive.name.model}}</td>
              <td>{{autoPartsArchive.year}}</td>
              <td>{{autoPartsArchive.value}}</td>
              <td>{{autoPartsArchive.fuel + " " + autoPartsArchive.typeEngines}}</td>
              <td class="productlist">
                <span class="d-flex align-items-center gap-2">
                  <h6 class="mb-0 product-title">{{autoPartsArchive.autoParts.name}}</h6>
                </span>
              </td>
              <td>{{autoPartsArchive.model}}</td>
              <td>{{autoPartsArchive.priceUSD}}$</td>
              <td>{{autoPartsArchive.sparePartNumber}}</td>
              <td>{{autoPartsArchive.dateDeleted}}</td>
              <td class="td-description">
                {{autoPartsArchive.description}}
              </td>
              <td class="text-center">
                <div class="d-flex align-items-center justify-content-center gap-2 fs-6">
                  <a
                      v-on:click="getHistoryAuto(autoPartsArchive.product_id)"
                      class="text-primary cursor-pointer"
                  >
                    <i class="bi bi-archive"></i>
                  </a>
                  <a
                      v-on:click.prevent="autoPartsRestore(autoPartsArchive.product_id, i)"
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
import {DOMAIN} from "../../../constants/constants";
import {mapActions, mapGetters} from "vuex";
import Jquery from 'jquery'; // eslint-disable-line no-unused-vars
import lightbox from 'lightbox2'; // eslint-disable-line no-unused-vars

export default {
  name: "AutoPartsArchiveList",

  mounted() {
    this.GET_AUTO_PARTS_ARCHIVE_FROM_API(this.param.pageNum);
    this.GET_AUTO_PARTS_ARCHIVE_TOTALS();
  },

  computed: {
    ...mapGetters('autoPartsArchive', [
      'AUTO_PARTS_ARCHIVE',
      'AUTO_PARTS_ARCHIVE_TOTALS'
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
      'RESTORE_AUTO_PARTS_ARCHIVE_BY_API'
    ]),

    setPageByTotal(page) {
      this.param.pageNum = page;
      this.GET_AUTO_PARTS_ARCHIVE_FROM_API(this.param.pageNum);
    },

    getHistoryAuto(id) {
      this.$emit('getHistoryAuto');
      this.GET_AUTO_PARTS_ARCHIVE_HISTORY(id);
    },

    showImageAll(id) {
      this.SET_SHOW_ALL_IMAGE(id);
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
@import "./src/components/autoPartsArchive/components/style/auto-parts-archive-list";
@import "/node_modules/lightbox2/dist/css/lightbox.min.css";
</style>
