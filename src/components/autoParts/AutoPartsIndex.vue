<template>
  <div class="auto-parts-index">
    <div
        v-if="errorValidate != ''"
        class="alert border-0 bg-light-danger alert-dismissible fade show py-2"
    >
      <div class="d-flex align-items-center">
        <div class="fs-3 text-danger"><i class="bi bi-x-circle-fill"></i>
        </div>
        <div class="ms-3">
          <div class="text-danger">
            {{errorValidate}}
          </div>
        </div>
      </div>
      <button
          @click.prevent="closeAlertMessage"
          type="button"
          class="btn-close"
          data-bs-dismiss="alert"
          aria-label="Close">
      </button>
    </div>
    <Breadcrumb>
      <template v-slot:buttons>
        <router-link
            :to="{name: 'autoParts'}"
            class="btn btn-primary"
        >
          Вернуться назад
        </router-link>
      </template>
    </Breadcrumb>
    <div class="card">
      <div class="card-body">
        <div class="row">
          <form>
            <div class="auto-parts-index__wrapp auto-parts-index-wrapp">
              <div class="auto-parts-index-wrapp__field auto-parts-index-field">
                <label class="auto-parts-index-field__label">
                  Статус:
                </label>
                <div class="auto-parts-index-field__wrap">
                  <BaseMultiselect
                      v-model="AUTO_PARTS_INDEX.status"
                      :options="STATUS"
                      id="status"
                      class="auto-parts-index-field__select"
                  />
                </div>
              </div>
              <div class="auto-parts-index-wrapp__auto-parts">
                <div
                    v-for="(countAutoParts, i) in countAutoPartsAdd"
                    :key="i"
                    class="auto-parts-index-wrapp__field auto-parts-index-field"
                >
                  <label class="auto-parts-index-field__label auto-parts-index-field__label--is-required">
                    Марка и модель:
                  </label>
                  <div class="auto-parts-index-field__wrap">
                    <BaseMultiselect
                        v-if="isCreatedPage"
                        v-model="autoPartsModelBrands[i]"
                        :options="BREND_MODEL_CAR_AUTO_PARTS"
                        customLabel="name"
                        id="autoPartsModelBrands"
                        class="auto-parts-index-field__select"
                    />
                    <BaseMultiselect
                        v-else
                        v-model="AUTO_PARTS_INDEX.autoPartsModelBrand"
                        :options="BREND_MODEL_CAR_AUTO_PARTS"
                        customLabel="name"
                        id="autoPartsModelBrands"
                        class="auto-parts-index-field__select"
                    />
                  </div>
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
                  <BaseMultiselect
                      v-model="AUTO_PARTS_INDEX.typeBody"
                      :options="BODYS"
                      id="typeBody"
                      class="auto-parts-index-field__select"
                  />
                  <BaseMultiselect
                      v-model="AUTO_PARTS_INDEX.transmission"
                      :options="TRANSMISSION"
                      id="transmission"
                      class="auto-parts-index-field__select"
                  />
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
                      :custom-label="customLabelNameReturn"
                      :selectedLabel="`Выбрано`"
                      :deselectLabel="`Клик, чтобы удалить`"
                      :selectLabel="`Клик, чтобы выбрать`"
                      :placeholder="`Запчасть`"
                      class="auto-parts-index-field__select"
                      @select="dopFieldsSearch"
                  >
                    <template v-slot:noResult>
                      Пусто...
                    </template>
                  </v-multiselect>
                </div>
              </div>
              <div
                  v-if="dopFieldsForCastDiskDrive"
              >
                <div class="auto-parts-index-wrapp__field auto-parts-index-field">
                  <label class="auto-parts-index-field__label">
                    Диаметр R, дюймы:
                  </label>
                  <div class="auto-parts-index-field__wrap">
                    <BaseMultiselect
                        v-model="AUTO_PARTS_INDEX.wheelDiameterR"
                        :options="WHEEL_DIAMETER_R"
                        id="wheelDiameterR"
                        class="auto-parts-index-field__select"
                    />
                  </div>
                </div>
                <div class="auto-parts-index-wrapp__field auto-parts-index-field">
                  <label class="auto-parts-index-field__label">
                    Ширина J, дюймы:
                  </label>
                  <div class="auto-parts-index-field__wrap">
                    <BaseMultiselect
                        v-model="AUTO_PARTS_INDEX.wheelWidthJ"
                        :options="WHEEL_WIDTH_J"
                        id="wheelWidthJ"
                        class="auto-parts-index-field__select"
                    />
                  </div>
                </div>
                <div class="auto-parts-index-wrapp__field auto-parts-index-field">
                  <label class="auto-parts-index-field__label">
                    Кол-во отверстий:
                  </label>
                  <div class="auto-parts-index-field__wrap">
                    <BaseMultiselect
                        v-model="AUTO_PARTS_INDEX.numberOfHoles"
                        :options="NUMBER_OF_HOLES"
                        id="numberOfHoles"
                        class="auto-parts-index-field__select"
                    />
                  </div>
                </div>
                <div class="auto-parts-index-wrapp__field auto-parts-index-field">
                  <label class="auto-parts-index-field__label">
                    Расстояние между<br>отверстиями PCD, мм:
                  </label>
                  <div class="auto-parts-index-field__wrap">
                    <BaseMultiselect
                        v-model="AUTO_PARTS_INDEX.pcd"
                        :options="PCD"
                        id="pcd"
                        class="auto-parts-index-field__select"
                    />
                  </div>
                </div>
                <AutoPartsIndexField
                    v-model="AUTO_PARTS_INDEX.departureE"
                    title="Вылет ET, мм"
                    placeholder="Вылет ET, мм"
                    class="auto-parts-index-wrapp__field"
                />
                <div class="auto-parts-index-wrapp__field auto-parts-index-field">
                  <label class="auto-parts-index-field__label">
                    Диаметр центрального<br>отверстия DIA, мм:
                  </label>
                  <div class="auto-parts-index-field__wrap">
                    <BaseMultiselect
                        v-model="AUTO_PARTS_INDEX.diameter"
                        :options="DIAMETER"
                        id="diameter"
                        class="auto-parts-index-field__select"
                    />
                  </div>
                </div>
                <div class="auto-parts-index-wrapp__field auto-parts-index-field"></div>
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
              <AutoPartsIndexField
                  v-model="AUTO_PARTS_INDEX.model"
                  title="Артикул (ext_id автоматически)"
                  placeholder="Артикул"
                  class="auto-parts-index-wrapp__field"
              />
              <AutoPartsIndexField
                  v-model="AUTO_PARTS_INDEX.sparePartNumber"
                  title="Номер запчасти"
                  class="auto-parts-index-wrapp__field"
              />
              <AutoPartsIndexField
                  v-model="AUTO_PARTS_INDEX.priceUSD"
                  title="Цена в долларах"
                  required
                  class="auto-parts-index-wrapp__field"
              />
              <AutoPartsIndexField
                  v-model="AUTO_PARTS_INDEX.youtube"
                  title="Код видео с youtube.com"
                  placeholder="Видео"
                  class="auto-parts-index-wrapp__field"
              />
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
                    v-model="AUTO_PARTS_INDEX.firstname"
                    title="Имя для связи"
                    class="auto-parts-index-wrapp__field"
                />
                <AutoPartsIndexField
                    v-model="AUTO_PARTS_INDEX.stock"
                    title="Складская информация"
                    class="auto-parts-index-wrapp__field"
                />
                <AutoPartsIndexField
                    v-model="AUTO_PARTS_INDEX.telephone"
                    title="Телефон, если другой"
                    class="auto-parts-index-wrapp__field"
                />
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
                      class="auto-parts-index-field-wrap__btn btn btn-dark"
                  >
                    Добавить фото
                  </button>
                </div>
              </div>
                <AutoPartsIndexButtonsEdit
                   v-if="!isCreatedPage"
                   @editAutoParts="editAutoParts"
                   :qrCode="AUTO_PARTS_INDEX.qrCode"
                  :linkToSite="AUTO_PARTS_INDEX.linkToSite"
                />
                <AutoPartsIndexButtonsCreate
                  v-else
                  @editAutoParts="setAutoPartsFromApi"
                />
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
  </div>
