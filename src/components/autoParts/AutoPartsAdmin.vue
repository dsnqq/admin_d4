<template>
    <div class="auto-parts-admin">
      <component :is="autoPartsAdmin()"></component>
    </div>
</template>

<script>
  export default {
    name: "AutoPartsAdmin",

    components: {
      AutoPartsIndex: () => import("./components/AutoPartsIndex.vue"),
      AutoPartsList: () => import("./components/AutoPartsList.vue")
    },

    methods: {
      autoPartsAdmin() {
        if(this.$route.name === "autoPartsDetail" || this.$route.name === "autoPartsCreate"){
          return 'AutoPartsIndex';
        }

        return 'AutoPartsList';
      }
    },
  }
</script>