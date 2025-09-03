<template>
  <div class="sidebar-wrapper">
    <div class="sidebar-header">
      <div class="sidebar-header__link">
        <div>
          <img
            :src="`/assets/images/logo-icon.png`"
            class="logo-icon"
            alt="d4.by - logo"
          />
        </div>
        <div>
          <h4 class="logo-text">
            {{ DICTIONARY.logo }}
          </h4>
        </div>
      </div>
      <div
        class="toggle-icon ms-auto desktop-hidden"
        @click="menuSideBarClosed"
      >
        <i class="bi bi-x-lg"></i>
      </div>
    </div>
    <ul id="menu" class="metismenu">
      <li v-for="link in LEFT_MENU" :key="link.index">
        <a
          v-if="checkPermissions(link.permissions)"
          class="cursor-pointer"
          @click.prevent="linkToComponent(link.component)"
        >
          <div class="parent-icon">
            <i class="bi" :class="link.icon"></i>
          </div>
          <div class="menu-title">
            {{ link.title }}
          </div>
        </a>
      </li>
    </ul>
  </div>
</template>

<script setup>
import { DICTIONARY } from '@/constants/constants';
import { LEFT_MENU } from '@/constants/constants';
import { useDevice } from '@/composables/useDevice';
import { unref, defineEmits } from 'vue';
import { useRouter } from '@/composables/useRouter';

const isMobile = useDevice();
const router = useRouter();
const emit = defineEmits(['menuSideBarClosed']);

const menuSideBarClosed = () => {
  emit('menuSideBarClosed');
};

const checkPermissions = (p) =>
  p.includes(parseInt(JSON.parse(localStorage.user).user_id)) || p.length == 0;

const linkToComponent = function (linkComponent) {
  router.push({ name: linkComponent }).catch(() => {});

  if (unref(isMobile)) {
    emit('menuSideBarClosed');
  }
};
</script>

<style lang="scss" scoped>
@import '@/components/style/t-slidebar.scss';
</style>
