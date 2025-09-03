<template>
  <div class="auto-parts-list-column-actions">
    <div class="d-flex align-items-center gap-2 fs-6">
      <a
        class="text-primary cursor-pointer"
        @click.p.prevent="getHistoryAuto(id)"
      >
        <i class="bi bi-archive"></i>
      </a>
      <a
        :href="DOMAIN + linkToSite"
        target="_blank"
        class="text-primary"
        title="Открыть на сайте"
      >
        <i class="bi bi-eye-fill"></i>
      </a>
      <router-link
        :to="`/auto/${id}`"
        class="text-warning"
        title="Редактировать"
      >
        <i class="bi bi-pencil-fill"></i>
      </router-link>
      <a class="text-primary cursor-pointer" @click="getPhotoAutoParts()">
        <i class="bi bi-camera"></i>
      </a>
      <a
        class="text-danger cursor-pointer"
        @click.prevent="autoPartsRemove(id, index)"
      >
        <i class="bi bi-trash-fill"></i>
      </a>
    </div>
    <div class="td-viewed">Просмотров: {{ view }}</div>
    <div
      class="btn btn-info btn-mobile-event"
      @click="getPrintQrCodeAutoParts(AUTO_PARTS[index].qrCode)"
    >
      <span class="mobile-block-hidden">Печать</span> QR
    </div>
    <AutoPartsHistoryModal
      v-if="modalHistoryAdminShow"
      @closeHistoryModalAdmin="closeHistoryModalAdmin"
    />
    <AutoPartsPhotoModal
      v-if="modalPhotoAdminShow"
      :auto-parts-id="id"
      @closePhotoModalAdmin="closePhotoModalAdmin"
    />
    <iframe
      name="autoPartsQrCode"
      class="auto-parts-list-column-actions__iframe"
    ></iframe>
  </div>
</template>

<script>
import { DOMAIN } from '@/constants/constants';
import { mapActions, mapGetters } from 'vuex';

export default {
  name: 'AutoPartsListColumnActions',

  components: {
    AutoPartsHistoryModal: () =>
      import('@/components/autoParts/modal/AutoPartsHistoryModal.vue'),
    AutoPartsPhotoModal: () =>
      import('@/components/autoParts/modal/AutoPartsPhotoModal.vue'),
  },

  props: ['id', 'linkToSite', 'index', 'view'],

  computed: {
    ...mapGetters('autoParts', ['AUTO_PARTS']),
  },

  methods: {
    ...mapActions('autoParts', [
      'DELET_AUTO_PARTS_BY_API',
      'GET_AUTO_PARTS_HISTORY',
    ]),

    getPrintQrCodeAutoParts(qr) {
      let isIframe = window.frames['autoPartsQrCode'];
      isIframe.document.write(qr);
      isIframe.document.close();
    },

    getPhotoAutoParts() {
      this.modalPhotoAdminShow = true;
    },

    closeHistoryModalAdmin() {
      this.modalHistoryAdminShow = false;
    },

    closePhotoModalAdmin() {
      this.modalPhotoAdminShow = false;
    },

    getHistoryAuto(id) {
      this.modalHistoryAdminShow = true;
      this.GET_AUTO_PARTS_HISTORY(id);
    },

    autoPartsRemove(id, index) {
      if (confirm('Вы действительно хотите удалить данную запчасть ?')) {
        let param = {
          autoPartsId: id,
          autoPartsNumber: index,
        };

        this.DELET_AUTO_PARTS_BY_API(param);
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
@import '@/components/autoParts/style/auto-parts-list-column-actions.scss';
</style>
