<template>
  <div class="auto-parts-list-column-price">{{ priceUSD }} $</div>
</template>

<script>
export default {
  name: 'AutoPartsArchiveListColumnPrice',

  props: ['priceUSD'],
};
</script>
