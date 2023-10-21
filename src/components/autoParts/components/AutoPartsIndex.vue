<template>
  <div class="auto-parts-index">
    <BreadcrumbAdmin>
      <template v-slot:buttons>
        <router-link
            :to="{name: 'autoParts'}"
            class="btn btn-primary"
        >
          Вернуться назад
        </router-link>
      </template>
    </BreadcrumbAdmin>
    <div class="card">
      <div class="card-header py-3">
        Тут скоро будет больше удобных функций
      </div>
      <div class="card-body">
        <div class="row">
          <form>
            <div class="auto-parts-index__wrapp auto-parts-index-wrapp">
              <div class="auto-parts-index-wrapp__field auto-parts-index-field">
                <label class="auto-parts-index-field__label">
                  Статус:
                </label>
                <div class="auto-parts-index-field__wrap">
                  <v-multiselect
                      v-model="AUTO_PARTS_INDEX.status"
                      :options="STATUS"
                      :selectedLabel="`Выбрано`"
                      :deselectLabel="`Клик, чтобы удалить`"
                      :selectLabel="`Клик, чтобы выбрать`"
                      :placeholder="`Статус`"
                      class="auto-parts-index-field__select"
                  >
                    <template v-slot:noResult>
                      Пусто...
                    </template>
                  </v-multiselect>
                </div>
              </div>
              <div class="auto-parts-index-wrapp__field auto-parts-index-field">
                <label class="auto-parts-index-field__label auto-parts-index-field__label--is-required">
                  Марка и модель:
                </label>
                <div class="auto-parts-index-field__wrap">
                  <v-multiselect
                      v-model="AUTO_PARTS_INDEX.autoPartsModelBrand"
                      :options="BREND_MODEL_CAR_AUTO_PARTS"
                      :custom-label="customLabelModelBrand"
                      :selectedLabel="`Выбрано`"
                      :deselectLabel="`Клик, чтобы удалить`"
                      :selectLabel="`Клик, чтобы выбрать`"
                      :placeholder="`Марка и Модель`"
                      class="auto-parts-index-field__select"
                  >
                    <template v-slot:noResult>
                      Пусто...
                    </template>
                  </v-multiselect>
                </div>
              </div>
              <div class="auto-parts-index-wrapp__field auto-parts-index-field">
                <label class="auto-parts-index-field__label auto-parts-index-field__label--is-required">
                  Год:
                </label>
                <div class="auto-parts-index-field__wrap auto-parts-index-field__wrap--is-flex auto-parts-index-field__wrap--is-too">
                  <v-multiselect
                      v-model="AUTO_PARTS_INDEX.year"
                      :options="YEARS"
                      :selectedLabel="`Выбрано`"
                      :deselectLabel="`Клик, чтобы удалить`"
                      :selectLabel="`Клик, чтобы выбрать`"
                      :placeholder="`Год`"
                      @select="getFuelToTypeEngines"
                      class="auto-parts-index-field__select"
                  >
                    <template v-slot:noResult>
                      Пусто...
                    </template>
                  </v-multiselect>
                  <input
                      v-model="AUTO_PARTS_INDEX.modification"
                      type="text"
                      placeholder="Модификация"
                      class="auto-parts-index-field__input"
                  />
                </div>
              </div>
              <div class="auto-parts-index-wrapp__field auto-parts-index-field">
                <label class="auto-parts-index-field__label">
                  Объем (л), топливо и тип:
                </label>
                <div class="auto-parts-index-field__wrap auto-parts-index-field__wrap--is-flex auto-parts-index-field__wrap--is-three">
                  <input
                      v-model="AUTO_PARTS_INDEX.value"
                      type="text"
                      placeholder="Объём"
                      class="auto-parts-index-field__input"
                  />
                  <v-multiselect
                      v-model="AUTO_PARTS_INDEX.fuel"
                      :options="FUELS"
                      :selectedLabel="`Выбрано`"
                      :deselectLabel="`Клик, чтобы удалить`"
                      :selectLabel="`Клик, чтобы выбрать`"
                      :placeholder="`Топливо`"
                      @select="getFuelToTypeEngines"
                      class="auto-parts-index-field__select"
                  >
                    <template v-slot:noResult>
                      Пусто...
                    </template>
                  </v-multiselect>
                  <v-multiselect
                      v-model="AUTO_PARTS_INDEX.typeEngines"
                      :options="this.typeEngines"
                      :selectedLabel="`Выбрано`"
                      :deselectLabel="`Клик, чтобы удалить`"
                      :selectLabel="`Клик, чтобы выбрать`"
                      :placeholder="`Тип`"
                      class="auto-parts-index-field__select"
                  >
                    <template v-slot:noResult>
                      Пусто...
                    </template>
                  </v-multiselect>
                </div>
              </div>
              <div class="auto-parts-index-wrapp__field auto-parts-index-field">
                <label class="auto-parts-index-field__label">
                  Тип кузова и коробка:
                </label>
                <div class="auto-parts-index-field__wrap auto-parts-index-field__wrap--is-flex auto-parts-index-field__wrap--is-too">
                  <v-multiselect
                      v-model="AUTO_PARTS_INDEX.typeBody"
                      :options="BODYS"
                      :selectedLabel="`Выбрано`"
                      :deselectLabel="`Клик, чтобы удалить`"
                      :selectLabel="`Клик, чтобы выбрать`"
                      :placeholder="`Кузов`"
                      class="auto-parts-index-field__select"
                  >
                    <template v-slot:noResult>
                      Пусто...
                    </template>
                  </v-multiselect>
                  <v-multiselect
                      v-model="AUTO_PARTS_INDEX.transmission"
                      :options="TRANSMISSION"
                      :selectedLabel="`Выбрано`"
                      :deselectLabel="`Клик, чтобы удалить`"
                      :selectLabel="`Клик, чтобы выбрать`"
                      :placeholder="`Коробка`"
                      class="auto-parts-index-field__select"
                  >
                    <template v-slot:noResult>
                      Пусто...
                    </template>
                  </v-multiselect>
                </div>
              </div>
              <div class="auto-parts-index-wrapp__field auto-parts-index-field">
                <label class="auto-parts-index-field__label auto-parts-index-field__label--is-required">
                  Запчасть:
                </label>
                <div class="auto-parts-index-field__wrap">
                  <v-multiselect
                      v-model="AUTO_PARTS_INDEX.autoPartsName"
                      :options="TYPES_OF_AUTO_PARTS"
                      :custom-label="customLabelTypes"
                      :selectedLabel="`Выбрано`"
                      :deselectLabel="`Клик, чтобы удалить`"
                      :selectLabel="`Клик, чтобы выбрать`"
                      :placeholder="`Запчасть`"
                      class="auto-parts-index-field__select"
                  >
                    <template v-slot:noResult>
                      Пусто...
                    </template>
                  </v-multiselect>
                </div>
              </div>
              <div class="auto-parts-index-wrapp__field auto-parts-index-field">
                <label class="auto-parts-index-field__label">
                  Описание:
                </label>
                <div class="auto-parts-index-field__wrap">
                  <textarea
                      v-model="AUTO_PARTS_INDEX.description"
                      placeholder="Описание"
                      class="auto-parts-index-field__textarea"
                  ></textarea>
                </div>
              </div>
              <div class="auto-parts-index-wrapp__field auto-parts-index-field">
                <label class="auto-parts-index-field__label">
                  Артикул (ext_id автоматически):
                </label>
                <div class="auto-parts-index-field__wrap">
                  <input
                      v-model="AUTO_PARTS_INDEX.model"
                      type="text"
                      placeholder="Артикул"
                      class="auto-parts-index-field__input"
                  >
                </div>
              </div>
              <div class="auto-parts-index-wrapp__field auto-parts-index-field">
                <label class="auto-parts-index-field__label">
                  Номер запчасти:
                </label>
                <div class="auto-parts-index-field__wrap">
                  <input
                      v-model="AUTO_PARTS_INDEX.sparePartNumber"
                      type="text"
                      placeholder="Номер запчасти"
                      class="auto-parts-index-field__input"
                  >
                </div>
              </div>
              <div class="auto-parts-index-wrapp__field auto-parts-index-field">
                <label class="auto-parts-index-field__label auto-parts-index-field__label--is-required">
                  Цена в долларах:
                </label>
                <div class="auto-parts-index-field__wrap">
                  <input
                      v-model="AUTO_PARTS_INDEX.priceUSD"
                      type="number"
                      placeholder="Цена в долларах"
                      class="auto-parts-index-field__input"
                  >
                </div>
              </div>
              <div class="auto-parts-index-wrapp__field auto-parts-index-field">
                <label class="auto-parts-index-field__label">
                  Код видео с youtube.com:
                </label>
                <div class="auto-parts-index-field__wrap">
                  <input
                      v-model="AUTO_PARTS_INDEX.youtube"
                      type="text"
                      placeholder="Видео"
                      class="auto-parts-index-field__input"
                  >
                </div>
              </div>
              <div class="auto-parts-index-wrapp__field auto-parts-index-field">
                <label class="auto-parts-index-field__label">
                  Фото:
                </label>
                <div class="auto-parts-index-field__wrap auto-parts-index-field-wrap">
                  <div class="auto-parts-index-field-wrap__photos auto-parts-index-photo-list">
                    <template v-if="AUTO_PARTS_INDEX.images">
                      <div
                          v-for="(image, index) in AUTO_PARTS_INDEX.images"
                          v-bind:key="index"
                          class="auto-parts-index-photo-list__item auto-parts-index-photo-item"
                      >
                        <img
                            :src="isImageUrlLocalOrServer(image)"
                            class="auto-parts-index-photo-item__image"
                        />
                        <div
                            @click="removeImgDop(index)"
                            class="auto-parts-index-photo-item__del"
                        >Удалить</div>
                        <div
                            @click="setThisPhotoOnMain(image)"
                            class="auto-parts-index-photo-item__del"
                            :class="{'auto-parts-index-photo-item__del--is-active' :mainPhotoSetAutoParts(image)}"
                        >Главное фото</div>
                      </div>
                    </template>
                  </div>
                  <button
                      @click.prevent="modalCarPhotoFade"
                      class="auto-parts-index-field-wrap__btn btn btn-primary"
                  >
                    Добавить фото
                  </button>
                </div>
              </div>
              <div class="auto-parts-index-wrapp__field auto-parts-index-field auto-parts-index-field--is-btn">
                <button
                    v-if="isCreatedPage"
                    @click.prevent="setAutoPartsFromApi"
                    class="btn btn-primary"
                >
                  Добавить объявление
                </button>
                <button
                    v-else
                    @click.prevent="editAutoParts"
                    class="btn btn-primary"
                >
                  Сохранить
                </button>
                <button
                    class="btn btn-success"
                >
                  Сохранить и продолжить редактирование
                </button>
                <router-link
                    :to="{name: 'autoParts'}"
                    class="btn btn-info"
                >
                    Выйти без сохранения
                </router-link>
                <a
                    :href="domain + AUTO_PARTS_INDEX.linkToSite"
                    target="_blank"
                    class="btn btn-warning"
                >
                  Посмотреть на сайте
                </a>
                <button
                    v-if="!isCreatedPage"
                    @click.prevent="printQrAutoParts"
                    class="btn btn-dark"
                >
                  Печать QR
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div
        class="modal-mask"
        v-show="showModal"
    >
      <div class="modal-wrapper">
        <div class="modal-container">
          <div class="modal-body">
            <button class="modal-default-button" @click.prevent="modalCarPhotoFade">
              X
            </button>
            <vue-dropzone
                v-on:vdropzone-sending="sendingEvent"
                :options="dropzoneOptions"
                ref="myVueDropzone"
                id="dropzone"
            ></vue-dropzone>
            <button
                @click.prevent="sendingDropzonePhoto"
                class="btn btn-info"
                id="submit-all"
            >Загрузить изображения</button>
          </div>
        </div>
      </div>
    </div>
    <iframe name="autoPartsQrCode" class="auto-parts-index__iframe"></iframe>
  </div>
