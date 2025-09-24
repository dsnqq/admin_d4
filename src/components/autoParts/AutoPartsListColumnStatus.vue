<template>
  <span
    class="badge rounded-pill cursor-pointer"
    :class="statusClasses"
    @click="changeStatus(id, status, index)"
  >
    {{ getStatus(status) }}
  </span>
</template>
<script setup>
import { computed, defineProps } from 'vue';
import { useStore } from '@/composables/useStore';

const props = defineProps({
  id: {
    type: [Number, String],
    default: 0,
  },
  status: {
    type: [Number, String, Boolean],
    default: false,
  },
  index: {
    type: [Number, String],
    default: 0,
  },
});

const store = useStore();
const statusClasses = computed(() =>
  props.status == 1 ? 'alert-success' : 'alert-danger',
);

const getStatus = (status) => (status == 1 ? 'Активно' : 'Неактивно');

const changeStatus = (id, status, i) => {
  store.dispatch('autoParts/CHANGE_AUTO_PARTS_STATUS', {
    id: id,
    status: status,
    index: i,
  });
};
</script>
