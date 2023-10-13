<template>
  <div>
      <component
          @getHistoryAuto="getHistoryAuto"
          :is="autoPartsArchive()"
      ></component>
      <AutoPartsArchiveHistoryModal
          @closeModalAdmin="closeModalAdmin"
          v-if="modalAdminShow"
      />
  </div>
</template>

<script>
export default {
  name: "AutoPartsArchive",

  components: {
    AutoPartsArchiveList: () => import("@/components/autoPartsArchive/components/AutoPartsArchiveList.vue"),
    AutoPartsArchiveHistoryModal: () => import("@/components/autoPartsArchive/components/modal/AutoPartsArchiveHistoryModal.vue")
  },

  methods: {
    getHistoryAuto() {
      this.modalAdminShow = true;
    },

    closeModalAdmin() {
      this.modalAdminShow = false;
    },

    autoPartsArchive() {
      if(this.$route.name === "autoPartsDetail"){
        return 'AutoPartsIndex';
      }

      return 'AutoPartsArchiveList';
    }
  },

  data() {
    return {
      modalAdminShow: false
    }
  }
}
</script>