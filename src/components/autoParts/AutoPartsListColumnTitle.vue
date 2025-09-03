<template>
  <span class="auto-parts-list-column-title d-flex align-items-center gap-2">
    <span class="mb-0 product-title">
      {{ title }}
    </span>
  </span>
</template>

<script>
export default {
  name: "AutoPartsListColumnTitle",

  props: ["title"],
};
</script>
