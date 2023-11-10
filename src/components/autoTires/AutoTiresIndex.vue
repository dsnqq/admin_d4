<template>
  <div class="auto-tires-index">
    <BaseAlert
        v-if="errorValidate != ''"
        :errorValidate="errorValidate"
        @closeAlertMessage="closeAlertMessage"
    />
    <Breadcrumb>
      <template v-slot:buttons>
        <router-link
            :to="{name: 'autoTires'}"
            class="btn btn-primary"
        >
          Выйти
        </router-link>
      </template>
    </Breadcrumb>
    <div class="card">
      <div class="card-body">
        <div class="row">
          <form>
            <div class="auto-tires-index__wrapp auto-tires-index-wrapp">
              <AutoTiresIndexField
                  label="Статус"
                  class="auto-tires-index-wrapp__field"
              >
                <BaseMultiselect
                    v-model="AUTO_TIRES_INDEX.status"
                    :options="STATUS"
                    id="status"
                    placeholder="Статус"
                    class="auto-tires-index-field__select"
                />
              </AutoTiresIndexField>
              <AutoTiresIndexField
                  label="Ширина, высота, R"
                  class="auto-tires-index-wrapp__field"
                  required
                  className="auto-tires-index-field__wrap--is-flex auto-tires-index-field__wrap--is-three"
              >
                <BaseMultiselect
                    v-model="AUTO_TIRES_INDEX.width"
                    :options="WIDTH"
                    placeholder="Ширина"
                    id="width"
                    class="auto-tires-index-field__select"
                />
                <BaseMultiselect
                    v-model="AUTO_TIRES_INDEX.height"
                    :options="HEIGHT"
                    placeholder="Высота"
                    id="height"
                    class="auto-tires-index-field__select"
                />
                <BaseMultiselect
                    v-model="AUTO_TIRES_INDEX.rSize"
                    :options="R_SIZE"
                    id="rSize"
                    placeholder="R"
                    class="auto-tires-index-field__select"
                />
              </AutoTiresIndexField>
              <AutoTiresIndexField
                  label="Марка"
                  class="auto-tires-index-wrapp__field"
                  className="auto-tires-index-field__wrap--is-flex auto-tires-index-field__wrap--is-too"
                  required
              >
                <BaseMultiselect
                    v-model="AUTO_TIRES_INDEX.marka"
                    :options="MARKA"
                    id="marka"
                    placeholder="Марка"
                    class="auto-tires-index-field__select"
                />
                <input
                    v-model="AUTO_TIRES_INDEX.modelS"
                    type="text"
                    placeholder="Модель"
                    class="auto-tires-index-field__input"
                />
              </AutoTiresIndexField>
              <AutoTiresIndexField
                  label="Состояние, сезон, количество"
                  class="auto-tires-index-wrapp__field"
                  required
                  className="auto-tires-index-field__wrap--is-flex auto-tires-index-field__wrap--is-three"
              >
                <BaseMultiselect
                    v-model="AUTO_TIRES_INDEX.condition"
                    :options="CONDITION"
                    id="condition"
                    placeholder="Состояние"
                    class="auto-tires-index-field__select"
                />
                <BaseMultiselect
                    v-model="AUTO_TIRES_INDEX.season"
                    :options="SEASON"
                    id="season"
                    placeholder="Cезон"
                    class="auto-tires-index-field__select"
                />
                <input
                    v-model="AUTO_TIRES_INDEX.quantity"
                    type="text"
                    placeholder="Кол-во"
                    class="auto-tires-index-field__input"
                />
              </AutoTiresIndexField>
              <AutoTiresIndexField
                  label="Тип авто, год выпуска шин"
                  class="auto-tires-index-wrapp__field"
                  className="auto-tires-index-field__wrap--is-flex auto-tires-index-field__wrap--is-too"
              >
                <BaseMultiselect
                    v-model="AUTO_TIRES_INDEX.type"
                    :options="BODYS"
                    id="type"
                    placeholder="Тип авто"
                    class="auto-tires-index-field__select"
                />
                <BaseMultiselect
                    v-model="AUTO_TIRES_INDEX.year"
                    :options="YEARS"
                    id="year"
                    placeholder="Год"
                    class="auto-tires-index-field__select"
                />
              </AutoTiresIndexField>
              <AutoTiresIndexField
                  label="Описание"
                  class="auto-tires-index-wrapp__field"
              >
                  <textarea
                      v-model="AUTO_TIRES_INDEX.description"
                      placeholder="Описание"
                      class="auto-tires-index-field__textarea"
                  ></textarea>
              </AutoTiresIndexField>
              <AutoTiresIndexField
                  label="Артикул (автоматически)"
                  class="auto-tires-index-wrapp__field"
              >
                <input
                    v-model="AUTO_TIRES_INDEX.model"
                    type="text"
                    placeholder="Артикул"
                    class="auto-tires-index-field__input"
                >
              </AutoTiresIndexField>
              <AutoTiresIndexField
                  label="Цена в за единицу"
                  class="auto-tires-index-wrapp__field"
                  required
              >
                <input
                    v-model="AUTO_TIRES_INDEX.priceUSD"
                    type="number"
                    placeholder="Цена"
                    class="auto-tires-index-field__input"
                >
              </AutoTiresIndexField>
              <div
                  @click="toggleDopFields"
                  class="auto-tires-index-wrapp__field auto-tires-index-field"
              >
                <label class="auto-tires-index-field__label cursor-pointer color-blue">
                  Дополнительные поля (<span v-html="!dopFields ? 'Показать' : 'Скрыть'"></span>)
                </label>
              </div>
              <div v-show="dopFields">
                <AutoTiresIndexField
                    label="Имя для связи"
                    class="auto-tires-index-wrapp__field"
                >
                  <input
                      v-model="AUTO_TIRES_INDEX.firstname"
                      type="text"
                      placeholder="Имя для связи"
                      class="auto-tires-index-field__input"
                  >
                </AutoTiresIndexField>
                <AutoTiresIndexField
                    label="Складская информация"
                    class="auto-tires-index-wrapp__field"
                >
                  <input
                      v-model="AUTO_TIRES_INDEX.stock"
                      type="text"
                      placeholder="Складская информация"
                      class="auto-tires-index-field__input"
                  >
                </AutoTiresIndexField>
                <AutoTiresIndexField
                    label="Телефон, если другой"
                    class="auto-tires-index-wrapp__field"
                >
                  <input
                      v-model="AUTO_TIRES_INDEX.telephone"
                      type="text"
                      placeholder="Телефон, если другой"
                      class="auto-tires-index-field__input"
                  >
                </AutoTiresIndexField>
              </div>
              <AutoTiresIndexField
                  label="Фото"
                  class="auto-tires-index-wrapp__field"
                  className="auto-tires-index-field-wrap"
              >
                <div class="auto-tires-index-field-wrap__photos auto-tires-index-photo-list">
                  <template v-if="AUTO_TIRES_INDEX.images">
                    <div
                        v-for="(image, index) in AUTO_TIRES_INDEX.images"
                        v-bind:key="index"
                        class="auto-tires-index-photo-list__item auto-tires-index-photo-item"
                    >
                      <img
                          :src="isImageUrlLocalOrServer(image)"
                          class="auto-tires-index-photo-item__image"
                      />
                      <div
                          @click="removeImgDop(index)"
                          class="auto-tires-index-photo-item__del"
                      >Удалить</div>
                      <div
                          @click="setThisPhotoOnMain(image)"
                          class="auto-tires-index-photo-item__del"
                          :class="{'auto-tires-index-photo-item__del--is-active' :mainPhotoSetAutoTires(image)}"
                      >Главное фото</div>
                    </div>
                  </template>
                </div>
                <button
                    @click.prevent="modalCarPhotoFade"
                    class="auto-tires-index-field-wrap__btn btn btn-dark"
                >
                  Добавить фото
                </button>
              </AutoTiresIndexField>
              <component
                  :is="getAutoTiresIndexButtonsComponent"
                  :qrCode="AUTO_TIRES_INDEX.qrCode"
                  :linkToSite="AUTO_TIRES_INDEX.linkToSite"
                  @editAutoTires="editAutoTires"
                  @setAutoTiresFromApi="setAutoTiresFromApi"
              ></component>
            </div>
          </form>
        </div>
      </div>
    </div>
    <Modal
        v-show="showModal"
        @closeModalAdmin="modalCarPhotoFade"
    >
      <template v-slot:header>
        Добавление фото
      </template>
      <template>
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
      </template>
    </Modal>
  </div>
