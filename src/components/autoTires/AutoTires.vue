<template>
    <component :is="autoTires()"></component>
</template>

<script>
export default {
  name: "AutoTires",

  components: {
    AutoTiresIndex: () => import("@/components/autoTires/components/AutoTiresIndex.vue"),
    AutoTiresList: () => import("@/components/autoTires/components/AutoTiresList.vue")
  },

  methods: {
    autoTires() {
      if(this.$route.name === "autoPartsDetail"){
        return 'AutoTiresIndex';
      }

      return 'AutoTiresList';
    }
  },
}
</script>