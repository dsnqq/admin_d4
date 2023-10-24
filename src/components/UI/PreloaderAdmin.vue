<template>
  <div
      class="preloader"
      v-if="isUiLocked"
  >
    <img src="../../assets/images/loader.gif">
  </div>
</template>

<script>
  import generalStore from "@/vuex/store"

  export default {
    name: 'PreloaderAdmin',

    computed: {
      isUiLocked: function (){
        if(generalStore.state.lockingPool == 1) {
          return true;
        }

        return false;
      }
    },
  }
</script>

<style lang="scss" scoped>
@import "./src/components/UI/style/preloader-admin";
</style>