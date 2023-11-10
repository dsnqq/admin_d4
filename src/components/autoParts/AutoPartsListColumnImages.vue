<template>
  <div class="auto-parts-list-column-images">
    <a
        :href="DOMAIN + `/image/` + images[0].imageBig"
        :data-title="title"
        :data-lightbox="id"
        class="product-box-image"
    >
      <BaseLazyImage
        :src="images[0].imageMini"
        :alt="title"
      />
    </a>
    <div class="product-box-image-flex">
      <a
          :data-lightbox="id"
          v-for="(image, index) in images"
          :key="index"
          :data-title="title"
          :href="DOMAIN + `/image/` + image.imageBig"
          class="product-box-image--small"
          v-show="image.imageShow"
      >
        <BaseLazyImage
            :src="image.imageMini"
            :alt="title"
        />
      </a>
      <span
          v-if="!showAll"
          @click="showImageAll(index)"
          class="product-more-photo"
      >Ещё фото</span>
    </div>
  </div>
</template>

<script>
  import BaseLazyImage from "@/components/UI/BaseLazyImage.vue";
  import {DOMAIN} from "@/constants/constants";
  import {mapActions} from "vuex";
  import Jquery from 'jquery'; // eslint-disable-line no-unused-vars
  import lightbox from 'lightbox2';

  export default {
    name: "AutoPartsListColumnImages",
    components: {BaseLazyImage},

    props: ['images', 'title', 'id', 'showAll', 'index'],

    methods: {
      ...mapActions('autoParts', [
        'SET_SHOW_ALL_IMAGE'
      ]),

      showImageAll(index) {
        this.SET_SHOW_ALL_IMAGE(index);
      },
    },

    data() {
      return {
        BaseLazyImage,
        DOMAIN
      }
    }
  }
</script>

<style lang="scss" scoped>
@import "/node_modules/lightbox2/dist/css/lightbox.min.css";
@import "./src/components/autoParts/style/auto-parts-list-column-images";
</style>