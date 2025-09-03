<template>
  <div v-if="isUiLocked" class="preloader">
    <img src="../../assets/images/loader.gif" />
  </div>
</template>

<script>
import generalStore from '@/vuex/store';

export default {
  name: 'BasePreloader',

  computed: {
    isUiLocked: function () {
      if (generalStore.state.lockingPool == 1) {
        return true;
      }

      return false;
    },
  },
};
</script>

<style lang="scss" scoped>
@import './src/components/UI/style/base-preloader';
</style>
