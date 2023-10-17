<template>
    <div>
      <component
          @getHistoryAuto="getHistoryAuto"
          @getPhotoAutoParts="getPhotoAutoParts"
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