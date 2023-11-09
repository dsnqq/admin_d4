<template>
  <div class="auto-tires-archive-list-column-actions">
    <div class="d-flex align-items-center justify-content-center gap-2 fs-6">
      <a
          @click.prevent="autoTiresRestore(id, index)"
          class="text-success cursor-pointer"
      >
        <i class="bi bi-arrow-clockwise"></i>
      </a>
    </div>
  </div>
</template>

<script>
import {DOMAIN} from "@/constants/constants";
import {mapActions, mapGetters} from "vuex";

export default {
  name: "AutoTiresArchiveListColumnActions",

  props: ['id', 'index'],

  computed: {
    ...mapGetters('autoTiresArchive', [
      'AUTO_TIRES_ARCHIVE'
    ]),
  },

  methods: {
    ...mapActions('autoTiresArchive', [
      'RESTORE_AUTO_TIRES_ARCHIVE_BY_API'
    ]),

    autoTiresRestore(id, index) {
      if(confirm("Вы действительно хотите восстановить данное объявление ?")) {
        let param = {
          autoTiresId: id,
          autoTiresNumber: index
        };

        this.RESTORE_AUTO_TIRES_ARCHIVE_BY_API(param);
      }
    },
  },

  data() {
    return {
      DOMAIN,
      modalHistoryAdminShow: false
    }
  }
}
</script>