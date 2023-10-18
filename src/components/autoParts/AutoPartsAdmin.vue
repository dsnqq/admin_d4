<template>
    <div>
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
      <iframe name="imgFrame" style="width: 0; height: 0; border: 0;color:#fff;"></iframe>
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
        var frame = window.frames['imgFrame'];
        frame.document.write('<html><head><style>@print{@page :footer {color: #fff }@page :header {color: #fff}}</style></head><body style="font-family: Open Sans, sans-serif;" onload="window.print()"><div style="margin:0 auto;color:#000;display:flex;align-items:center;max-width:275px;border:1px solid #000;"><div><?php echo $img_sm_qr1; ?></div><div style="text-align:center;font-size:12px;margin:0 auto;padding-left:10px;font-weight:bold;line-height:18px;">' + qr + '</div></div></body></html>');
        frame.document.close();
        console.log("Сейчас напечатаем!");
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