<template>
    <component :is="autoPartsAdmin()"></component>
</template>

<script>
  export default {
    name: "AutoPartsAdmin",

    components: {
      AutoPartsIndex: () => import("./components/AutoPartsIndex.vue"),
      AutoPartsList: () => import("./components/AutoPartsList.vue"),
    },

    methods: {
      autoPartsAdmin() {
        if(this.$route.name === "autoPartsDetail"){
          return 'AutoPartsIndex';
        }

        return 'AutoPartsList';
      }
    },
  }
</script>