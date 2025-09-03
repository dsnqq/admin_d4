<template>
  <div
    class="auto-tires-index-wrapp__field auto-tires-index-field auto-tires-index-field--is-btn"
  >
    <button class="btn btn-primary" @click.prevent="editAutoTires(true)">
      Сохранить
    </button>
    <button class="btn btn-success" @click.prevent="editAutoTires(false)">
      Сохранить и продолжить редактирование
    </button>
    <a :href="DOMAIN + linkToSite" target="_blank" class="btn btn-warning">
      Посмотреть на сайте
    </a>
    <button class="btn btn-dark" @click.prevent="printQrAutoParts">
      Печать QR
    </button>
    <router-link :to="{ name: 'autoTires' }" class="btn btn-info">
      Выйти без сохранения
    </router-link>

    <iframe name="autoTiresQrCode" class="auto-tires-index__iframe"></iframe>
  </div>
</template>

<script>
import { DOMAIN } from '@/constants/constants';

export default {
  name: 'AutoTiresIndexButtonsEdit',

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
    editAutoTires(redirect) {
      this.$emit('editAutoTires', redirect);
    },

    printQrAutoParts() {
      let isIframe = window.frames['autoTiresQrCode'];
      isIframe.document.write(this.qrCode);
      isIframe.document.close();
    },
  },
};
</script>

<style lang="scss" scoped>
@import '@/components/autoTires/style/auto-tires-index-buttons-edit.scss';
</style>
