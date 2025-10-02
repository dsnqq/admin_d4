<template>
  <div class="modal-mask">
    <div class="modal-wrapper">
      <div class="modal-container">
        <div class="modal-header">
          <h4 class="modal-title">
            <slot name="header"></slot>
          </h4>
          <button
            type="button"
            class="modal-header__close close"
            data-dismiss="modal"
            @click.prevent="closeModalAdmin"
          >
            ×
          </button>
        </div>
        <div class="modal-body">
          <slot></slot>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { defineEmits } from 'vue';

const emit = defineEmits(['closeModalAdmin']);
const closeModalAdmin = () => {
  emit('closeModalAdmin');
};
</script>

<style lang="scss" scoped>
@import './src/components/UI/style/base-modal';
</style>
