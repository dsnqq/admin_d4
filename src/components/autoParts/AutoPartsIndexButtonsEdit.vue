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

<script setup>
import { DOMAIN } from '@/constants/constants';
import { defineProps, defineEmits } from 'vue';

const emit = defineEmits(['editAutoParts']);

const editAutoParts = (redirect) => {
  emit('editAutoParts', redirect);
};

const printQrAutoParts = () => {
  const isIframe = window.frames['autoPartsQrCode'];
  isIframe.document.write(props.qrCode);
  isIframe.document.close();
};

const props = defineProps({
  linkToSite: {
    type: String,
    default: '',
  },

  qrCode: {
    type: String,
    default: '',
  },
});
</script>

<style lang="scss" scoped>
@import '@/components/autoParts/style/auto-parts-index-buttons-edit.scss';
</style>
