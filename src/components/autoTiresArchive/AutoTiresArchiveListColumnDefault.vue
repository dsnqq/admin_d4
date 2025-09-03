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
  name: "AutoTiresArchiveListColumnDefault",

  props: ["content", "contentExtension"],
};
</script>
