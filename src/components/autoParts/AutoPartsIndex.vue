<template>
  <div class="auto-parts-index">
    <BaseAlert
      v-if="errorValidate != ''"
      :error-validate="errorValidate"
      @closeAlertMessage="closeAlertMessage"
    />
    <Breadcrumb>
      <template #buttons>
        <router-link :to="{ name: 'autoParts' }" class="btn btn-primary">
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
                  id="status"
                  v-model="AUTO_PARTS_INDEX.status"
                  :options="STATUS"
                  placeholder="Статус"
                  class="auto-parts-index-field__select"
                />
              </AutoPartsIndexField>
              <AutoPartsIndexField
                v-for="(countAutoParts, i) in countAutoPartsAdd"
                :key="i"
                label="Марка и модель"
                required
                class="auto-parts-index-wrapp__field auto-parts-index-wrapp__auto-parts"
              >
                <BaseMultiselect
                  v-if="isCreatedPage"
                  :id="`autoPartsModelBrands` + i"
                  v-model="autoPartsModelBrands[i]"
                  :options="BREND_MODEL_CAR_AUTO_PARTS"
                  placeholder="Марка и модель"
                  custom-label="name"
                  class="auto-parts-index-field__select"
                />
                <BaseMultiselect
                  v-else
                  id="autoPartsModelBrands"
                  v-model="AUTO_PARTS_INDEX.autoPartsModelBrand"
                  :options="BREND_MODEL_CAR_AUTO_PARTS"
                  placeholder="Марка и модель"
                  custom-label="name"
                  class="auto-parts-index-field__select"
                />
                <template #additional>
                  <div class="auto-parts-index-field__controll">
                    <div
                      v-if="isAddAutoPartsMore(i)"
                      class="auto-parts-index-field__plus btn-primary btn"
                      @click="addAutoPartsMore"
                    >
                      <span class="bi bi-plus-circle"></span>
                    </div>
                    <div
                      v-if="isRemoveAutoPartsMore(i)"
                      class="auto-parts-index-field__plus btn-danger btn"
                      @click="removeAutoPartsMore"
                    >
                      <span class="bi bi-x-circle"></span>
                    </div>
                  </div>
                </template>
              </AutoPartsIndexField>
              <AutoPartsIndexField
                label="Год"
                class="auto-parts-index-wrapp__field"
                class-name="auto-parts-index-field__wrap--is-flex auto-parts-index-field__wrap--is-too"
                required
              >
                <BaseMultiselect
                  id="year"
                  v-model="AUTO_PARTS_INDEX.year"
                  :options="YEARS"
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
                class-name="auto-parts-index-field__wrap--is-flex auto-parts-index-field__wrap--is-three"
              >
                <input
                  v-model="AUTO_PARTS_INDEX.value"
                  type="text"
                  placeholder="Объём"
                  class="auto-parts-index-field__input"
                />
                <BaseMultiselect
                  id="fuel"
                  v-model="AUTO_PARTS_INDEX.fuel"
                  :options="FUELS"
                  placeholder="Топливо"
                  class="auto-parts-index-field__select"
                  @select="getFuelToTypeEngines"
                />
                <BaseMultiselect
                  id="typeEngines"
                  v-model="AUTO_PARTS_INDEX.typeEngines"
                  :options="typeEngines"
                  placeholder="Тип"
                  class="auto-parts-index-field__select"
                />
              </AutoPartsIndexField>
              <AutoPartsIndexField
                label="Тип кузова и коробка"
                class="auto-parts-index-wrapp__field"
                class-name="auto-parts-index-field__wrap--is-flex auto-parts-index-field__wrap--is-too"
              >
                <BaseMultiselect
                  id="typeBody"
                  v-model="AUTO_PARTS_INDEX.typeBody"
                  :options="BODYS"
                  placeholder="Тип кузова"
                  class="auto-parts-index-field__select"
                />
                <BaseMultiselect
                  id="transmission"
                  v-model="AUTO_PARTS_INDEX.transmission"
                  :options="TRANSMISSION"
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
                  id="autoPartsName"
                  v-model="AUTO_PARTS_INDEX.autoPartsName"
                  :options="TYPES_OF_AUTO_PARTS"
                  custom-label="name"
                  placeholder="Запчасть"
                  class="auto-parts-index-field__select"
                />
              </AutoPartsIndexField>
              <div v-if="dopFieldsForCastDiskDrive">
                <AutoPartsIndexField
                  v-for="(field, index) in FIELDS_FOR_CAST_DISK_DRIVE"
                  :key="index"
                  :label="field.label"
                  class="auto-parts-index-wrapp__field"
                >
                  <BaseMultiselect
                    v-if="field.id"
                    :id="field.id"
                    v-model="AUTO_PARTS_INDEX[field.vModel]"
                    :options="field.options"
                    :placeholder="field.label"
                    class="auto-parts-index-field__select"
                  />
                  <input
                    v-else
                    v-model="AUTO_PARTS_INDEX[field.vModel]"
                    type="text"
                    :placeholder="field.label"
                    class="auto-parts-index-field__input"
                  />
                </AutoPartsIndexField>
                <div
                  class="auto-parts-index-wrapp__field auto-parts-index-field"
                ></div>
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
                />
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
                />
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
                />
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
                />
              </AutoPartsIndexField>
              <AutoPartsIndexField
                label="Фото"
                class="auto-parts-index-wrapp__field"
                class-name="auto-parts-index-field-wrap"
              >
                <div
                  class="auto-parts-index-field-wrap__photos auto-parts-index-photo-list"
                >
                  <template v-if="AUTO_PARTS_INDEX.images">
                    <div
                      v-for="(image, index) in AUTO_PARTS_INDEX.images"
                      :key="index"
                      class="auto-parts-index-photo-list__item auto-parts-index-photo-item"
                    >
                      <img
                        :src="isImageUrlLocalOrServer(image)"
                        class="auto-parts-index-photo-item__image"
                      />
                      <div
                        class="auto-parts-index-photo-item__del"
                        @click="removeImgDop(index)"
                      >
                        Удалить
                      </div>
                      <div
                        class="auto-parts-index-photo-item__del"
                        :class="{
                          'auto-parts-index-photo-item__del--is-active':
                            mainPhotoSetAutoParts(image),
                        }"
                        @click="setThisPhotoOnMain(image)"
                      >
                        Главное фото
                      </div>
                    </div>
                  </template>
                </div>
                <button
                  class="auto-parts-index-field-wrap__btn btn btn-dark"
                  @click.prevent="modalCarPhotoFade"
                >
                  Добавить фото
                </button>
              </AutoPartsIndexField>
              <div
                class="auto-parts-index-wrapp__field auto-parts-index-field"
                @click="toggleDopFields"
              >
                <label
                  class="auto-parts-index-field__label cursor-pointer color-blue"
                >
                  Дополнительные поля - заметка (<span
                    v-html="!dopFields ? 'Показать' : 'Скрыть'"
                  ></span
                  >)
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
                  />
                </AutoPartsIndexField>
                <AutoPartsIndexField
                  label="Город"
                  class="auto-parts-index-wrapp__field"
                >
                  <input
                    v-model="AUTO_PARTS_INDEX.stock"
                    type="text"
                    placeholder="Город"
                    class="auto-parts-index-field__input"
                  />
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
                  />
                </AutoPartsIndexField>
                <AutoPartsIndexField
                  label="Заметка"
                  class="auto-parts-index-wrapp__field"
                >
                  <textarea
                    v-model="AUTO_PARTS_INDEX.theNote"
                    placeholder="Заметка"
                    class="auto-parts-index-field__textarea"
                  ></textarea>
                </AutoPartsIndexField>
              </div>
              <component
                :is="getAutoPartsIndexButtonsComponent"
                :qr-code="AUTO_PARTS_INDEX.qrCode"
                :link-to-site="AUTO_PARTS_INDEX.linkToSite"
                @editAutoParts="editAutoParts"
                @setAutoPartsFromApi="setAutoPartsFromApi"
              ></component>
            </div>
          </form>
        </div>
      </div>
    </div>
    <Modal v-show="showModal" @closeModalAdmin="modalCarPhotoFade">
      <template #header> Добавление фото </template>
      <template>
        <vue-dropzone
          id="dropzone"
          ref="myVueDropzone"
          :options="dropzoneOptions"
          @vdropzone-sending="sendingEvent"
        ></vue-dropzone>
        <button
          id="submit-all"
          class="btn btn-info"
          @click.prevent="sendingDropzonePhoto"
        >
          Загрузить изображения
        </button>
      </template>
    </Modal>
  </div>
