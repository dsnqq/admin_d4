<template>
  <div>
    <div class="price-table">
      <template v-if="!columnEdit">
        {{priceUSD}} $
      </template>
      <span class="auto-parts-list-wrapper-column__edits auto-parts-list-wrapper-column-edits">
        <input
            v-if="columnEdit"
            placeholder="Туть что-то"
            v-model="price"
            class="auto-parts-list-wrapper-column-edits__input"
            type="number"
        >
        <button
            @click.prevent="setEditThisColumnOnList"
            class="auto-parts-list-wrapper-column-edits__button auto-parts-list-wrapper-column-edit"
        >
        <i
            v-if="!columnEdit"
            class="bx bx-pencil p-2 text-warning"></i>
        <i
            v-else
            @click="setPriceAutoParts(id, price, index)"
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
  name: "AutoPartsListColumnPrice",

  props: ['id', 'index', 'priceUSD', 'priceBYN'],

  methods: {
    ...mapActions('autoParts', [
      'CHANGE_AUTO_PARTS_PRICE'
    ]),

    setEditThisColumnOnList() {
      this.columnEdit = !this.columnEdit;
    },

    setPriceAutoParts(id, priceUSD, i) {
      let param = {
        id: id,
        priceUSD: priceUSD,
        index: i
      };

      if(priceUSD != null && parseInt(priceUSD) != 0) {
        this.CHANGE_AUTO_PARTS_PRICE(param);
      }
    },
  },

  data() {
    return {
      columnEdit: false,
      price: this.priceUSD
    }
  }
}
</script>

<style lang="scss" scoped>
@import "./src/components/autoParts/components/style/auto-parts-list-column-price";
</style>