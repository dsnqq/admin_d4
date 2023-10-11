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
  import historyUsers from "@/vuex/modules/historyUsers/historyUsers";
  import autoParts from "@/vuex/modules/autoParts/autoParts";
  import autoPartsArchive from "@/vuex/modules/autoPartsArchive/autoPartsArchive";
  import autoTires from "@/vuex/modules/autoTires/autoTires";
  import autoTiresArchive from "@/vuex/modules/autoTiresArchive/autoTiresArchive";

  export default {
    name: 'PreloaderAdmin',

    computed: {
      isUiLocked: function (){
        if(sparePartsStatistics.state.lockingPool == 1 ||
            tireStatistics.state.lockingPool == 1  ||
            historyUsers.state.lockingPool == 1  ||
            autoPartsArchive.state.lockingPool == 1  ||
            autoTiresArchive.state.lockingPool == 1  ||
            autoTires.state.lockingPool == 1  ||
            autoParts.state.lockingPool == 1) {
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