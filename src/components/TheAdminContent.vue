<template>
  <div class="admin-content">
    <div :class="adminContentMenuToggled" class="wrapper">
      <TheHeader @leftMenuMobileShow="leftMenuMobileShow" />
      <TheSidebar @menuSideBarClosed="menuSideBarClosed" />

      <main class="page-content">
        <Preloader />
        <Breadcrumb v-if="getBreadcrumbBool" />
        <router-view></router-view>
      </main>
      <transition name="fade">
        <div v-if="buttonShow" class="btn-up" @click="arrowButtonGoTop">
          <i class="bi bi-arrow-up-short"></i>
        </div>
      </transition>
    </div>
  </div>
</template>

<script setup>
import { DISENABLE_BREADCRUMB } from '@/constants/constants';
import TheHeader from '@/components/TheHeader.vue';
import TheSidebar from '@/components/TheSidebar.vue';
import Breadcrumb from '@/components/UI/BaseBreadcrumb.vue';
import Preloader from '@/components/UI/BasePreloader.vue';
import { ref, computed, defineEmits, onMounted, watch } from 'vue';
import { useRoute } from '@/composables/useRoute';

const buttonShow = ref(false);
const menu = ref(false);

const emit = defineEmits(['leftMenuMobileShow', 'menuSideBarClosed']);

const route = useRoute();

const adminContentMenuToggled = computed(() => (menu.value ? 'toggled' : ''));

const getBreadcrumbBool = computed(() =>
  DISENABLE_BREADCRUMB.includes(route.name) ? false : true,
);

const checkScrollPosition = () => {
  buttonShow.value = window.pageYOffset > 200;
};

const menuSideBarClosed = function () {
  emit('menuSideBarClosed');
};

const leftMenuMobileShow = function () {
  emit('leftMenuMobileShow');
};

const arrowButtonGoTop = function () {
  window.scroll({
    top: 0,
    behavior: 'smooth',
  });
};

onMounted(() => {
  checkScrollPosition();
  window.addEventListener('scroll', checkScrollPosition);
});

watch(route, () => {
  menu.value = false;
});
</script>

<style lang="scss" scoped>
@import '@/components/style/t-admin.scss';
</style>
