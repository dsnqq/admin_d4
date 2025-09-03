<template>
  <div class="auto-parts-list-column-price">
    <div class="price-table">
      <template v-if="!columnEdit"> {{ priceUSD }} $ </template>
      <span
        class="auto-parts-list-wrapper-column__edits auto-parts-list-wrapper-column-edits"
      >
        <input
          v-if="columnEdit"
          v-model="price"
          placeholder="Цена"
          class="auto-parts-list-wrapper-column-edits__input"
          type="number"
        />
        <button
          class="auto-parts-list-wrapper-column-edits__button auto-parts-list-wrapper-column-edit"
          @click.prevent="setEditThisColumnOnList"
        >
          <i v-if="!columnEdit" class="bx bx-pencil p-2 text-warning"></i>
          <i
            v-else
            class="lni lni-save p-2 text-success"
            @click="setPriceAutoParts(id, price, index)"
          ></i>
        </button>
      </span>
    </div>
    <div>{{ priceBYN }} руб.</div>
  </div>
</template>

<script>
import { mapActions } from 'vuex';

export default {
  name: 'AutoPartsListColumnPrice',

  props: ['id', 'index', 'priceUSD', 'priceBYN'],

  methods: {
    ...mapActions('autoParts', ['CHANGE_AUTO_PARTS_PRICE']),

    setEditThisColumnOnList() {
      this.columnEdit = !this.columnEdit;
    },

    setPriceAutoParts(id, priceUSD, i) {
      let param = {
        id: id,
        priceUSD: priceUSD,
        index: i,
      };

      if (priceUSD != null && parseInt(priceUSD) != 0) {
        this.CHANGE_AUTO_PARTS_PRICE(param);
      }
    },
  },

  data() {
    return {
      columnEdit: false,
    };
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
};
</script>

<style lang="scss" scoped>
@import './src/components/autoParts/style/auto-parts-list-column-price';
</style>
