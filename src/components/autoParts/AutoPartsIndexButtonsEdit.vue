<template>
  <div class="auto-parts-index-wrapp__field auto-parts-index-field auto-parts-index-field--is-btn">
    <button
        @click.prevent="editAutoParts(true)"
        class="btn btn-primary"
    >
      Сохранить
    </button>
    <button
        @click.prevent="editAutoParts(false)"
        class="btn btn-success"
    >
      Сохранить и продолжить редактирование
    </button>
    <a
        :href="DOMAIN + linkToSite"
        target="_blank"
        class="btn btn-warning"
    >
      Посмотреть на сайте
    </a>
    <button
        @click.prevent="printQrAutoParts"
        class="btn btn-dark"
    >
      Печать QR
    </button>
    <router-link
        :to="{name: 'autoParts'}"
        class="btn btn-info"
    >
      Выйти без сохранения
    </router-link>

    <iframe name="autoPartsQrCode" class="auto-parts-index__iframe"></iframe>
  </div>
</template>

<script>
  import {DOMAIN} from "@/constants/constants";

  export default {
    name: "AutoPartsIndexButtonsEdit",

    props: {
      linkToSite: {
        type: String
      },

      qrCode: {
        type: String
      }
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

    data() {
      return {
        DOMAIN
      }
    }
  }
</script>

<style lang="scss" scoped>
@import "@/components/autoParts/style/auto-parts-index-buttons-edit.scss";
</style>