<template>
  <div>
    {{ content }}
    <div v-if="theNoteRenderOnPage" class="text-danger">
      <strong>Заметка: </strong>
      {{ contentTheNote }}
    </div>
  </div>
</template>

<script setup>
import { defineProps, computed } from 'vue';

const props = defineProps({
  content: {
    type: String,
    default: '',
  },
  contentTheNote: {
    type: String,
    default: '',
  },
});

const theNoteRenderOnPage = computed(() => !!props.contentTheNote);
</script>
