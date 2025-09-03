<template>
  <div class="auto-parts-archive-list-column-actions">
    <div class="d-flex align-items-center justify-content-center gap-2 fs-6">
      <a class="text-primary cursor-pointer" @click="getHistoryAuto(id)">
        <i class="bi bi-archive"></i>
      </a>
      <a
        class="text-success cursor-pointer"
        @click.prevent="autoPartsRestore(id, index)"
      >
        <i class="bi bi-arrow-clockwise"></i>
      </a>
    </div>
    <AutoPartsHistoryModal
      v-if="modalHistoryAdminShow"
      @closeHistoryModalAdmin="closeHistoryModalAdmin"
    />
  </div>
</template>

<script>
import { DOMAIN } from '@/constants/constants';
import { mapActions, mapGetters } from 'vuex';

export default {
  name: 'AutoPartsArchiveListColumnActions',

  components: {
    AutoPartsHistoryModal: () =>
      import(
        '@/components/autoPartsArchive/modal/AutoPartsArchiveHistoryModal.vue'
      ),
  },

  props: ['id', 'index'],

  computed: {
    ...mapGetters('autoPartsArchive', ['AUTO_PARTS_ARCHIVE']),
  },

  methods: {
    ...mapActions('autoPartsArchive', [
      'GET_AUTO_PARTS_ARCHIVE_HISTORY',
      'RESTORE_AUTO_PARTS_ARCHIVE_BY_API',
    ]),

    closeHistoryModalAdmin() {
      this.modalHistoryAdminShow = false;
    },

    getHistoryAuto(id) {
      this.modalHistoryAdminShow = true;
      this.GET_AUTO_PARTS_ARCHIVE_HISTORY(id);
    },

    autoPartsRestore(id, index) {
      if (confirm('Вы действительно хотите восстановить данную запчасть ?')) {
        let param = {
          autoPartsId: id,
          autoPartsNumber: index,
        };

        this.RESTORE_AUTO_PARTS_ARCHIVE_BY_API(param);
      }
    },
  },

  data() {
    return {
      DOMAIN,
      modalHistoryAdminShow: false,
    };
  },
};
</script>
