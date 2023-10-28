<template>
  <div>
    <Breadcrumb>
      <template v-slot:buttons>
        <router-link
            :to="{name: 'carsAdmin'}"
            class="btn btn-primary"
        >
          Вернуться назад
        </router-link>
      </template>
    </Breadcrumb>
    <div class="card">
      <div class="card-body">
        <form>
          <div class="car-index__wrapp car-index-wrapp">
            <div
                v-for="fieldItem in TABLE_HEADS"
                v-bind:key="fieldItem.id"
                :class="{'car-index-wrapp__field car-index-field': fieldItem.index}"
            >
              <template v-if="fieldItem.index">
                <label for="car" class="car-index-field__label">
                  {{fieldItem.name}}
                </label>
                <div class="car-index-field__wrap">
                  <template v-if="fieldItem.type === 'input'">
                    <input
                        type="text"
                        :id="fieldItem.login"
                        :placeholder="fieldItem.name"
                        class="car-index-field__input"
                        v-model="CAR[fieldItem.login]"
                    />
                  </template>
                  <template v-else-if="fieldItem.type === 'select'">
                    <v-multiselect
                        v-if="fieldItem.options"
                        v-model="CAR[fieldItem.login]"
                        :options="fieldItem.options"
                        :selectedLabel="`Выбрано`"
                        :deselectLabel="`Клик, чтобы удалить`"
                        :selectLabel="`Клик, чтобы выбрать`"
                        :placeholder="fieldItem.name"
                        class="auto-parts-index-field__select"
                    >
                      <template v-slot:noResult>
                        Пусто...
                      </template>
                    </v-multiselect>
                    <v-multiselect
                        v-else-if="fieldItem.optionsMarka"
                        v-model="CAR[fieldItem.login]"
                        :options="MARKA"
                        @input="getModelByMarkaApi"
                        :selectedLabel="`Выбрано`"
                        :deselectLabel="`Клик, чтобы удалить`"
                        :selectLabel="`Клик, чтобы выбрать`"
                        :placeholder="fieldItem.name"
                        class="auto-parts-index-field__select"
                    >
                      <template v-slot:noResult>
                        Пусто...
                      </template>
                    </v-multiselect>
                    <v-multiselect
                        v-else-if="fieldItem.optionsModel"
                        v-model="CAR[fieldItem.login]"
                        :options="MODEL"
                        :selectedLabel="`Выбрано`"
                        :deselectLabel="`Клик, чтобы удалить`"
                        :selectLabel="`Клик, чтобы выбрать`"
                        :placeholder="fieldItem.name"
                        class="auto-parts-index-field__select"
                    >
                      <template v-slot:noResult>
                        Пусто...
                      </template>
                    </v-multiselect>
                  </template>
                </div>
              </template>
            </div>
            <div class="car-index-wrapp__field car-index-field">
              <label for="color" class="car-index-field__label">Фото</label>
              <div class="car-index-field__wrap car-index-field-wrap">
                <div class="car-index-field-wrap__photos car-index-photo-list">
                  <template v-if="CAR.images">
                    <div
                        v-for="(image, index) in CAR.images"
                        v-bind:key="index"
                        class="car-index-photo-list__item car-index-photo-item"
                    >
                      <img
                          :src="isImageUrlLocalOrServer(image)"
                          class="car-index-photo-item__image"
                      />
                      <div
                          @click="removeImgDop(index)"
                          class="car-index-photo-item__del"
                      >
                        Удалить
                      </div>
                    </div>
                  </template>
                </div>
                <button
                    @click.prevent="modalCarPhotoFade"
                    class="car-index-field-wrap__btn btn btn-primary"
                >
                  Добавить фото
                </button>
              </div>
            </div>
            <div class="car-index-wrapp__field car-index-field car-index-field--is-btn">
              <button
                  v-if="isCreatedPage"
                  @click.prevent="setCarFromApi"
                  class="btn btn-primary"
              >
                Добавить объявление
              </button>
              <button
                  v-if="isEditPage"
                  @click.prevent="editCar"
                  class="btn btn-success"
              >
                Сохранить и продолжить редактирование
              </button>
              <router-link
                  :to="{name: 'carsAdmin'}"
                  class="btn btn-info"
              >
                Выйти без сохранения
              </router-link>
            </div>
          </div>
          <div
              class="modal-mask"
               v-show="showModal"
          >
            <div class="modal-wrapper">
              <div class="modal-container">
                <div class="modal-body">
                  <button
                      @click.prevent="modalCarPhotoFade"
                      class="modal-default-button"
                  >
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
        </form>
      </div>
    </div>
  </div>
