<template>
  <Modal
      @closeModalAdmin="closeModalAdmin"
  >
    <table class="table mb-0 table-border-1">
      <thead>
      <tr>
        <th scope="col">Значение</th>
        <th scope="col">Дата изменения</th>
        <th scope="col">Старое значение</th>
        <th scope="col">Новое значение</th>
        <th scope="col">Пользователь</th>
      </tr>
      </thead>
      <tbody>
      <tr
          v-for="(autoPartsHistory, i) in AUTO_PARTS_ARCHIVE_HISTORY"
          :key="i"
      >
        <td>{{autoPartsHistory.valueName}}</td>
        <td>{{autoPartsHistory.dataChange}}</td>
        <td>{{autoPartsHistory.valueOld}}</td>
        <td>{{autoPartsHistory.valueNew}}</td>
        <td>{{autoPartsHistory.firstName + autoPartsHistory.lastName}}</td>
      </tr>
      </tbody>
    </table>
  </Modal>
</template>

<script>
  import {mapGetters} from "vuex";

  export default {
    name: "AutoPartsHistoryModal",

    components: {
      Modal: () => import("@/components/UI/VModal.vue"),
    },

    computed: {
      ...mapGetters('autoPartsArchive', [
        'AUTO_PARTS_ARCHIVE_HISTORY'
      ]),
    },

    methods: {
      closeModalAdmin() {
        this.$emit('closeModalAdmin');
      }
    }
  }
</script>