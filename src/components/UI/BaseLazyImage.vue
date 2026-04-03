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
import { useBaseLazyLoadImageService } from '@/components/UI/composables/useBaseLazyLoadImageService';

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

  setup() {
    const { fixImageUrl } = useBaseLazyLoadImageService();

    return {
      fixImageUrl,
    };
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
      if (this.$props.src == null) {
        return DOMAIN + '/image/no_image.png';
      }

      return this.fixImageUrl(this.$props.src);
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
