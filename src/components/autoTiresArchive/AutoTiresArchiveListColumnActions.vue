<template>
  <div class="auto-tires-archive-list-column-actions">
    <div class="d-flex align-items-center justify-content-center gap-2 fs-6">
      <a
        class="text-success cursor-pointer"
        @click.prevent="autoTiresRestore(id, index)"
      >
        <i class="bi bi-arrow-clockwise"></i>
      </a>
    </div>
  </div>
</template>

<script setup>
import { defineProps } from 'vue';
import { useStore } from '@/composables/useStore';

const store = useStore();

defineProps({
  id: {
    type: [Number, String],
    default: 0,
  },
  index: {
    type: [Number, String],
    default: 0,
  },
});

const autoTiresRestore = (id, index) => {
  if (confirm('Вы действительно хотите восстановить данное объявление ?')) {
    store.dispatch('autoTiresArchive/RESTORE_AUTO_TIRES_ARCHIVE_BY_API', {
      autoTiresId: id,
      autoTiresNumber: index,
    });
  }
};
</script>
