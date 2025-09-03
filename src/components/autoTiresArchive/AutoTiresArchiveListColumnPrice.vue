<template>
  <div class="auto-parts-list-column-price">{{ priceUSD }} $</div>
</template>

<script>
export default {
  name: "AutoTiresArchiveListColumnPrice",

  props: ["priceUSD"],
};
</script>
