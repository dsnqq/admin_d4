<template>
  <div v-if="contentExtension === undefined">
    {{ content }}
  </div>
  <div v-else>
    {{ content + " " + contentExtension }}
  </div>
</template>

<script>
export default {
  name: "AutoPartsListColumnDefault",

  props: ["content", "contentExtension"],
};
</script>
