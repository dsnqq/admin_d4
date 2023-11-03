<template>
  <div class="auto-parts-index">
    <BaseAlert
        v-if="errorValidate != ''"
        :errorValidate="errorValidate"
        @closeAlertMessage="closeAlertMessage"
    />
    <Breadcrumb>
      <template v-slot:buttons>
        <router-link
            :to="{name: 'autoParts'}"
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
            <div class="auto-parts-index__wrapp auto-parts-index-wrapp">
              <AutoPartsIndexField
                  label="Статус"
                  class="auto-parts-index-wrapp__field"
              >
                <BaseMultiselect
                    v-model="AUTO_PARTS_INDEX.status"
                    :options="STATUS"
                    id="status"
                    placeholder="Статус"
                    class="auto-parts-index-field__select"
                />
              </AutoPartsIndexField>
              <div class="auto-parts-index-wrapp__auto-parts">
                <AutoPartsIndexField
                    v-for="(countAutoParts, i) in countAutoPartsAdd"
                    :key="i"
                    label="Марка и модель"
                    class="auto-parts-index-wrapp__field"
                >
                  <BaseMultiselect
                      v-if="isCreatedPage"
                      v-model="autoPartsModelBrands[i]"
                      :options="BREND_MODEL_CAR_AUTO_PARTS"
                      placeholder="Марка и модель"
                      customLabel="name"
                      :id="`autoPartsModelBrands` + i"
                      class="auto-parts-index-field__select"
                  />
                  <BaseMultiselect
                      v-else
                      v-model="AUTO_PARTS_INDEX.autoPartsModelBrand"
                      :options="BREND_MODEL_CAR_AUTO_PARTS"
                      placeholder="Марка и модель"
                      customLabel="name"
                      id="autoPartsModelBrands"
                      class="auto-parts-index-field__select"
                  />
                  <template v-slot:additional>
                    <div class="auto-parts-index-field__controll">
                      <div
                          v-if="isAddAutoPartsMore(i)"
                          @click="addAutoPartsMore"
                          class="auto-parts-index-field__plus btn-primary btn"
                      >
                        <span class="bi bi-plus-circle"></span>
                      </div>
                      <div
                          v-if="isRemoveAutoPartsMore(i)"
                          @click="removeAutoPartsMore"
                          class="auto-parts-index-field__plus btn-danger btn"
                      >
                        <span class="bi bi-x-circle"></span>
                      </div>
                    </div>
                  </template>
                </AutoPartsIndexField>
              </div>
              <AutoPartsIndexField
                  label="Год"
                  class="auto-parts-index-wrapp__field"
                  className="auto-parts-index-field__wrap--is-flex auto-parts-index-field__wrap--is-too"
                  required
              >
                <BaseMultiselect
                    v-model="AUTO_PARTS_INDEX.year"
                    :options="YEARS"
                    id="year"
                    placeholder="Год"
                    class="auto-parts-index-field__select"
                />
                <input
                    v-model="AUTO_PARTS_INDEX.modification"
                    type="text"
                    placeholder="Модификация"
                    class="auto-parts-index-field__input"
                />
              </AutoPartsIndexField>
              <AutoPartsIndexField
                  label="Объем (л), топливо и тип"
                  class="auto-parts-index-wrapp__field"
                  className="auto-parts-index-field__wrap--is-flex auto-parts-index-field__wrap--is-three"
              >
                <input
                    v-model="AUTO_PARTS_INDEX.value"
                    type="text"
                    placeholder="Объём"
                    class="auto-parts-index-field__input"
                />
                <BaseMultiselect
                    v-model="AUTO_PARTS_INDEX.fuel"
                    :options="FUELS"
                    @select="getFuelToTypeEngines"
                    placeholder="Топливо"
                    id="fuel"
                    class="auto-parts-index-field__select"
                />
                <BaseMultiselect
                    v-model="AUTO_PARTS_INDEX.typeEngines"
                    :options="this.typeEngines"
                    id="typeEngines"
                    placeholder="Тип"
                    class="auto-parts-index-field__select"
                />
              </AutoPartsIndexField>
              <AutoPartsIndexField
                  label="Тип кузова и коробка"
                  class="auto-parts-index-wrapp__field"
                  className="auto-parts-index-field__wrap--is-flex auto-parts-index-field__wrap--is-too"
              >
                <BaseMultiselect
                    v-model="AUTO_PARTS_INDEX.typeBody"
                    :options="BODYS"
                    id="typeBody"
                    placeholder="Тип кузова"
                    class="auto-parts-index-field__select"
                />
                <BaseMultiselect
                    v-model="AUTO_PARTS_INDEX.transmission"
                    :options="TRANSMISSION"
                    id="transmission"
                    placeholder="Коробка"
                    class="auto-parts-index-field__select"
                />
              </AutoPartsIndexField>
              <AutoPartsIndexField
                  label="Запчасть"
                  class="auto-parts-index-wrapp__field"
                  required
              >
                <BaseMultiselect
                    v-model="AUTO_PARTS_INDEX.autoPartsName"
                    :options="TYPES_OF_AUTO_PARTS"
                    customLabel="name"
                    id="autoPartsName"
                    placeholder="Запчасть"
                    class="auto-parts-index-field__select"
                />
              </AutoPartsIndexField>
              <div
                  v-if="dopFieldsForCastDiskDrive"
              >
                <AutoPartsIndexField
                    label="Диаметр R, дюймы"
                    class="auto-parts-index-wrapp__field"
                >
                  <BaseMultiselect
                      v-model="AUTO_PARTS_INDEX.wheelDiameterR"
                      :options="WHEEL_DIAMETER_R"
                      id="wheelDiameterR"
                      placeholder="Диаметр R, дюймы"
                      class="auto-parts-index-field__select"
                  />
                </AutoPartsIndexField>
                <AutoPartsIndexField
                    label="Ширина J, дюймы"
                    class="auto-parts-index-wrapp__field"
                >
                  <BaseMultiselect
                      v-model="AUTO_PARTS_INDEX.wheelWidthJ"
                      :options="WHEEL_WIDTH_J"
                      id="wheelWidthJ"
                      placeholder="Ширина J, дюймы"
                      class="auto-parts-index-field__select"
                  />
                </AutoPartsIndexField>
                <AutoPartsIndexField
                    label="Кол-во отверстий"
                    class="auto-parts-index-wrapp__field"
                >
                  <BaseMultiselect
                      v-model="AUTO_PARTS_INDEX.numberOfHoles"
                      :options="NUMBER_OF_HOLES"
                      id="numberOfHoles"
                      placeholder="Кол-во отверстий"
                      class="auto-parts-index-field__select"
                  />
                </AutoPartsIndexField>
                <AutoPartsIndexField
                    label="Расстояние между отверстиями PCD, мм"
                    class="auto-parts-index-wrapp__field"
                >
                  <BaseMultiselect
                      v-model="AUTO_PARTS_INDEX.pcd"
                      :options="PCD"
                      id="pcd"
                      placeholder="Расстояние PCD"
                      class="auto-parts-index-field__select"
                  />
                </AutoPartsIndexField>
                <AutoPartsIndexField
                    label="Вылет ET, мм"
                    class="auto-parts-index-wrapp__field"
                >
                  <input
                      v-model="AUTO_PARTS_INDEX.departureE"
                      type="text"
                      placeholder="Вылет ET, мм"
                      class="auto-parts-index-field__input"
                  >
                </AutoPartsIndexField>
                <AutoPartsIndexField
                    label="Диаметр центрального отверстия DIA, мм"
                    class="auto-parts-index-wrapp__field"
                >
                  <BaseMultiselect
                      v-model="AUTO_PARTS_INDEX.diameter"
                      :options="DIAMETER"
                      id="diameter"
                      placeholder="Диаметр, DIA"
                      class="auto-parts-index-field__select"
                  />
                </AutoPartsIndexField>
                <div class="auto-parts-index-wrapp__field auto-parts-index-field"></div>
              </div>
              <AutoPartsIndexField
                  label="Описание"
                  class="auto-parts-index-wrapp__field"
              >
                  <textarea
                      v-model="AUTO_PARTS_INDEX.description"
                      placeholder="Описание"
                      class="auto-parts-index-field__textarea"
                  ></textarea>
              </AutoPartsIndexField>
              <AutoPartsIndexField
                  label="Артикул (автоматически)"
                  class="auto-parts-index-wrapp__field"
              >
                <input
                    v-model="AUTO_PARTS_INDEX.model"
                    type="text"
                    placeholder="Артикул"
                    class="auto-parts-index-field__input"
                >
              </AutoPartsIndexField>
              <AutoPartsIndexField
                  label="Номер запчасти"
                  class="auto-parts-index-wrapp__field"
              >
                <input
                    v-model="AUTO_PARTS_INDEX.sparePartNumber"
                    type="text"
                    placeholder="Номер запчасти"
                    class="auto-parts-index-field__input"
                >
              </AutoPartsIndexField>
              <AutoPartsIndexField
                  label="Цена в долларах"
                  class="auto-parts-index-wrapp__field"
                  required
              >
                <input
                    v-model="AUTO_PARTS_INDEX.priceUSD"
                    type="number"
                    placeholder="Цена"
                    class="auto-parts-index-field__input"
                >
              </AutoPartsIndexField>
              <AutoPartsIndexField
                  label="Код видео с youtube.com"
                  class="auto-parts-index-wrapp__field"
              >
                <input
                    v-model="AUTO_PARTS_INDEX.youtube"
                    type="text"
                    placeholder="Видео"
                    class="auto-parts-index-field__input"
                >
              </AutoPartsIndexField>
              <div
                  @click="toggleDopFields"
                  class="auto-parts-index-wrapp__field auto-parts-index-field"
                >
                <label class="auto-parts-index-field__label cursor-pointer color-blue">
                  Дополнительные поля (<span v-html="!dopFields ? 'Показать' : 'Скрыть'"></span>)
                </label>
              </div>
              <div v-show="dopFields">
                <AutoPartsIndexField
                    label="Имя для связи"
                    class="auto-parts-index-wrapp__field"
                >
                  <input
                      v-model="AUTO_PARTS_INDEX.firstname"
                      type="text"
                      placeholder="Имя для связи"
                      class="auto-parts-index-field__input"
                  >
                </AutoPartsIndexField>
                <AutoPartsIndexField
                    label="Складская информация"
                    class="auto-parts-index-wrapp__field"
                >
                  <input
                      v-model="AUTO_PARTS_INDEX.stock"
                      type="text"
                      placeholder="Складская информация"
                      class="auto-parts-index-field__input"
                  >
                </AutoPartsIndexField>
                <AutoPartsIndexField
                    label="Телефон, если другой"
                    class="auto-parts-index-wrapp__field"
                >
                  <input
                      v-model="AUTO_PARTS_INDEX.telephone"
                      type="text"
                      placeholder="Телефон, если другой"
                      class="auto-parts-index-field__input"
                  >
                </AutoPartsIndexField>
              </div>
              <AutoPartsIndexField
                  label="Фото"
                  class="auto-parts-index-wrapp__field"
                  className="auto-parts-index-field-wrap"
              >
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
                    class="auto-parts-index-field-wrap__btn btn btn-dark"
                >
                  Добавить фото
                </button>
              </AutoPartsIndexField>
              <component
                  :is="getAutoPartsIndexButtonsComponent"
                  :qrCode="AUTO_PARTS_INDEX.qrCode"
                  :linkToSite="AUTO_PARTS_INDEX.linkToSite"
                  @editAutoParts="editAutoParts"
                  @setAutoPartsFromApi="setAutoPartsFromApi"
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
  import AutoPartsIndexField from "@/components/autoParts/AutoPartsIndexField.vue";
  import BaseMultiselect from "@/components/UI/BaseMultiselect.vue";
  import Breadcrumb from "@/components/UI/BaseBreadcrumb.vue";
  import {mapActions, mapGetters} from "vuex";
  import {DOMAIN, STATUS, YEARS, BODYS, TRANSMISSION, FUELS, TYPE_ENGINES_ALL, TYPE_ENGINES_DISEL, TYPE_ENGINES_BENZ, WHEEL_DIAMETER_R, WHEEL_WIDTH_J, NUMBER_OF_HOLES, PCD, DIAMETER} from "@/constants/constants";
  import vue2Dropzone from 'vue2-dropzone';
  import {FIELD_POST_TO_SEND} from "@/components/autoParts/constants/constants";

  export default {
    name: "AutoParstIndex",

    components: {
      Breadcrumb,
      vueDropzone: vue2Dropzone,
      BaseMultiselect,
      AutoPartsIndexField,
      BaseAlert: () => import("@/components/UI/BaseAlert.vue"),
      Modal: () => import("@/components/UI/BaseModal.vue"),
      AutoPartsIndexButtonsCreate: () => import("@/components/autoParts/AutoPartsIndexButtonsCreate.vue"),
      AutoPartsIndexButtonsEdit: () => import("@/components/autoParts/AutoPartsIndexButtonsEdit.vue")
    },

    mounted() {
      this.resetAutoPartsForCreatePage();

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

      getAutoPartsIndexButtonsComponent() {
        return (!this.isCreatedPage) ? 'AutoPartsIndexButtonsEdit' : 'AutoPartsIndexButtonsCreate';
      },

      isCreatedPage() {
        return this.$route.name === "autoPartsCreate";
      },

      autoPartsNameCode() {
        if("autoPartsName" in this.AUTO_PARTS_INDEX) {
          return this.$store.state.autoParts.autoPartsIndex.autoPartsName;
        }
      }
    },

    watch: {
      '$route' () {
        this.resetAutoPartsForCreatePage();
      },

      autoPartsNameCode: {
        handler(newCode, oldCode) {
          if((newCode !== oldCode) && ("autoPartsName" in this.AUTO_PARTS_INDEX)) {
            this.dopFieldsSearch(newCode);
          }
        },
        deep: true
      }
    },

    methods: {
      ...mapActions('autoParts', [
        'GET_AUTO_PARTS_INDEX',
        'GET_BREND_MODEL_CAR_AUTO_PARTS',
        'GET_TYPES_OF_AUTO_PARTS',
        'EDIT_AUTO_PARTS_FROM_API',
        'SET_AUTO_PARTS_IMAGE_FROM_USER',
        'SET_AUTO_PARTS_FROM_API',
        'RESET_AUTO_PARTS_FOR_CREATE_PAGE'
      ]),

      resetAutoPartsForCreatePage() {
        this.RESET_AUTO_PARTS_FOR_CREATE_PAGE();
        this.AUTO_PARTS_INDEX.status = "Активно";
      },

      dopFieldsSearch(select) {
        this.dopFieldsForCastDiskDrive = (select.code == 257 || select.code == 262);
      },

      createNameAutoPartsForBd() {
          return this.AUTO_PARTS_INDEX.autoPartsName.name + " к " + this.AUTO_PARTS_INDEX.autoPartsModelBrand.name.split(' >')[0] + " " + this.AUTO_PARTS_INDEX.autoPartsModelBrand.name.split('> ')[1] + " " + this.AUTO_PARTS_INDEX.year + " г.";
      },

      isAddAutoPartsMore(i) {
        return this.isCreatedPage && (i + 1 == this.countAutoPartsAdd);
      },

      isRemoveAutoPartsMore(i) {
        return this.isCreatedPage && (i + 1 == this.countAutoPartsAdd) && i != 0;
      },

      mainPhotoSetAutoParts(image){
        return this.AUTO_PARTS_INDEX.mainImage == image;
      },

      validateForm() {
        this.errorValidate = "";

        if(!("autoPartsModelBrand" in this.AUTO_PARTS_INDEX) && this.countAutoPartsAdd == 1 && !this.isCreatedPage){
          this.errorValidate = "Заполните поле запчасть!";
        }

        if(this.isCreatedPage && this.autoPartsModelBrands[this.countAutoPartsAdd-1] == undefined){
          this.errorValidate = "Заполните поле запчасть!";
        }

        if(!("autoPartsName" in this.AUTO_PARTS_INDEX)){
          this.errorValidate = "Заполните марку и модель!";
        }

        if(!("year" in this.AUTO_PARTS_INDEX)){
          this.errorValidate = "Заполните поле год!";
        }

        if(!("priceUSD" in this.AUTO_PARTS_INDEX)){
          this.errorValidate = "Заполните поле цена!";
        }

        if(this.errorValidate) {
          window.scrollTo(0, 0);
        }
      },

      setAutoPartsFromApi(redirect) {
        this.validateForm();

        if(!this.errorValidate) {
          let param = {
            redirect: redirect,
            fields: this.getFormDataAboutAutoParts()
          }

          this.SET_AUTO_PARTS_FROM_API(param);
          this.$refs.myVueDropzone.removeAllFiles();
        }
      },

      editAutoParts(redirect) {
        this.validateForm();

        if(!this.errorValidate) {
          let postAutoPartsInformation = {
            autoParts: this.getFormDataAboutAutoParts(),
            id: this.param.id,
            redirect: redirect
          };

          this.EDIT_AUTO_PARTS_FROM_API(postAutoPartsInformation);
        }
      },

      setThisPhotoOnMain(image) {
        this.AUTO_PARTS_INDEX.mainImage = image;
      },

      toggleDopFields() {
        this.dopFields = !this.dopFields;
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

      getFormDataAboutAutoParts() {
        let xForm = new FormData();

        for (let key in this.AUTO_PARTS_INDEX) {
          if(this.AUTO_PARTS_INDEX[key] !== undefined) {
            if(this.FIELD_POST_TO_SEND.includes(key)) {
              xForm.append(key, this.AUTO_PARTS_INDEX[key]);
            }
          }
        }

        if(this.AUTO_PARTS_INDEX.status !== undefined){
          let status = (this.AUTO_PARTS_INDEX.status == 'Активно') ? '1' : '0';
          xForm.append('status', status);
        }

        if(this.AUTO_PARTS_INDEX.autoPartsName !== undefined){
          xForm.append('autoPartsName', this.AUTO_PARTS_INDEX.autoPartsName.code);
        }

        if("autoPartsModelBrand" in this.AUTO_PARTS_INDEX) {
          xForm.append('autoPartsCategoryId', this.AUTO_PARTS_INDEX.autoPartsModelBrand.code);
        }

        if(this.AUTO_PARTS_INDEX.autoPartsName.code !== undefined && this.countAutoPartsAdd == 1 && !this.isCreatedPage){
          xForm.append('autoPartsManufacturerId', this.AUTO_PARTS_INDEX.autoPartsName.code);
          xForm.append('autoPartsNameForBd', this.createNameAutoPartsForBd());
        }

        if(this.AUTO_PARTS_INDEX.autoPartsName.code !== undefined && this.countAutoPartsAdd == 1 && this.isCreatedPage){
          xForm.append('autoPartsManufacturerId', this.AUTO_PARTS_INDEX.autoPartsName.code);

          for(let i = 1;this.autoPartsModelBrands.length >= i ;i++) {
            xForm.append('autoPartsNameForBd[]', this.AUTO_PARTS_INDEX.autoPartsName.name + " к " + this.autoPartsModelBrands[i-1].name.split(' >')[0] + " " + this.autoPartsModelBrands[i-1].name.split('> ')[1] + " " + this.AUTO_PARTS_INDEX.year + " г.");
          }
        }

        if(this.AUTO_PARTS_INDEX.autoPartsName.code !== undefined && this.countAutoPartsAdd > 1 && this.isCreatedPage){
          xForm.append('autoPartsManufacturerId', this.AUTO_PARTS_INDEX.autoPartsName.code);

          for(let i = 1;this.autoPartsModelBrands.length >= i ;i++) {
            xForm.append('autoPartsNameForBd[]', this.AUTO_PARTS_INDEX.autoPartsName.name + " к " + this.autoPartsModelBrands[i-1].name.split(' >')[0] + " " + this.autoPartsModelBrands[i-1].name.split('> ')[1] + " " + this.AUTO_PARTS_INDEX.year + " г.");
          }
        }

        if(this.autoPartsModelBrands.length != 0 && this.isCreatedPage){
          for(let i = 1;this.autoPartsModelBrands.length >= i ;i++) {
            xForm.append('autoPartsModelBrandsObject[]', this.autoPartsModelBrands[i-1].code);
          }
        }

        if(this.AUTO_PARTS_INDEX.imagesServer !== undefined) {
          xForm.append('images', this.AUTO_PARTS_INDEX.imagesServer);
        }

        xForm.append('user_id', JSON.parse(localStorage.user).user_id);

        if(this.AUTO_PARTS_INDEX.mainImage !== undefined) {
          xForm.append('imagesMain', this.AUTO_PARTS_INDEX.mainImage);
        } else if(this.AUTO_PARTS_INDEX.imagesServer !== undefined) {
          xForm.append('imagesMain', this.AUTO_PARTS_INDEX.imagesServer[0]);
        }

        return xForm;
      },

      sendingEvent(file) {
        this.showModal = false;
        this.SET_AUTO_PARTS_IMAGE_FROM_USER(file);
      },

      customLabelNameReturn({ name }) {
        return name;
      },

      closeAlertMessage() {
        this.errorValidate = "";
      },

      getFuelToTypeEngines(value) {
        if(value == 'дизель') {
          this.typeEngines = TYPE_ENGINES_DISEL;
        } else if(value == 'бензин') {
          this.typeEngines = TYPE_ENGINES_BENZ;
        } else {
          this.typeEngines = TYPE_ENGINES_ALL;
        }
      },

      addAutoPartsMore() {
        this.countAutoPartsAdd++;
      },

      removeAutoPartsMore() {
        this.countAutoPartsAdd--;
      }
    },

    data() {
      return {
        dopFieldsForCastDiskDrive: false,
        errorValidate: "",
        dopFields: false,
        param: {
          id: this.$route.params.id
        },
        showModal: false,
        countAutoPartsAdd: 1,
        autoPartsModelBrands: [],
        domain: DOMAIN,
        FIELD_POST_TO_SEND,
        STATUS,
        YEARS,
        BODYS,
        TRANSMISSION,
        FUELS,
        WHEEL_DIAMETER_R,
        WHEEL_WIDTH_J,
        NUMBER_OF_HOLES,
        PCD,
        DIAMETER,
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
@import "@/components/autoParts/style/auto-parts-index.scss"
</style>