</template>

<script>
  import BreadcrumbAdmin from "@/components/BreadcrumbAdmin.vue";
  import {mapActions, mapGetters} from "vuex";
  import {DOMAIN} from "@/constants/constants";
  import {STATUS, YEARS, BODYS, TRANSMISSION, FUELS, TYPE_ENGINES_ALL, TYPE_ENGINES_DISEL, TYPE_ENGINES_BENZ} from "@/constants/constants";
  import vue2Dropzone from 'vue2-dropzone';

  export default {
    name: "AutoParstIndex",

    components: {
      BreadcrumbAdmin,
      vueDropzone: vue2Dropzone,
    },

    mounted() {
      if(!this.isCreatedPage) {
        this.GET_AUTO_PARTS_INDEX(this.param);
      }

      this.GET_BREND_MODEL_CAR_AUTO_PARTS();
      this.GET_TYPES_OF_AUTO_PARTS();
    },

    computed: {
      ...mapGetters('autoParts', [
          'AUTO_PARTS_INDEX',
          'BREND_MODEL_CAR_AUTO_PARTS',
          'TYPES_OF_AUTO_PARTS'
      ]),

      isCreatedPage() {
        return this.$route.name === "autoPartsCreate";
      },
    },

    methods: {
      ...mapActions('autoParts', [
        'GET_AUTO_PARTS_INDEX',
        'GET_BREND_MODEL_CAR_AUTO_PARTS',
        'GET_TYPES_OF_AUTO_PARTS',
        'EDIT_AUTO_PARTS_FROM_API',
        'SET_AUTO_PARTS_IMAGE_FROM_USER',
        'SET_AUTO_PARTS_FROM_API'
      ]),

      mainPhotoSetAutoParts(image){
        return this.AUTO_PARTS_INDEX.mainImage == image;
      },

      setAutoPartsFromApi() {
        let postAutoPartsInformation = {
          autoPartsNew: this.getFormDataAboutAutoParts(),
          autoPartsObject: this.AUTO_PARTS_INDEX
        };

        this.SET_AUTO_PARTS_FROM_API(postAutoPartsInformation);
      },

      setThisPhotoOnMain(image) {
        this.AUTO_PARTS_INDEX.mainImage = image;
      },

      removeImgDop(index) {
        this.AUTO_PARTS_INDEX.images.splice(index, 1);
        this.AUTO_PARTS_INDEX.imagesServer.splice(index, 1);

        if(this.AUTO_PARTS_INDEX.images.length == 0) {
          this.AUTO_PARTS_INDEX.mainImage = "";
        }
      },

      isImageUrlLocalOrServer(image) {
        if(image.substr(0, 4) === "data") {
          return image;
        }

        return this.domain + `/image/` + image;
      },

      sendingDropzonePhoto() {
        this.$refs.myVueDropzone.processQueue();
      },

      modalCarPhotoFade() {
        this.showModal = !this.showModal;
      },

      printQrAutoParts() {
        let isIframe = window.frames['autoPartsQrCode'];
        isIframe.document.write(this.AUTO_PARTS_INDEX.qrCode);
        isIframe.document.close();
      },

      getFormDataAboutAutoParts() {
        let xForm = new FormData();

        if(this.AUTO_PARTS_INDEX.year !== undefined){
          xForm.append('year', this.AUTO_PARTS_INDEX.year);
        }

        if(this.AUTO_PARTS_INDEX.status !== undefined){
          let status = (this.AUTO_PARTS_INDEX.status == 'Активно') ? '1' : '0';
          xForm.append('status', status);
        }

        if(this.AUTO_PARTS_INDEX.model !== undefined){
          xForm.append('model', this.AUTO_PARTS_INDEX.model);
        }

        if(this.AUTO_PARTS_INDEX.modification !== undefined){
          xForm.append('modification', this.AUTO_PARTS_INDEX.modification);
        }

        if(this.AUTO_PARTS_INDEX.fuel !== undefined){
          xForm.append('fuel', this.AUTO_PARTS_INDEX.fuel);
        }

        if(this.AUTO_PARTS_INDEX.value !== undefined){
          xForm.append('value', this.AUTO_PARTS_INDEX.value);
        }

        if(this.AUTO_PARTS_INDEX.youtube !== undefined){
          xForm.append('youtube', this.AUTO_PARTS_INDEX.youtube);
        }

        if(this.AUTO_PARTS_INDEX.typeEngines !== undefined){
          xForm.append('typeEngines', this.AUTO_PARTS_INDEX.typeEngines);
        }

        if(this.AUTO_PARTS_INDEX.transmission !== undefined){
          xForm.append('transmission', this.AUTO_PARTS_INDEX.transmission);
        }

        if(this.AUTO_PARTS_INDEX.typeBody !== undefined){
          xForm.append('typeBody', this.AUTO_PARTS_INDEX.typeBody);
        }

        if(this.AUTO_PARTS_INDEX.wheelDiameterR !== undefined){
          xForm.append('wheelDiameterR', this.AUTO_PARTS_INDEX.wheelDiameterR);
        }

        if(this.AUTO_PARTS_INDEX.wheelWidthJ !== undefined){
          xForm.append('wheelWidthJ', this.AUTO_PARTS_INDEX.wheelWidthJ);
        }

        if(this.AUTO_PARTS_INDEX.numberOfHoles !== undefined){
          xForm.append('numberOfHoles', this.AUTO_PARTS_INDEX.numberOfHoles);
        }

        if(this.AUTO_PARTS_INDEX.departureE !== undefined){
          xForm.append('departureE', this.AUTO_PARTS_INDEX.departureE);
        }

        if(this.AUTO_PARTS_INDEX.departureE !== undefined){
          xForm.append('departureE', this.AUTO_PARTS_INDEX.departureE);
        }

        if(this.AUTO_PARTS_INDEX.sparePartNumber !== undefined){
          xForm.append('sparePartNumber', this.AUTO_PARTS_INDEX.sparePartNumber);
        }

        if(this.AUTO_PARTS_INDEX.pcd !== undefined){
          xForm.append('pcd', this.AUTO_PARTS_INDEX.pcd);
        }

        if(this.AUTO_PARTS_INDEX.priceUSD !== undefined){
          xForm.append('priceUSD', this.AUTO_PARTS_INDEX.priceUSD);
        }

        if(this.AUTO_PARTS_INDEX.autoPartsName !== undefined){
          xForm.append('autoPartsName', this.AUTO_PARTS_INDEX.autoPartsName.id);
        }

        if(this.AUTO_PARTS_INDEX.description !== undefined){
          xForm.append('description', this.AUTO_PARTS_INDEX.description);
        }

        if(this.AUTO_PARTS_INDEX.imagesServer !== undefined) {
          xForm.append('images', this.AUTO_PARTS_INDEX.imagesServer);
        }

        if(this.AUTO_PARTS_INDEX.mainImage !== undefined) {
          xForm.append('imagesMain', this.AUTO_PARTS_INDEX.mainImage);
        }

        return xForm;
      },

      sendingEvent(file) {
        this.showModal = false;
        this.SET_AUTO_PARTS_IMAGE_FROM_USER(file);
      },

      editAutoParts() {
        let postAutoPartsInformation = {
          autoParts: this.getFormDataAboutAutoParts(),
          id: this.param.id
        };

        this.EDIT_AUTO_PARTS_FROM_API(postAutoPartsInformation);
      },

      customLabelTypes({ name }) {
        return name;
      },

      customLabelModelBrand({ name }) {
        return name;
      },

      getFuelToTypeEngines(option) {
        if(option == 'дизель') {
          this.typeEngines = TYPE_ENGINES_DISEL;
        } else if(option == 'бензин') {
          this.typeEngines = TYPE_ENGINES_BENZ;
        } else {
          this.typeEngines = TYPE_ENGINES_ALL;
        }
      }
    },

    data() {
      return {
        param: {
          id: this.$route.params.id
        },
        showModal: false,
        domain: DOMAIN,
        STATUS,
        YEARS,
        BODYS,
        TRANSMISSION,
        FUELS,
        typeEngines: TYPE_ENGINES_ALL,
        dropzoneOptions: {
          url: '/upload.php',
          thumbnailWidth: 150,
          thumbnailHeight: 150,
          maxFilesize: 2500,
          autoProcessQueue: false,
          parallelUploads: 20,
          maxThumbnailFilesize: 200,
          resizeWidth: 800,
          timeout: 180000000,
          acceptedFiles: ".png,.jpg,.gif,.bmp,.jpeg",
          renameFile: function (file) {
            let newName = new Date().getTime() + '_' + file.name;
            return newName;
          }
        },
      };
    }
  }
</script>

<style scoped lang="sass">
@import "vue2-dropzone/dist/vue2Dropzone.min.css"
@import "../../../../node_modules/vue-multiselect/dist/vue-multiselect.min.css"
@import "@/components/autoParts/components/style/auto-parts-index.scss"
</style>