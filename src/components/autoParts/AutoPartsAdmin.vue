<template>
    <div class="auto-parts-admin">
      <component
          @getHistoryAuto="getHistoryAuto"
          @getPhotoAutoParts="getPhotoAutoParts"
          @getPrintQrCodeAutoParts="getPrintQrCodeAutoParts"
          :is="autoPartsAdmin()"
      ></component>
      <AutoPartsHistoryModal
          @closeHistoryModalAdmin="closeHistoryModalAdmin"
          v-if="modalHistoryAdminShow"
      />
      <AutoPartsPhotoModal
          @closePhotoModalAdmin="closePhotoModalAdmin"
          v-if="modalPhotoAdminShow"
      />
      <iframe name="autoPartsQrCode" class="auto-parts-admin__iframe"></iframe>
    </div>
</template>

<script>
  export default {
    name: "AutoPartsAdmin",

    components: {
      AutoPartsIndex: () => import("./components/AutoPartsIndex.vue"),
      AutoPartsList: () => import("./components/AutoPartsList.vue"),
      AutoPartsHistoryModal: () => import("./components/modal/AutoPartsHistoryModal.vue"),
      AutoPartsPhotoModal: () => import("./components/modal/AutoPartsPhotoModal.vue")
    },

    methods: {
      getPrintQrCodeAutoParts(qr) {
        let isIframe = window.frames['autoPartsQrCode'];
        isIframe.document.write(qr);
        isIframe.document.close();
      },

      getHistoryAuto() {
        this.modalHistoryAdminShow = true;
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

      autoPartsAdmin() {
        if(this.$route.name === "autoPartsDetail"){
          return 'AutoPartsIndex';
        }

        return 'AutoPartsList';
      }
    },

    data() {
      return {
        modalHistoryAdminShow: false,
        modalPhotoAdminShow: false
      }
    }
  }
</script>

<style lang="scss" scoped>
@import "@/components/autoParts/style/auto-parts-admin.scss"
</style>