</template>

<script>
import AutoPartsIndexField from '@/components/autoParts/AutoPartsIndexField';
import BaseMultiselect from '@/components/UI/BaseMultiselect';
import Breadcrumb from '@/components/UI/BaseBreadcrumb';
import { mapActions, mapGetters } from 'vuex';
import {
  DOMAIN,
  STATUS,
  YEARS,
  BODYS,
  TRANSMISSION,
  FUELS,
  TYPE_ENGINES_ALL,
  TYPE_ENGINES_DISEL,
  TYPE_ENGINES_BENZ,
} from '@/constants/constants';
import vue2Dropzone from 'vue2-dropzone';
import {
  FIELD_POST_TO_SEND,
  FIELDS_FOR_CAST_DISK_DRIVE,
} from '@/components/autoParts/constants/constants';
import { computed, unref, ref, defineAsyncComponent } from 'vue';
import { useRoute } from '@/composables/useRoute';
import { useStore } from '@/composables/useStore';

export default {
  name: 'AutoParstIndex',

  components: {
    Breadcrumb,
    vueDropzone: vue2Dropzone,
    BaseMultiselect,
    AutoPartsIndexField,
    BaseAlert: () => import('@/components/UI/BaseAlert'),
    Modal: () => import('@/components/UI/BaseModal'),
  },

  setup() {
    const AutoPartsIndexButtonsCreate = defineAsyncComponent(() =>
      import('@/components/autoParts/AutoPartsIndexButtonsCreate'),
    );
    const AutoPartsIndexButtonsEdit = defineAsyncComponent(() =>
      import('@/components/autoParts/AutoPartsIndexButtonsEdit'),
    );

    const route = useRoute();
    const store = useStore();
    const dopFieldsForCastDiskDrive = ref(false);
    const countAutoPartsAdd = ref(1);
    const errorValidate = ref('');
    const typeEngines = ref(TYPE_ENGINES_ALL);
    const showModal = ref(false);
    const dopFields = ref(false);

    const isCreatedPage = computed(() => route.name === 'autoPartsCreate');

    const getAutoPartsIndexButtonsComponent = computed(() =>
      unref(isCreatedPage)
        ? AutoPartsIndexButtonsCreate
        : AutoPartsIndexButtonsEdit,
    );

    // Methods
    const dopFieldsSearch = (select) => {
      dopFieldsForCastDiskDrive.value =
        select.code == 257 || select.code == 262;
    };
    const isAddAutoPartsMore = (i) =>
      unref(isCreatedPage) && i + 1 == unref(countAutoPartsAdd);

    const isRemoveAutoPartsMore = (i) =>
      unref(isCreatedPage) && i + 1 == unref(countAutoPartsAdd) && i != 0;

    const addAutoPartsMore = () => {
      countAutoPartsAdd.value++;
    };

    const removeAutoPartsMore = () => {
      countAutoPartsAdd.value--;
    };

    const closeAlertMessage = () => {
      errorValidate.value = '';
    };

    const getFuelToTypeEngines = (value) => {
      if (value === 'дизель') {
        typeEngines.value = TYPE_ENGINES_DISEL;
      } else if (value === 'бензин') {
        typeEngines.value = TYPE_ENGINES_BENZ;
      } else {
        typeEngines.value = TYPE_ENGINES_ALL;
      }
    };

    const modalCarPhotoFade = () => {
      showModal.value = !unref(showModal);
    };

    const createNameAutoPartsForBd = () => {
      const { autoPartsName, autoPartsModelBrand } = this.AUTO_PARTS_INDEX;
      const [brand, model] = autoPartsModelBrand.name
        .split(' >')
        .map((s) => s.trim());

      return `${autoPartsName.name} к ${brand} ${model} ${this.AUTO_PARTS_INDEX.year} г.`;
    };

    const toggleDopFields = () => {
      dopFields.value = !unref(dopFields);
    };

    const isImageUrlLocalOrServer = (image) =>
      image.substr(0, 4) === 'data' ? image : DOMAIN + `/image/` + image;

    const customLabelNameReturn = ({ name }) => name;

    const validateForm = () => {
      this.errorValidate = '';

      const validations = [
        {
          condition:
            !('autoPartsModelBrand' in this.AUTO_PARTS_INDEX) &&
            this.countAutoPartsAdd === 1 &&
            !this.isCreatedPage,
          message: 'Заполните поле запчасть!',
        },
        {
          condition:
            this.isCreatedPage &&
            this.autoPartsModelBrands[this.countAutoPartsAdd - 1] === undefined,
          message: 'Заполните поле запчасть!',
        },
        {
          condition: !('autoPartsName' in this.AUTO_PARTS_INDEX),
          message: 'Заполните марку и модель!',
        },
        {
          condition: !('year' in this.AUTO_PARTS_INDEX),
          message: 'Заполните поле год!',
        },
        {
          condition: !('priceUSD' in this.AUTO_PARTS_INDEX),
          message: 'Заполните поле цена!',
        },
      ];

      for (const { condition, message } of validations) {
        if (condition) {
          this.errorValidate = message;
          window.scrollTo(0, 0);
          break;
        }
      }
    };

    const sendingEvent = (file) => {
      showModal.value = false;
      store.dispatch('autoParts/SET_AUTO_PARTS_IMAGE_FROM_USER', file);
    };

    return {
      AutoPartsIndexButtonsCreate,
      AutoPartsIndexButtonsEdit,
      getAutoPartsIndexButtonsComponent,
      isCreatedPage,
      dopFieldsForCastDiskDrive,
      countAutoPartsAdd,
      errorValidate,
      typeEngines,
      showModal,
      dopFields,
      sendingEvent,
      validateForm,
      customLabelNameReturn,
      isImageUrlLocalOrServer,
      toggleDopFields,
      createNameAutoPartsForBd,
      modalCarPhotoFade,
      removeAutoPartsMore,
      getFuelToTypeEngines,
      closeAlertMessage,
      addAutoPartsMore,
      dopFieldsSearch,
      isAddAutoPartsMore,
      isRemoveAutoPartsMore,
    };
  },

  mounted() {
    this.resetAutoPartsForCreatePage();

    if (!this.isCreatedPage) {
      this.GET_AUTO_PARTS_INDEX(this.param);
    }

    this.GET_BREND_MODEL_CAR_AUTO_PARTS();
    this.GET_TYPES_OF_AUTO_PARTS();
  },

  computed: {
    ...mapGetters('autoParts', [
      'AUTO_PARTS_INDEX',
      'BREND_MODEL_CAR_AUTO_PARTS',
      'TYPES_OF_AUTO_PARTS',
    ]),

    autoPartsNameCode() {
      if ('autoPartsName' in this.AUTO_PARTS_INDEX) {
        return this.$store.state.autoParts.autoPartsIndex.autoPartsName;
      }
    },
  },

  watch: {
    $route() {
      this.resetAutoPartsForCreatePage();
    },

    autoPartsNameCode: {
      handler(newCode, oldCode) {
        if (newCode !== oldCode && 'autoPartsName' in this.AUTO_PARTS_INDEX) {
          this.dopFieldsSearch(newCode);
        }
      },
      deep: true,
    },
  },

  methods: {
    ...mapActions('autoParts', [
      'GET_AUTO_PARTS_INDEX',
      'GET_BREND_MODEL_CAR_AUTO_PARTS',
      'GET_TYPES_OF_AUTO_PARTS',
      'EDIT_AUTO_PARTS_FROM_API',
      'SET_AUTO_PARTS_IMAGE_FROM_USER',
      'SET_AUTO_PARTS_FROM_API',
      'RESET_AUTO_PARTS_FOR_CREATE_PAGE',
    ]),

    resetAutoPartsForCreatePage() {
      this.RESET_AUTO_PARTS_FOR_CREATE_PAGE();
      this.AUTO_PARTS_INDEX.status = 'Активно';
    },

    mainPhotoSetAutoParts(image) {
      return this.AUTO_PARTS_INDEX.mainImage == image;
    },

    setAutoPartsFromApi(redirect) {
      this.validateForm();

      if (!this.errorValidate) {
        let param = {
          redirect: redirect,
          fields: this.getFormDataAboutAutoParts(),
        };

        this.SET_AUTO_PARTS_FROM_API(param);
        this.$refs.myVueDropzone.removeAllFiles();
      }
    },

    editAutoParts(redirect) {
      this.validateForm();

      if (!this.errorValidate) {
        let postAutoPartsInformation = {
          autoParts: this.getFormDataAboutAutoParts(),
          id: this.param.id,
          redirect: redirect,
        };

        this.EDIT_AUTO_PARTS_FROM_API(postAutoPartsInformation);
      }
    },

    setThisPhotoOnMain(image) {
      this.AUTO_PARTS_INDEX.mainImage = image;
    },

    removeImgDop(index) {
      this.AUTO_PARTS_INDEX.images.splice(index, 1);
      this.AUTO_PARTS_INDEX.imagesServer.splice(index, 1);

      if (this.AUTO_PARTS_INDEX.images.length == 0) {
        this.AUTO_PARTS_INDEX.mainImage = '';
      }
    },

    sendingDropzonePhoto() {
      this.$refs.myVueDropzone.processQueue();
    },

    getFormDataAboutAutoParts() {
      let xForm = new FormData();

      for (let key in this.AUTO_PARTS_INDEX) {
        if (this.AUTO_PARTS_INDEX[key] !== undefined) {
          if (this.FIELD_POST_TO_SEND.includes(key)) {
            xForm.append(key, this.AUTO_PARTS_INDEX[key]);
          }
        }
      }

      if (this.AUTO_PARTS_INDEX.status !== undefined) {
        let status = this.AUTO_PARTS_INDEX.status == 'Активно' ? '1' : '0';
        xForm.append('status', status);
      }

      if (this.AUTO_PARTS_INDEX.autoPartsName !== undefined) {
        xForm.append('autoPartsName', this.AUTO_PARTS_INDEX.autoPartsName.code);
      }

      if ('autoPartsModelBrand' in this.AUTO_PARTS_INDEX) {
        xForm.append(
          'autoPartsCategoryId',
          this.AUTO_PARTS_INDEX.autoPartsModelBrand.code,
        );
      }

      if (
        this.AUTO_PARTS_INDEX.autoPartsName.code !== undefined &&
        this.countAutoPartsAdd == 1 &&
        !this.isCreatedPage
      ) {
        xForm.append(
          'autoPartsManufacturerId',
          this.AUTO_PARTS_INDEX.autoPartsName.code,
        );
        xForm.append('autoPartsNameForBd', this.createNameAutoPartsForBd());
      }

      if (
        this.AUTO_PARTS_INDEX.autoPartsName.code !== undefined &&
        this.countAutoPartsAdd == 1 &&
        this.isCreatedPage
      ) {
        xForm.append(
          'autoPartsManufacturerId',
          this.AUTO_PARTS_INDEX.autoPartsName.code,
        );

        for (let i = 1; this.autoPartsModelBrands.length >= i; i++) {
          xForm.append(
            'autoPartsNameForBd[]',
            this.AUTO_PARTS_INDEX.autoPartsName.name +
              ' к ' +
              this.autoPartsModelBrands[i - 1].name.split(' >')[0] +
              ' ' +
              this.autoPartsModelBrands[i - 1].name.split('> ')[1] +
              ' ' +
              this.AUTO_PARTS_INDEX.year +
              ' г.',
          );
        }
      }

      if (
        this.AUTO_PARTS_INDEX.autoPartsName.code !== undefined &&
        this.countAutoPartsAdd > 1 &&
        this.isCreatedPage
      ) {
        xForm.append(
          'autoPartsManufacturerId',
          this.AUTO_PARTS_INDEX.autoPartsName.code,
        );

        for (let i = 1; this.autoPartsModelBrands.length >= i; i++) {
          xForm.append(
            'autoPartsNameForBd[]',
            this.AUTO_PARTS_INDEX.autoPartsName.name +
              ' к ' +
              this.autoPartsModelBrands[i - 1].name.split(' >')[0] +
              ' ' +
              this.autoPartsModelBrands[i - 1].name.split('> ')[1] +
              ' ' +
              this.AUTO_PARTS_INDEX.year +
              ' г.',
          );
        }
      }

      if (
        this.autoPartsModelBrands.length != 0 &&
        this.isCreatedPage &&
        this.countAutoPartsAdd > 1
      ) {
        for (let i = 1; this.autoPartsModelBrands.length >= i; i++) {
          xForm.append(
            'autoPartsModelBrandsObject[]',
            this.autoPartsModelBrands[i - 1].code,
          );
        }
      }

      if (this.isCreatedPage && this.countAutoPartsAdd == 1) {
        xForm.append('autoPartsCategoryId', this.autoPartsModelBrands[0].code);
      }

      if (this.AUTO_PARTS_INDEX.imagesServer !== undefined) {
        xForm.append('images', this.AUTO_PARTS_INDEX.imagesServer);
      }

      xForm.append('user_id', JSON.parse(localStorage.user).user_id);

      if (this.AUTO_PARTS_INDEX.mainImage !== undefined) {
        xForm.append('imagesMain', this.AUTO_PARTS_INDEX.mainImage);
      } else if (this.AUTO_PARTS_INDEX.imagesServer !== undefined) {
        xForm.append('imagesMain', this.AUTO_PARTS_INDEX.imagesServer[0]);
      }

      return xForm;
    },
  },

  data() {
    return {
      param: {
        id: this.$route.params.id,
      },
      autoPartsModelBrands: [],
      domain: DOMAIN,
      FIELD_POST_TO_SEND,
      STATUS,
      YEARS,
      BODYS,
      TRANSMISSION,
      FUELS,
      FIELDS_FOR_CAST_DISK_DRIVE,
      dropzoneOptions: {
        url: '/v1/upload.php',
        thumbnailWidth: 150,
        thumbnailHeight: 150,
        maxFilesize: 2500,
        autoProcessQueue: false,
        dictDefaultMessage:
          'Нажмите сюда или перетащите сюда файлы для загрузки <div><span style="color: darkgrey; margin-bottom: 5px">* для выбора нескольких фото, удерживайте клавишу Ctrl</span><br/></div><br/>',
        dictRemoveFile: 'удалить',
        dictCancelUpload: 'отменить',
        parallelUploads: 20,
        maxThumbnailFilesize: 200,
        resizeWidth: 800,
        timeout: 180000000,
        acceptedFiles: '.png,.jpg,.gif,.bmp,.jpeg',
        renameFile: function (file) {
          let newName = new Date().getTime() + '_' + file.name;
          return newName;
        },
      },
    };
  },
};
</script>

<style scoped lang="sass">
@import "vue2-dropzone/dist/vue2Dropzone.min.css"
@import "../../../node_modules/vue-multiselect/dist/vue-multiselect.min.css"
@import "@/components/autoParts/style/auto-parts-index.scss"
</style>