</template>

<script>
  import Breadcrumb from "@/components/UI/BaseBreadcrumb.vue";
  import {mapActions, mapGetters} from "vuex";
  import {DOMAIN} from "@/constants/constants";
  import {TABLE_HEADS} from "@/components/carsAdmin/constants/constants";
  import vue2Dropzone from 'vue2-dropzone'

  export default {
    name: "CarIndex",

    components: {
      vueDropzone: vue2Dropzone,
      Breadcrumb
    },

    mounted() {
      if(!this.isCreatedPage) {
        this.GET_CAR_FROM_API(this.id);
      }
      this.GET_MARKA_FROM_API();
    },

    computed: {
      ...mapGetters('carAdmin', [
        'CAR',
        'MARKA',
        'MODEL'
      ]),

      isCreatedPage() {
        return this.$route.name === "carCreate";
      },

      isEditPage() {
        return this.$route.name === "carDetail";
      },
    },

    methods: {
      ...mapActions('carAdmin', [
          'GET_CAR_FROM_API',
          'SET_CAR_FROM_API',
          'SET_CAR_IMAGE_FROM_USER',
          'EDIT_CAR_FROM_API',
          'GET_MARKA_FROM_API',
          'GET_MODEL_FROM_API'
      ]),

      getModelByMarkaApi() {
        this.GET_MODEL_FROM_API(this.CAR.marka);
      },

      isImageUrlLocalOrServer(image) {
        if(image.substr(0, 4) === "data") {
          return image;
        }

        return this.domain + `/image/` + image;
      },

      removeImgDop(index) {
        this.CAR.images.splice(index, 1);
        this.CAR.imagesServer.splice(index, 1);
      },

      getFormDataAboutCar() {
        let xForm = new FormData();

        if(this.CAR.name !== undefined){
          xForm.append('name', this.CAR.name);
        }
        if(this.CAR.marka !== undefined) {
          xForm.append('marka', this.CAR.marka);
        }
        if(this.CAR.model !== undefined) {
          xForm.append('model', this.CAR.model);
        }
        if(this.CAR.vin !== undefined) {
          xForm.append('vin', this.CAR.vin);
        }
        if(this.CAR.country !== undefined) {
          xForm.append('country', this.CAR.country);
        }
        if(this.CAR.year !== undefined) {
          xForm.append('year', this.CAR.year);
        }
        if(this.CAR.power !== undefined) {
          xForm.append('power', this.CAR.power);
        }
        if(this.CAR.volume !== undefined) {
          xForm.append('volume', this.CAR.volume);
        }
        if(this.CAR.typePower !== undefined) {
          xForm.append('typePower', this.CAR.typePower);
        }
        if(this.CAR.aboutPower !== undefined) {
          xForm.append('aboutPower', this.CAR.aboutPower);
        }
        if(this.CAR.body !== undefined) {
          xForm.append('body', this.CAR.body);
        }
        if(this.CAR.color !== undefined) {
          xForm.append('color', this.CAR.color);
        }
        if(this.CAR.imagesServer !== undefined) {
          xForm.append('images', this.CAR.imagesServer);
        }

        return xForm;
      },

      setCarFromApi() {
        let postCarInformation = this.getFormDataAboutCar();
        this.SET_CAR_FROM_API(postCarInformation);
        this.$refs.myVueDropzone.removeAllFiles();
      },

      editCar() {
        let postCarInformation = {
          car: this.getFormDataAboutCar(),
          id: this.id
        };

        this.EDIT_CAR_FROM_API(postCarInformation);
      },

      modalCarPhotoFade() {
        this.showModal = !this.showModal;
      },

      sendingEvent(file) {
        this.showModal = false;
        this.SET_CAR_IMAGE_FROM_USER(file);
      },

      sendingDropzonePhoto() {
        this.$refs.myVueDropzone.processQueue();
      },
    },

    data() {
      return {
        id: this.$route.params.id,
        domain: DOMAIN,
        TABLE_HEADS,
        newCar: false,
        showModal: false,
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
@import "@/components/carsAdmin/style/car-index.scss"
@import "../../../node_modules/vue-multiselect/dist/vue-multiselect.min.css"
</style>