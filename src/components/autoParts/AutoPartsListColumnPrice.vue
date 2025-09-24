<template>
  <div class="auto-parts-list-column-price">
    <div class="price-table">
      <template v-if="!columnEdit"> {{ priceUSD }} $ </template>
      <span
        class="auto-parts-list-wrapper-column__edits auto-parts-list-wrapper-column-edits"
      >
        <input
          v-if="columnEdit"
          v-model="localPrice"
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
            @click="setPriceAutoParts(id, localPrice, index)"
          ></i>
        </button>
      </span>
    </div>
    <div>{{ priceBYN }} руб.</div>
  </div>
</template>

<script setup>
import { defineProps, ref, unref, watch } from 'vue';
import { useStore } from '@/composables/useStore';

const props = defineProps({
  id: {
    type: String,
    default: '0',
  },
  index: {
    type: [Number, String],
    default: 0,
  },
  priceUSD: {
    type: [Number, String],
    default: 0,
  },
  priceBYN: {
    type: [Number, String],
    default: 0,
  },
});

const columnEdit = ref(false);
const localPrice = ref(props.priceUSD);
const store = useStore();

const setEditThisColumnOnList = () => {
  columnEdit.value = !unref(columnEdit);
};

const setPriceAutoParts = (id, priceUSD, i) => {
  if (priceUSD != null && parseInt(priceUSD) != 0) {
    store.dispatch('autoParts/CHANGE_AUTO_PARTS_PRICE', {
      id: id,
      priceUSD: priceUSD,
      index: i,
    });
  }
};

watch(
  () => props.priceUSD,
  (newVal) => {
    localPrice.value = newVal;
  },
);
</script>

<style lang="scss" scoped>
@import './src/components/autoParts/style/auto-parts-list-column-price';
</style>
