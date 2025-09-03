<template>
  <div class="auto-tires-list-column-actions">
    <div class="d-flex align-items-center justify-content-center gap-2 fs-6">
      <a
        :href="DOMAIN + linkToSite"
        target="_blank"
        class="text-primary"
        title="Открыть на сайте"
      >
        <i class="bi bi-eye-fill"></i>
      </a>
      <router-link
        :to="`/auto-tires/${id}`"
        class="text-warning"
        title="Редактировать"
      >
        <i class="bi bi-pencil-fill"></i>
      </router-link>
      <a class="text-primary cursor-pointer" @click="getPhotoAutoTires()">
        <i class="bi bi-camera"></i>
      </a>
      <a class="text-danger" @click.prevent="autoTiresRemove(id, index)">
        <i class="bi bi-trash-fill"></i>
      </a>
    </div>
    <div
      class="btn btn-info"
      @click="getPrintQrCodeAutoTires(AUTO_TIRES[index].qrCode)"
    >
      <span class="mobile-block-hidden">Печать</span> QR
    </div>
    <AutoTiresPhotoModal
      v-if="modalPhotoAdminShow"
      :auto-tires-id="id"
      @closePhotoModalAdmin="closePhotoModalAdmin"
    />
    <iframe
      name="autoPartsQrCode"
      class="auto-tires-list-column-actions__iframe"
    ></iframe>
  </div>
</template>

<script>
import { DOMAIN } from '@/constants/constants';
import { mapActions, mapGetters } from 'vuex';

export default {
  name: 'AutoTiresListColumnActions',

  components: {
    AutoTiresPhotoModal: () =>
      import('@/components/autoTires/modal/AutoTiresPhotoModal.vue'),
  },

  props: ['id', 'linkToSite', 'index'],

  computed: {
    ...mapGetters('autoTires', ['AUTO_TIRES']),
  },

  methods: {
    ...mapActions('autoTires', ['DELET_AUTO_TIRES_BY_API']),

    getPrintQrCodeAutoTires(qr) {
      let isIframe = window.frames['autoPartsQrCode'];
      isIframe.document.write(qr);
      isIframe.document.close();
    },

    getPhotoAutoTires() {
      this.modalPhotoAdminShow = true;
    },

    closePhotoModalAdmin() {
      this.modalPhotoAdminShow = false;
    },

    autoTiresRemove(id, index) {
      if (confirm('Вы действительно хотите удалить данную шину ?')) {
        let param = {
          autoTiresId: id,
          autoTiresNumber: index,
        };

        this.DELET_AUTO_TIRES_BY_API(param);
      }
    },
  },

  data() {
    return {
      DOMAIN,
      modalHistoryAdminShow: false,
      modalPhotoAdminShow: false,
    };
  },
};
</script>

<style lang="scss" scoped>
@import '@/components/autoTires/style/auto-tires-list-column-actions.scss';
</style>
