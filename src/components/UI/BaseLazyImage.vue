<template>
  <clazy-load class="base-lazy-image" :src="imageRenderUrl">
    <transition name="fade">
      <img :src="imageRenderUrl" :alt="alt" class="base-lazy-image__load" />
    </transition>
    <div slot="placeholder">
      <img :src="imageLoaderUrl" class="base-lazy-image__preloader" />
    </div>
  </clazy-load>
</template>

<script>
import { DOMAIN } from '@/constants/constants';

export default {
  name: 'BaseLazyImage',

  props: {
    alt: {
      type: String,
    },

    src: {
      type: String,
    },
  },

  data() {
    return {
      DOMAIN,
    };
  },

  computed: {
    imageLoaderUrl() {
      return DOMAIN + '/image/loader.gif';
    },

    imageRenderUrl() {
      return this.$props.src == null
        ? DOMAIN + '/image/no_image.png'
        : this.$props.src;
    },
  },
};
</script>

<style lang="scss" scoped>
.base-lazy-image {
  &__preloader,
  &__load {
    width: 100%;
  }
}
</style>
