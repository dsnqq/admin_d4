<template>
  <div class="auto-tires-list-column-images">
    <a
      :href="DOMAIN + `/image/` + images[0].imageBig"
      :data-title="title"
      :data-lightbox="id"
      class="product-box-image"
    >
      <BaseLazyImage :src="images[0].imageMini" :alt="title" />
    </a>
    <div class="product-box-image-flex">
      <a
        v-for="(image, index) in images"
        v-show="image.imageShow"
        :key="index"
        :data-lightbox="id"
        :data-title="title"
        :href="DOMAIN + `/image/` + image.imageBig"
        class="product-box-image--small"
      >
        <BaseLazyImage :src="image.imageMini" :alt="title" />
      </a>
      <span
        v-if="!showAll"
        class="product-more-photo"
        @click="showImageAll(index)"
        >Ещё фото</span
      >
    </div>
  </div>
</template>

<script setup>
import BaseLazyImage from '@/components/UI/BaseLazyImage.vue';
import { DOMAIN } from '@/constants/constants';
import Jquery from 'jquery'; // eslint-disable-line no-unused-vars
import lightbox from 'lightbox2';
import { defineProps } from 'vue';
import { useStore } from '@/composables/useStore';

const store = useStore();

defineProps({
  images: {
    type: String,
    default: 'no_image.png',
  },
  title: {
    type: String,
    default: '',
  },
  id: {
    type: [Number, String],
    default: 0,
  },
  showAll: {
    type: Boolean,
    default: false,
  },
  index: {
    type: [Number, String],
    default: 0,
  },
});

const showImageAll = (index) => {
  store.dispatch('autoTiresArchive/SET_SHOW_ALL_IMAGE', index);
};
</script>

<style lang="scss" scoped>
@import '/node_modules/lightbox2/dist/css/lightbox.min.css';
@import './src/components/autoTiresArchive/style/auto-tires-list-column-images';
</style>
