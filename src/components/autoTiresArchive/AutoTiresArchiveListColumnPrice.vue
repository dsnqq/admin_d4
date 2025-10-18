<template>
  <div class="auto-parts-list-column-price">{{ priceUSD }} $</div>
</template>

<script setup>
import { defineProps } from 'vue';

defineProps({
  priceUSD: {
    type: [Number, String],
    default: 0,
  },
});
</script>
