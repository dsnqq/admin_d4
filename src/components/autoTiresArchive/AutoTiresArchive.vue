<template>
  <component :is="autoTiresArchive()"></component>
</template>

<script>
export default {
  name: "AutoTiresArchive",

  components: {
    AutoTiresArchiveList: () => import("@/components/autoTiresArchive/components/AutoTiresArchiveList.vue"),
  },

  methods: {
    autoTiresArchive() {
      if(this.$route.name === "autoPartsDetail"){
        return 'AutoPartsIndex';
      }

      return 'AutoTiresArchiveList';
    }
  },
}
</script>