</template>

<script>
import AutoTiresIndexField from "@/components/autoTires/AutoTiresIndexField.vue";
import BaseMultiselect from "@/components/UI/BaseMultiselect.vue";
import Breadcrumb from "@/components/UI/BaseBreadcrumb.vue";
import {mapActions, mapGetters} from "vuex";
import {DOMAIN, STATUS, YEARS, BODYS, TRANSMISSION, WIDTH, HEIGHT, MARKA, CONDITION, SEASON, R_SIZE, TYPE_ENGINES_ALL} from "@/constants/constants";
import vue2Dropzone from 'vue2-dropzone';

export default {
  name: "AutoTiresIndex",

  components: {
    Breadcrumb,
    vueDropzone: vue2Dropzone,
    BaseMultiselect,
    AutoTiresIndexField,
    BaseAlert: () => import("@/components/UI/BaseAlert.vue"),
    Modal: () => import("@/components/UI/BaseModal.vue"),
    AutoTiresIndexButtonsCreate: () => import("@/components/autoTires/AutoTiresIndexButtonsCreate.vue"),
    AutoTiresIndexButtonsEdit: () => import("@/components/autoTires/AutoTiresIndexButtonsEdit.vue")
  },

  mounted() {
    this.resetAutoTiresForCreatePage();

    if(!this.isCreatedPage) {
      this.GET_AUTO_TIRES_INDEX(this.param);
    }
  },

  computed: {
    ...mapGetters('autoTires', [
      'AUTO_TIRES_INDEX'
    ]),

    getAutoTiresIndexButtonsComponent() {
      return (!this.isCreatedPage) ? 'AutoTiresIndexButtonsEdit' : 'AutoTiresIndexButtonsCreate';
    },

    isCreatedPage() {
      return this.$route.name === "autoTiresCreate";
    }
  },

  watch: {
    '$route' () {
      this.resetAutoTiresForCreatePage();
    },
  },

  methods: {
    ...mapActions('autoTires', [
      'GET_AUTO_TIRES_INDEX',
      'EDIT_AUTO_TIRES_FROM_API',
      'SET_AUTO_TIRES_IMAGE_FROM_USER',
      'SET_AUTO_TIRES_FROM_API',
      'RESET_AUTO_TIRES_FOR_CREATE_PAGE'
    ]),

    resetAutoTiresForCreatePage() {
      this.RESET_AUTO_TIRES_FOR_CREATE_PAGE();
      this.AUTO_TIRES_INDEX.status = "Активно";
    },

    mainPhotoSetAutoTires(image){
      return this.AUTO_TIRES_INDEX.mainImage == image;
    },

    validateForm() {
      this.errorValidate = "";

      if(!("year" in this.AUTO_TIRES_INDEX)){
        this.errorValidate = "Заполните поле год!";
      }

      if(!("priceUSD" in this.AUTO_TIRES_INDEX)){
        this.errorValidate = "Заполните поле цена!";
      }

      if(this.errorValidate) {
        window.scrollTo(0, 0);
      }
    },

    setAutoTiresFromApi(redirect) {
      this.validateForm();

      if(!this.errorValidate) {
        let param = {
          redirect: redirect,
          fields: this.getFormDataAboutAutoTires()
        }

        this.SET_AUTO_TIRES_FROM_API(param);
        this.$refs.myVueDropzone.removeAllFiles();
      }
    },

    editAutoTires(redirect) {
      this.validateForm();

      if(!this.errorValidate) {
        let postAutoTiresInformation = {
          autoTires: this.getFormDataAboutAutoTires(),
          id: this.param.id,
          redirect: redirect
        };

        this.EDIT_AUTO_TIRES_FROM_API(postAutoTiresInformation);
      }
    },

    setThisPhotoOnMain(image) {
      this.AUTO_TIRES_INDEX.mainImage = image;
    },

    toggleDopFields() {
      this.dopFields = !this.dopFields;
    },

    removeImgDop(index) {
      this.AUTO_TIRES_INDEX.images.splice(index, 1);
      this.AUTO_TIRES_INDEX.imagesServer.splice(index, 1);

      if(this.AUTO_TIRES_INDEX.images.length == 0) {
        this.AUTO_TIRES_INDEX.mainImage = "";
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

    getFormDataAboutAutoTires() {
      let xForm = new FormData();

      for (let key in this.AUTO_TIRES_INDEX) {
        if(this.AUTO_TIRES_INDEX[key] !== undefined) {
          xForm.append(key, this.AUTO_TIRES_INDEX[key]);
        }
      }

      if(this.AUTO_TIRES_INDEX.status !== undefined){
        let status = (this.AUTO_TIRES_INDEX.status == 'Активно') ? '1' : '0';
        xForm.append('status', status);
      }

      if(this.AUTO_TIRES_INDEX.imagesServer !== undefined) {
        xForm.append('images', this.AUTO_TIRES_INDEX.imagesServer);
      }

      if(this.AUTO_TIRES_INDEX.mainImage !== undefined) {
        xForm.append('imagesMain', this.AUTO_TIRES_INDEX.mainImage);
      } else if(this.AUTO_TIRES_INDEX.imagesServer !== undefined) {
        xForm.append('imagesMain', this.AUTO_TIRES_INDEX.imagesServer[0]);
      }

      return xForm;
    },

    sendingEvent(file) {
      this.showModal = false;
      this.SET_AUTO_TIRES_IMAGE_FROM_USER(file);
    },

    customLabelNameReturn({ name }) {
      return name;
    },

    closeAlertMessage() {
      this.errorValidate = "";
    },
  },

  data() {
    return {
      errorValidate: "",
      dopFields: false,
      param: {
        id: this.$route.params.id
      },
      showModal: false,
      countAutoTiresAdd: 1,
      autoTiresModelBrands: [],
      domain: DOMAIN,
      STATUS,
      YEARS,
      BODYS,
      TRANSMISSION,
      WIDTH,
      HEIGHT,
      MARKA,
      SEASON,
      CONDITION,
      R_SIZE,
      typeEngines: TYPE_ENGINES_ALL,
      dropzoneOptions: {
        url: '/upload.php',
        thumbnailWidth: 150,
        thumbnailHeight: 150,
        maxFilesize: 2500,
        autoProcessQueue: false,
        dictDefaultMessage: 'Нажмите сюда или перетащите сюда файлы для загрузки <div><span style="color: darkgrey; margin-bottom: 5px">* для выбора нескольких фото, удерживайте клавишу Ctrl</span><br/></div><br/>',
        dictRemoveFile: 'удалить',
        dictCancelUpload: 'отменить',
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
@import "../../../node_modules/vue-multiselect/dist/vue-multiselect.min.css"
@import "@/components/autoTires/style/auto-tires-index.scss"
</style>
