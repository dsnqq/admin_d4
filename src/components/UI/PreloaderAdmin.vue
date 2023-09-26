<template>
  <div
      class="preloader"
      v-if="isUiLocked"
  >
    <img src="../../assets/images/loader.gif">
  </div>
</template>

<script>
  import tireStatistics from "@/vuex/modules/tireStatistics/tireStatistics";
  import sparePartsStatistics from "@/vuex/modules/sparePartsStatistics/sparePartsStatistics";

  export default {
    name: 'PreloaderAdmin',

    computed: {
      isUiLocked: function (){
        return sparePartsStatistics.state.lockingPool == 1 || tireStatistics.state.lockingPool == 1;
      }
    },
  }
</script>

<style lang="scss" scoped>
@import "./src/components/UI/style/preloader-admin";
</style>