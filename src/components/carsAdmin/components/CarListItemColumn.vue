<template>
  <div class="car-list-wrapper-column">
    <template v-if="this.name === 'images'">
      <div
          v-if="store[this.name]"
          class="car-list-wrapper-column__images car-list-wrapper-column-images"
      >
        <div
            v-for="(image, index) in store[this.name]"
            v-bind:key="index"
            class="car-list-wrapper-column-images__item"
        >
          <a
              :href="DOMAIN + `/image/` + image"
              :data-lightbox="`image` + store.product_id"
          >
            <img :src="DOMAIN + `/image/` + image" />
          </a>
        </div>
      </div>
    </template>
    <template v-else-if="this.name === 'action'">
      <router-link
          :to="`/car/${store.product_id}`"
          class="btn car-list-wrapper-column__link"
      >Редактировать</router-link>
      <span
          v-on:click="removeCar(store.product_id)"
          class="btn car-list-wrapper-column__remove"
      >Удалить</span>
    </template>
    <template v-else>
      <template v-if="!columnEdit && store[this.name] !== 'undefined'">
        {{store[this.name]}}
      </template>
      <span
          v-if="store[this.name] && editThisColumnOnList"
          class="car-list-wrapper-column__edits car-list-wrapper-column-edits"
      >
        <form
            v-if="columnEdit"
        >
          <input
              :placeholder="store[this.name]"
              v-model="edits"
              class="car-list-wrapper-column-edits__input"
              type="text"
          >
        </form>
          <button
              v-on:click.prevent="setEditThisColumnOnList"
              class="car-list-wrapper-column-edits__button car-list-wrapper-column-edit"
          >
            <svg
                v-if="!columnEdit"
                xmlns="http://www.w3.org/2000/svg"
                width="15px"
                height="15px"
                viewBox="0 0 24 24"
                fill="none"
            >
              <path d="M13 21H21" stroke="#323232" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M20.0651 7.39423L7.09967 20.4114C6.72438 20.7882 6.21446 21 5.68265 21H4.00383C3.44943 21 3 20.5466 3 19.9922V18.2987C3 17.7696 3.20962 17.2621 3.58297 16.8873L16.5517 3.86681C19.5632 1.34721 22.5747 4.87462 20.0651 7.39423Z" stroke="#323232" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M15.3096 5.30981L18.7273 8.72755" stroke="#323232" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              <path opacity="0.1" d="M18.556 8.90942L7.09967 20.4114C6.72438 20.7882 6.21446 21 5.68265 21H4.00383C3.44943 21 3 20.5466 3 19.9922V18.2987C3 17.7696 3.20962 17.2621 3.58297 16.8873L15.0647 5.35974C15.0742 5.4062 15.0969 5.45049 15.1329 5.48653L18.5506 8.90426C18.5524 8.90601 18.5542 8.90773 18.556 8.90942Z" fill="#323232"/>
            </svg>
            <svg
                v-else
                xmlns="http://www.w3.org/2000/svg" width="15px" height="15px" viewBox="0 0 24 24" fill="none">
              <path d="M17 20.75H7C6.27065 20.75 5.57118 20.4603 5.05546 19.9445C4.53973 19.4288 4.25 18.7293 4.25 18V6C4.25 5.27065 4.53973 4.57118 5.05546 4.05546C5.57118 3.53973 6.27065 3.25 7 3.25H14.5C14.6988 3.25018 14.8895 3.32931 15.03 3.47L19.53 8C19.6707 8.14052 19.7498 8.33115 19.75 8.53V18C19.75 18.7293 19.4603 19.4288 18.9445 19.9445C18.4288 20.4603 17.7293 20.75 17 20.75ZM7 4.75C6.66848 4.75 6.35054 4.8817 6.11612 5.11612C5.8817 5.35054 5.75 5.66848 5.75 6V18C5.75 18.3315 5.8817 18.6495 6.11612 18.8839C6.35054 19.1183 6.66848 19.25 7 19.25H17C17.3315 19.25 17.6495 19.1183 17.8839 18.8839C18.1183 18.6495 18.25 18.3315 18.25 18V8.81L14.19 4.75H7Z" fill="#000000"/>
              <path d="M16.75 20H15.25V13.75H8.75V20H7.25V13.5C7.25 13.1685 7.3817 12.8505 7.61612 12.6161C7.85054 12.3817 8.16848 12.25 8.5 12.25H15.5C15.8315 12.25 16.1495 12.3817 16.3839 12.6161C16.6183 12.8505 16.75 13.1685 16.75 13.5V20Z" fill="#000000"/>
              <path d="M12.47 8.75H8.53001C8.3606 8.74869 8.19311 8.71403 8.0371 8.64799C7.88109 8.58195 7.73962 8.48582 7.62076 8.36511C7.5019 8.24439 7.40798 8.10144 7.34437 7.94443C7.28075 7.78741 7.24869 7.61941 7.25001 7.45V4H8.75001V7.25H12.25V4H13.75V7.45C13.7513 7.61941 13.7193 7.78741 13.6557 7.94443C13.592 8.10144 13.4981 8.24439 13.3793 8.36511C13.2604 8.48582 13.1189 8.58195 12.9629 8.64799C12.8069 8.71403 12.6394 8.74869 12.47 8.75Z" fill="#000000"/>
            </svg>
          </button>
      </span>
    </template>
  </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import {LIST_COLUMN_EDIT, DOMAIN} from '../../../constants/constants';
import Jquery from 'jquery'; // eslint-disable-line no-unused-vars
import lightbox from 'lightbox2'; // eslint-disable-line no-unused-vars

export default {
  name: "CarListItemColumn",

  computed: {
    ...mapGetters([
        'CARS'
    ]),

    editThisColumnOnList: function () {
      return LIST_COLUMN_EDIT.includes(this.name);
    }
  },

  methods: {
    ...mapActions([
        'SET_EDIT_COLUMN_ON_LIST',
        'DELET_CAR_BY_API'
    ]),

    setEditThisColumnOnList: function () {
      if(this.columnEdit && this.edits !== null && this.edits !== "" && this.edits !== this.store[this.name]) {
        let xForm = new FormData();
        let id = this.store.product_id;

        xForm.append('name', this.name);
        xForm.append('edits', this.edits);

        let param = {
          id: id,
          xForm: xForm,
          car: this.number,
          name: this.name,
          edits: this.edits
        };
        this.SET_EDIT_COLUMN_ON_LIST(param);
      }

      this.columnEdit = !this.columnEdit;
    },

    removeCar: function(carId) {
      if(confirm("Вы действительно хотите удалить данное авто ?")) {
        let param = {
          carId: carId,
          car: this.number
        };

        this.DELET_CAR_BY_API(param);
      }
    },
  },

  props: {
    name: {
      type: String,
      default: "",
    },

    number: {
      type: Number,
    },

    store: {
      type: Object
    }
  },

  data() {
    return {
      DOMAIN,
      edits: this.store[this.name],
      columnEdit: false
    }
  }
}
</script>

<style scoped lang="scss">
@import "./src/components/carsAdmin/style/car-list-item.scss";
@import "../../../../node_modules/lightbox2/dist/css/lightbox.min.css";
</style>