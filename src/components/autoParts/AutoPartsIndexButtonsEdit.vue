<template>
  <div
    class="auto-parts-index-wrapp__field auto-parts-index-field auto-parts-index-field--is-btn"
  >
    <button class="btn btn-primary" @click.prevent="editAutoParts(true)">
      Сохранить
    </button>
    <button class="btn btn-success" @click.prevent="editAutoParts(false)">
      Сохранить и продолжить редактирование
    </button>
    <a :href="DOMAIN + linkToSite" target="_blank" class="btn btn-warning">
      Посмотреть на сайте
    </a>
    <button class="btn btn-dark" @click.prevent="printQrAutoParts">
      Печать QR
    </button>
    <router-link :to="{ name: 'autoParts' }" class="btn btn-info">
      Выйти без сохранения
    </router-link>

    <iframe name="autoPartsQrCode" class="auto-parts-index__iframe"></iframe>
  </div>
</template>

<script>
import { DOMAIN } from '@/constants/constants';

export default {
  name: 'AutoPartsIndexButtonsEdit',

  props: {
    linkToSite: {
      type: String,
    },

    qrCode: {
      type: String,
    },
  },

  data() {
    return {
      DOMAIN,
    };
  },

  methods: {
    editAutoParts(redirect) {
      this.$emit('editAutoParts', redirect);
    },

    printQrAutoParts() {
      let isIframe = window.frames['autoPartsQrCode'];
      isIframe.document.write(this.qrCode);
      isIframe.document.close();
    },
  },
};
</script>

<style lang="scss" scoped>
@import '@/components/autoParts/style/auto-parts-index-buttons-edit.scss';
</style>
