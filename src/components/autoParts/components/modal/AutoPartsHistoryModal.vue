<template>
  <ModalAdmin
      @closeModalAdmin="closeHistoryModalAdmin"
  >
    <template v-slot:header>История запчасти</template>
    <template>
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
            v-for="(autoPartsHistory, i) in AUTO_PARTS_HISTORY"
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
    </template>
  </ModalAdmin>
</template>

<script>
  import {mapGetters} from "vuex";

  export default {
    name: "AutoPartsHistoryModal",

    components: {
      ModalAdmin: () => import("@/components/UI/ModalAdmin.vue"),
    },

    computed: {
      ...mapGetters('autoParts', [
        'AUTO_PARTS_HISTORY'
      ]),
    },

    methods: {
      closeHistoryModalAdmin() {
        this.$emit('closeHistoryModalAdmin');
      }
    }
  }
</script>