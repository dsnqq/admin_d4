<template>
  <div id="app">
    <TheAdminContent v-if="loginUserChecked" />
    <AuthAdmin v-else />
  </div>
</template>

<script setup>
import AuthAdmin from '@/components/authAdmin/AuthAdmin.vue';
import TheAdminContent from '@/components/TheAdminContent.vue';
import { computed } from 'vue';

const loginUserChecked = computed(() => {
  if (!localStorage.user) return false;
  try {
    const user = JSON.parse(localStorage.user);
    return Boolean(user && user.user_id);
  } catch (e) {
    return false;
  }
});
</script>

<style>
@import '../src/assets/css/bootstrap.min.css';
@import '../src/assets/css/bootstrap-extended.css';
@import '../src/assets/css/style.css';
@import '../src/assets/css/icons.css';
</style>

<style lang="scss">
@import '../src/assets/scss/style.scss';
</style>
