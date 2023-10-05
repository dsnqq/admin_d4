<template>
    <div>
      <component
          @getHistoryAuto="getHistoryAuto"
          :is="autoPartsAdmin()"
      ></component>
      <AutoPartsHistoryModal
          @closeModalAdmin="closeModalAdmin"
          v-if="modalAdminShow"
      />
    </div>
</template>

<script>
  export default {
    name: "AutoPartsAdmin",

    components: {
      AutoPartsIndex: () => import("./components/AutoPartsIndex.vue"),
      AutoPartsList: () => import("./components/AutoPartsList.vue"),
      AutoPartsHistoryModal: () => import("./components/modal/AutoPartsHistoryModal.vue")
    },

    methods: {
      getHistoryAuto() {
        this.modalAdminShow = true;
      },

      closeModalAdmin() {
        this.modalAdminShow = false;
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
        modalAdminShow: false
      }
    }
  }
</script>