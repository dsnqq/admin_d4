<template>
  <Modal @closeModalAdmin="closeHistoryModalAdmin">
    <template #header>История запчасти</template>
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
          <tr v-for="(autoPartsHistory, i) in AUTO_PARTS_HISTORY" :key="i">
            <td data-th="Значение">{{ autoPartsHistory.valueName }}</td>
            <td data-th="Дата изменения">{{ autoPartsHistory.dataChange }}</td>
            <td data-th="Старое значение">
              {{ renderValue(autoPartsHistory.valueOld) }}
            </td>
            <td data-th="Новое значение">
              {{ renderValue(autoPartsHistory.valueNew) }}
            </td>
            <td data-th="Пользователь">
              {{ autoPartsHistory.firstName + ' ' + autoPartsHistory.lastName }}
            </td>
          </tr>
        </tbody>
      </table>
    </template>
  </Modal>
</template>

<script setup>
import { defineAsyncComponent, defineEmits } from 'vue';
import { useStore } from '@/composables/useStore';

const emit = defineEmits(['closeHistoryModalAdmin']);
const store = useStore();
const Modal = defineAsyncComponent(() => import('@/components/UI/BaseModal'));
const AUTO_PARTS_HISTORY = store.getters['autoParts/AUTO_PARTS_HISTORY'];
const renderValue = (data) => {
  if (data === '') return '';

  switch (data) {
    case 1:
      return 'Активно';
    case 0:
      return 'Неактивно';
    default:
      return data;
  }
};
const closeHistoryModalAdmin = () => {
  emit('closeHistoryModalAdmin');
};
</script>

<style lang="scss" scoped>
@import '@/assets/scss/table-adaptive.scss';
</style>
