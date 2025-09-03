<template>
  <span
    class="badge rounded-pill cursor-pointer"
    :class="status == 1 ? 'alert-success' : 'alert-danger'"
    @click="changeStatus(id, status, index)"
  >
    {{ getStatus(status) }}
  </span>
</template>
<script>
import { mapActions } from 'vuex';

export default {
  name: 'AutoPartsListColumnStatus',

  props: ['id', 'status', 'index'],

  methods: {
    ...mapActions('autoParts', ['CHANGE_AUTO_PARTS_STATUS']),

    getStatus(status) {
      return status == 1 ? 'Активно' : 'Неактивно';
    },

    changeStatus(id, status, i) {
      let param = {
        id: id,
        status: status,
        index: i,
      };

      this.CHANGE_AUTO_PARTS_STATUS(param);
    },
  },
};
</script>
