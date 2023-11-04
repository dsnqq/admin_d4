<template>
  <Modal
      @closeModalAdmin="closeHistoryModalAdmin"
  >
    <template v-slot:header>История запчасти</template>
    <template>
      <table class="table mb-0 table-border-1 rwd-table">
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
            v-for="(autoPartsHistory, i) in AUTO_PARTS_HISTORY"
            :key="i"
        >
          <td data-th="Значение">{{autoPartsHistory.valueName}}</td>
          <td data-th="Дата изменения">{{autoPartsHistory.dataChange}}</td>
          <td data-th="Старое значение">{{renderValue(autoPartsHistory.valueOld)}}</td>
          <td data-th="Новое значение">{{renderValue(autoPartsHistory.valueNew)}}</td>
          <td data-th="Пользователь">{{autoPartsHistory.firstName + " " + autoPartsHistory.lastName}}</td>
        </tr>
        </tbody>
      </table>
    </template>
  </Modal>
</template>

<script>
import {mapGetters} from "vuex";

export default {
  name: "AutoPartsHistoryModal",

  components: {
    Modal: () => import("@/components/UI/BaseModal.vue"),
  },

  computed: {
    ...mapGetters('autoParts', [
      'AUTO_PARTS_HISTORY'
    ]),
  },

  methods: {
    renderValue(data) {
      if(data != ""){
        if(data == 1) {
          return "Активно";
        } else if(data == 0) {
          return "Неактивно";
        }

        return data
      }
      return "";
    },

    closeHistoryModalAdmin() {
      this.$emit('closeHistoryModalAdmin');
    }
  }
}
</script>

<style lang="scss" scoped>
@import "@/assets/scss/table-adaptive.scss";
</style>