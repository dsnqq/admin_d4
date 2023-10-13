<template>
  <div
      class="preloader"
      v-if="isUiLocked"
  >
    <img src="../../assets/images/loader.gif">
  </div>
</template>

<script>
  import tireStatistics from "@/components/tireStatistics/vuex/store";
  import sparePartsStatistics from "@/components/sparePartsStatistics/vuex/store";
  import historyUsers from '@/components/historyUsers/vuex/store';
  import autoParts from '@/components/autoParts/vuex/store';
  import autoPartsArchive from "@/components/autoPartsArchive/vuex/store";
  import autoTires from '@/components/autoTires/vuex/store';
  import autoTiresArchive from '@/components/autoTiresArchive/vuex/store';

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