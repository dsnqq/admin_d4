<template>
  <div class="auto-parts-list-column-actions">
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
          :to="`/tire/${id}`"
          class="text-warning"
          title="Редактировать"
      >
        <i class="bi bi-pencil-fill"></i>
      </router-link>
      <a
          @click="getPhotoAutoParts()"
          class="text-primary cursor-pointer"
      >
        <i class="bi bi-camera"></i>
      </a>
      <a
          @click.prevent="autoTiresRemove(id, index)"
          class="text-danger"
      >
        <i class="bi bi-trash-fill"></i>
      </a>
    </div>
    <div
        @click="getPrintQrCodeAutoParts(AUTO_TIRES[index].qrCode)"
        class="btn btn-info"
    >
      Печать QR
    </div>
    <AutoTiresPhotoModal
        @closePhotoModalAdmin="closePhotoModalAdmin"
        v-if="modalPhotoAdminShow"
        :autoPartsId="id"
    />
    <iframe
        name="autoPartsQrCode"
        class="auto-parts-list-column-actions__iframe"
    ></iframe>
  </div>
</template>

<script>
  import {DOMAIN} from "@/constants/constants";
  import {mapActions, mapGetters} from "vuex";

  export default {
    name: "AutoTiresListColumnActions",

    props: ['id', 'linkToSite', 'index'],

    components: {
      AutoTiresPhotoModal: () => import("@/components/autoTires/modal/AutoTiresPhotoModal.vue")
    },

    computed: {
      ...mapGetters('autoTires', [
        'AUTO_TIRES'
      ]),
    },

    methods: {
      ...mapActions('autoTires', [
        'DELET_AUTO_TIRES_BY_API'
      ]),

      getPrintQrCodeAutoParts(qr) {
        let isIframe = window.frames['autoPartsQrCode'];
        isIframe.document.write(qr);
        isIframe.document.close();
      },

      getPhotoAutoParts() {
        this.modalPhotoAdminShow = true;
      },

      closePhotoModalAdmin() {
        this.modalPhotoAdminShow = false;
      },

      autoTiresRemove(id, index) {
        if(confirm("Вы действительно хотите удалить данную шину ?")) {
          let param = {
            autoTiresId: id,
            autoTiresNumber: index
          };

          this.DELET_AUTO_TIRES_BY_API(param);
        }
      },
    },

    data() {
      return {
        DOMAIN,
        modalHistoryAdminShow: false,
        modalPhotoAdminShow: false
      }
    }
  }
</script>

<style lang="scss" scoped>
@import "@/components/autoParts/style/auto-parts-list-column-actions.scss"
</style>