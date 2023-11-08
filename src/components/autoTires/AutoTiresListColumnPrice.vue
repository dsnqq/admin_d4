<template>
  <div class="auto-tires-list-column-price">
    <div class="price-table">
      <template v-if="!columnEdit">
        {{priceUSD}} $
      </template>
      <span class="auto-tires-list-wrapper-column__edits auto-tires-list-wrapper-column-edits">
        <input
            v-if="columnEdit"
            placeholder="Цена"
            v-model="price"
            class="auto-tires-list-wrapper-column-edits__input"
            type="number"
        >
        <button
            @click.prevent="setEditThisColumnOnList"
            class="auto-tires-list-wrapper-column-edits__button auto-tires-list-wrapper-column-edit"
        >
        <i
            v-if="!columnEdit"
            class="bx bx-pencil p-2 text-warning"></i>
        <i
            v-else
            @click="setPriceAutoTires(id, price, index)"
            class="lni lni-save p-2 text-success"></i>
      </button>
    </span>
    </div>
    <div>
      {{priceBYN}} руб.
    </div>
  </div>
</template>

<script>
import {mapActions} from "vuex";

export default {
  name: "AutoTiresListColumnPrice",

  props: ['id', 'index', 'priceUSD', 'priceBYN'],

  methods: {
    ...mapActions('autoTires', [
      'CHANGE_AUTO_TIRES_PRICE'
    ]),

    setEditThisColumnOnList() {
      this.columnEdit = !this.columnEdit;
    },

    setPriceAutoTires(id, priceUSD, i) {
      let param = {
        id: id,
        priceUSD: priceUSD,
        index: i
      };

      if(priceUSD != null && parseInt(priceUSD) != 0) {
        this.CHANGE_AUTO_TIRES_PRICE(param);
      }
    },
  },

  computed: {
    price: {
      get() {
        return this.$props.priceUSD;
      },
      set(val) {
        this.$props.priceUSD = val;
      },
    },
  },

  data() {
    return {
      columnEdit: false
    }
  }
}
</script>

<style lang="scss" scoped>
@import "./src/components/autoTires/style/auto-tires-list-column-price";
</style>