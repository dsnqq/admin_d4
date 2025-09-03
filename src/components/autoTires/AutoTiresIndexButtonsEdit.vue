<template>
  <div
    class="auto-tires-index-wrapp__field auto-tires-index-field auto-tires-index-field--is-btn"
  >
    <button @click.prevent="editAutoTires(true)" class="btn btn-primary">
      Сохранить
    </button>
    <button @click.prevent="editAutoTires(false)" class="btn btn-success">
      Сохранить и продолжить редактирование
    </button>
    <a :href="DOMAIN + linkToSite" target="_blank" class="btn btn-warning">
      Посмотреть на сайте
    </a>
    <button @click.prevent="printQrAutoParts" class="btn btn-dark">
      Печать QR
    </button>
    <router-link :to="{ name: 'autoTires' }" class="btn btn-info">
      Выйти без сохранения
    </router-link>

    <iframe name="autoTiresQrCode" class="auto-tires-index__iframe"></iframe>
  </div>
</template>

<script>
import { DOMAIN } from "@/constants/constants";

export default {
  name: "AutoTiresIndexButtonsEdit",

  props: {
    linkToSite: {
      type: String,
    },

    qrCode: {
      type: String,
    },
  },

  methods: {
    editAutoTires(redirect) {
      this.$emit("editAutoTires", redirect);
    },

    printQrAutoParts() {
      let isIframe = window.frames["autoTiresQrCode"];
      isIframe.document.write(this.qrCode);
      isIframe.document.close();
    },
  },

  data() {
    return {
      DOMAIN,
    };
  },
};
</script>

<style lang="scss" scoped>
@import "@/components/autoTires/style/auto-tires-index-buttons-edit.scss";
</style>
