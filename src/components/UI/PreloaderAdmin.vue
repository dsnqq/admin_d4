<template>
  <div
      class="preloader"
      v-if="IS_UI_LOCKED == 1"
  >
    <img src="../../assets/images/loader.gif">
  </div>
</template>

<script>
  import {mapGetters} from "vuex";

  export default {
    name: 'PreloaderAdmin',

    computed: {
      ...mapGetters('sparePartsStatistics', [
        'IS_UI_LOCKED'
      ])
    },
  }
</script>

<style lang="scss" scoped>
@import "./src/components/UI/style/preloader-admin";
</style>