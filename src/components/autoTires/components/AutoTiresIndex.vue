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
        шапочка
      </div>
      <div class="card-body">
        <div class="row">
          <form>
            <div class="auto-parts-index__wrapp auto-parts-index-wrapp">
              <div class="auto-parts-index-wrapp__field auto-parts-index-field">
                <label class="auto-parts-index-field__label">Статус:</label>
                <div class="auto-parts-index-field__wrap">
                  <v-multiselect
                      v-model="getThisStatus"
                      :options="statusOptions"
                      class="auto-parts-index-field__select"
                  ></v-multiselect>
                </div>
              </div>
              <div class="auto-parts-index-wrapp__field auto-parts-index-field">
                <label class="auto-parts-index-field__label auto-parts-index-field__label--is-required">Марка и модель:</label>
                <div class="auto-parts-index-field__wrap">
                  <input type="text" id="vin" placeholder="VIN" class="auto-parts-index-field__input">
                </div>
              </div>
              <div class="auto-parts-index-wrapp__field auto-parts-index-field">
                <label class="auto-parts-index-field__label auto-parts-index-field__label--is-required">Год:</label>
                <div class="auto-parts-index-field__wrap auto-parts-index-field__wrap--is-flex">
                  <v-multiselect
                      v-model="AUTO_PARTS_INDEX.year"
                      :options="this.years"
                      class="auto-parts-index-field__select"
                  ></v-multiselect>
                  <input type="text" id="vin" placeholder="Модификация" class="auto-parts-index-field__input">
                </div>
              </div>
              <div class="auto-parts-index-wrapp__field auto-parts-index-field">
                <label class="auto-parts-index-field__label">Объем (л), топливо и тип:</label>
                <div class="auto-parts-index-field__wrap auto-parts-index-field__wrap--is-flex">
                  <input
                      v-model="AUTO_PARTS_INDEX.value"
                      type="text"
                      placeholder="Объём"
                      class="auto-parts-index-field__input"
                  />
                  <v-multiselect
                      v-model="AUTO_PARTS_INDEX.fuel"
                      :options="this.fuels"
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
                      class="auto-parts-index-field__select"
                  ></v-multiselect>
                </div>
              </div>
              <div class="auto-parts-index-wrapp__field auto-parts-index-field">
                <label class="auto-parts-index-field__label">Тип кузова и коробка:</label>
                <div class="auto-parts-index-field__wrap auto-parts-index-field__wrap--is-flex">
                  <v-multiselect
                      v-model="AUTO_PARTS_INDEX.typeBody"
                      :options="this.body"
                      class="auto-parts-index-field__select"
                  ></v-multiselect>
                  <v-multiselect
                      v-model="AUTO_PARTS_INDEX.transmission"
                      :options="this.transmission"
                      class="auto-parts-index-field__select"
                  ></v-multiselect>
                </div>
              </div>
              <div class="auto-parts-index-wrapp__field auto-parts-index-field">
                <label class="auto-parts-index-field__label auto-parts-index-field__label--is-required">Запчасть:</label>
                <div class="auto-parts-index-field__wrap">
                  <input type="text" id="vin" placeholder="Запчасть" class="auto-parts-index-field__input">
                </div>
              </div>
              <div class="auto-parts-index-wrapp__field auto-parts-index-field">
                <label class="auto-parts-index-field__label">Описание:</label>
                <div class="auto-parts-index-field__wrap">
                  <textarea
                      placeholder="Описание"
                      class="auto-parts-index-field__textarea"
                  ></textarea>
                </div>
              </div>
              <div class="auto-parts-index-wrapp__field auto-parts-index-field">
                <label class="auto-parts-index-field__label">Артикул (ext_id автоматически):</label>
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
                <label class="auto-parts-index-field__label">Номер запчасти:</label>
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
                <label class="auto-parts-index-field__label auto-parts-index-field__label--is-required">Цена в долларах:</label>
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
                <label class="auto-parts-index-field__label">Процент скидки (мин.5%):</label>
                <div class="auto-parts-index-field__wrap">
                  <input type="text" id="vin" placeholder="Скидка" class="auto-parts-index-field__input">
                </div>
              </div>
              <div class="auto-parts-index-wrapp__field auto-parts-index-field">
                <label class="auto-parts-index-field__label">Код видео с youtube.com:</label>
                <div class="auto-parts-index-field__wrap">
                  <input
                      v-model="AUTO_PARTS_INDEX.youtube"
                      type="text"
                      placeholder="Видео"
                      class="auto-parts-index-field__input"
                  >
                </div>
              </div>
              <div class="auto-parts-index-wrapp__field auto-parts-index-field auto-parts-index-field--is-btn">
                <button
                    class="btn btn-primary"
                >Добавить объявление</button>
                <button
                    class="btn btn-success"
                >Сохранить и продолжить редактирование</button>
                <router-link :to="{name: 'carsAdmin'}">
                  <button class="btn btn-info">Выйти без сохранения</button>
                </router-link>
                <button
                    class="btn btn-warning"
                >Посмотреть на сайте</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import BreadcrumbAdmin from "@/components/BreadcrumbAdmin.vue";
  import {mapActions, mapGetters} from "vuex";
  import {DOMAIN} from "../../../constants/constants";
  import {STATUS, YEARS, BODYS, TRANSMISSION, FUELS, TYPE_ENGINES_ALL, TYPE_ENGINES_DISEL, TYPE_ENGINES_BENZ} from "../constants/constants";

  export default {
    name: "AutoParstIndex",

    components: {
      BreadcrumbAdmin
    },

    mounted() {
      this.GET_AUTO_PARTS_INDEX(this.param);
    },

    computed: {
      ...mapGetters('autoParts', [
          'AUTO_PARTS_INDEX'
      ]),

      getThisStatus() {
        return (this.AUTO_PARTS_INDEX.status == 1) ? 'Активно' : 'Неактивно';
      }
    },

    methods: {
      ...mapActions('autoParts', [
        'GET_AUTO_PARTS_INDEX',
      ]),

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
        domain: DOMAIN,
        statusOptions: STATUS,
        years: YEARS,
        body: BODYS,
        transmission: TRANSMISSION,
        fuels: FUELS,
        typeEngines: TYPE_ENGINES_ALL
      };
    }
  }
</script>

<style scoped lang="sass">
@import "./src/components/autoTires/components/style/auto-tires-index"
</style>