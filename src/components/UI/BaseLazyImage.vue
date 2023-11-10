<template>
  <clazy-load
      class="base-lazy-image"
      :src="src"
  >
    <transition name="fade">
      <img
          :src="src"
          :alt="alt"
          class="base-lazy-image__load"
      />
    </transition>
    <div slot="placeholder">
      <img
          :src="imageUrl"
          class="base-lazy-image__preloader"
      />
    </div>
  </clazy-load>
</template>

<script>
import {DOMAIN} from "@/constants/constants";

export default {
  name: "BaseLazyImage",

  props: {
    alt: {
      type: String
    },

    src: {
      type: String
    }
  },

  computed: {
    imageUrl() {
      return DOMAIN + '/image/loader.gif';
    }
  },

  data() {
    return {
      DOMAIN
    }
  }
}
</script>

<style lang="scss" scoped>
.base-lazy-image {
  &__preloader,
  &__load {
    width: 100%;
  }
}
</style>