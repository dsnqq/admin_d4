<template>
  <clazy-load :src="src">
    <transition name="fade">
      <img
          :src="src"
          :alt="alt"
      />
    </transition>
    <div slot="placeholder">
      <img :src="imageUrl">
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
.loaded {
  img {
    width: 100%;
  }
}
</style>