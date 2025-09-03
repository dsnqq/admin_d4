<template>
  <header class="top-header">
    <nav class="navbar navbar-expand gap-3">
      <div class="mobile-toggle-icon fs-3" @click="leftMenuMobileShow">
        <i class="bi bi-list"></i>
      </div>
      <a
        href="https://d4.by/admin/index.php?route=catalog/product"
        class="fs-6 top-header__oldest"
      >
        {{ DICTIONARY.oldVersion }}
      </a>
      <div class="top-navbar-right ms-auto">
        <ul class="navbar-nav align-items-center">
          <li class="nav-item dropdown dropdown-user-setting">
            <a class="nav-link dropdown-toggle dropdown-toggle-nocaret">
              <div class="user-setting d-flex align-items-center">
                {{
                  userInformationAbout.firstname +
                  ' ' +
                  userInformationAbout.lastname
                }}
              </div>
            </a>
          </li>
          <li class="nav-item dropdown dropdown-large">
            <router-link
              :to="{ name: 'orderSale' }"
              class="nav-link dropdown-toggle dropdown-toggle-nocaret"
            >
              <div class="notifications">
                <span v-if="NOTIFICATION > 0" class="notify-badge">
                  {{ NOTIFICATION }}
                </span>
                <i class="bi bi-bell-fill"></i>
              </div>
            </router-link>
          </li>
          <li class="nav-item dropdown dropdown-large">
            <a
              :href="DOMAIN"
              target="_blank"
              class="nav-link dropdown-toggle dropdown-toggle-nocaret"
            >
              <div class="d-flex align-items-center">
                <div class="ms-3">
                  <span>
                    <span class="mobile-hidden">
                      {{ DICTIONARY.goToMain }}
                    </span>
                    <i class="bi bi-house-fill"></i>
                  </span>
                </div>
              </div>
            </a>
          </li>
          <li class="nav-item dropdown dropdown-large">
            <a
              class="nav-link dropdown-toggle dropdown-toggle-nocaret cursor-pointer"
              @click.prevent="logout"
            >
              <div class="d-flex align-items-center">
                <div class="ms-3">
                  <span>
                    <span class="mobile-hidden">{{ DICTIONARY.goBack }}</span>
                    <i class="bi bi-lock-fill"></i>
                  </span>
                </div>
              </div>
            </a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
</template>

<script setup>
import { DICTIONARY } from '@/constants/constants';
import { DOMAIN } from '@/constants/constants';
import { onMounted, computed, defineEmits } from 'vue';
import { useStore } from '@/composables/useStore';

const userInformationAbout = computed(() => JSON.parse(localStorage.user));
const emit = defineEmits(['leftMenuMobileShow']);
const store = useStore();

onMounted(() => {
  NOTIFICATION_FROM_API();
});

const logout = function () {
  localStorage.user = '';
  location.reload();
};

const leftMenuMobileShow = function () {
  emit('leftMenuMobileShow');
};

const NOTIFICATION = computed(() => store.getters['generalStore/NOTIFICATION']);

const NOTIFICATION_FROM_API = (payload) =>
  store.dispatch('generalStore/NOTIFICATION_FROM_API', payload);
</script>

<style lang="scss" scoped>
@import '@/components/style/t-header.scss';
</style>