</template>

<script>
  import AutoPartsIndexField from "@/components/autoParts/AutoPartsIndexField.vue";
  import AutoPartsIndexButtonsCreate from "@/components/autoParts/AutoPartsIndexButtonsCreate.vue";
  import AutoPartsIndexButtonsEdit from "@/components/autoParts/AutoPartsIndexButtonsEdit.vue";
  import BaseMultiselect from "@/components/UI/BaseMultiselect.vue";
  import Breadcrumb from "@/components/UI/BaseBreadcrumb.vue";
  import {mapActions, mapGetters} from "vuex";
  import {DOMAIN, STATUS, YEARS, BODYS, TRANSMISSION, FUELS, TYPE_ENGINES_ALL, TYPE_ENGINES_DISEL, TYPE_ENGINES_BENZ, WHEEL_DIAMETER_R, WHEEL_WIDTH_J, NUMBER_OF_HOLES, PCD, DIAMETER} from "@/constants/constants";
  import vue2Dropzone from 'vue2-dropzone';

  export default {
    name: "AutoParstIndex",

    components: {
      Breadcrumb,
      vueDropzone: vue2Dropzone,
      BaseMultiselect,
      AutoPartsIndexButtonsEdit,
      AutoPartsIndexButtonsCreate,
      AutoPartsIndexField
    },

    mounted() {
      if(!this.isCreatedPage) {
        this.GET_AUTO_PARTS_INDEX(this.param);
      }

      if(this.isCreatedPage) {
        this.AUTO_PARTS_INDEX.status = "Активно";
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
        let created = false;
        if(this.$route.name === "autoPartsCreate") {
          this.RESET_AUTO_PARTS_FOR_CREATE_PAGE();
          created = true;
        }
        return created;
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
        'RESET_AUTO_PARTS_FOR_CREATE_PAGE'
      ]),

      dopFieldsSearch(select) {
        if(select.code == 257 || select.code == 262) {
          this.dopFieldsForCastDiskDrive = true;
        } else {
          this.dopFieldsForCastDiskDrive = false;
        }
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

        if(this.AUTO_PARTS_INDEX.firstname !== undefined){
          xForm.append('firstname', this.AUTO_PARTS_INDEX.firstname);
        }

        if(this.AUTO_PARTS_INDEX.stock !== undefined){
          xForm.append('stock', this.AUTO_PARTS_INDEX.stock);
        }

        if(this.AUTO_PARTS_INDEX.telephone !== undefined){
          xForm.append('telephone', this.AUTO_PARTS_INDEX.telephone);
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
          xForm.append('autoPartsName', this.AUTO_PARTS_INDEX.autoPartsName.code);
        }

        if(this.AUTO_PARTS_INDEX.diameter !== undefined){
          xForm.append('diameter', this.AUTO_PARTS_INDEX.diameter);
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

        if(this.AUTO_PARTS_INDEX.description !== undefined){
          xForm.append('description', this.AUTO_PARTS_INDEX.description);
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

      getFuelToTypeEngines(option) {
        if(option == 'дизель') {
          this.typeEngines = TYPE_ENGINES_DISEL;
        } else if(option == 'бензин') {
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
