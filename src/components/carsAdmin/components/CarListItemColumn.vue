<template>
  <td class="car-list-wrapper-column">
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
      <div class="d-flex align-items-center gap-2 fs-6">
        <router-link
            :to="`/car/${store.product_id}`"
            class="p-2 text-warning"
        >
          <i class="bx bx-pencil"></i>
        </router-link>
        <a
            @click.prevent="removeCar(store.product_id)"
            class="p-2 text-danger"
        >
          <i class="bi bi-trash-fill"></i>
        </a>
      </div>
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
              @click.prevent="setEditThisColumnOnList"
              class="car-list-wrapper-column-edits__button car-list-wrapper-column-edit"
          >
            <i
               v-if="!columnEdit"
               class="bx bx-pencil p-2 text-warning"></i>
            <i
               v-else
               class="lni lni-save p-2 text-warning"></i>
          </button>
      </span>
    </template>
  </td>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import {DOMAIN} from "@/constants/constants";
import {LIST_COLUMN_EDIT} from "@/components/carsAdmin/constants/constants";
import Jquery from 'jquery'; // eslint-disable-line no-unused-vars
import lightbox from 'lightbox2'; // eslint-disable-line no-unused-vars

export default {
  name: "CarListItemColumn",

  computed: {
    ...mapGetters('carAdmin', [
        'CARS'
    ]),

    editThisColumnOnList() {
      return LIST_COLUMN_EDIT.includes(this.name);
    }
  },

  methods: {
    ...mapActions('carAdmin', [
        'SET_EDIT_COLUMN_ON_LIST',
        'DELET_CAR_BY_API'
    ]),

    setEditThisColumnOnList() {
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

    removeCar(carId) {
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