<template>
  <div>
    {{ contentFull }}
  </div>
</template>

<script setup>
import { defineProps, computed } from 'vue';

const props = defineProps({
  content: {
    type: String,
    default: '',
  },
  contentExtension: {
    type: String,
    default: '',
  },
});

const contentFull = computed(() =>
  props.contentExtension
    ? `${props.content} ${props.contentExtension}`
    : props.content,
);
</script>
