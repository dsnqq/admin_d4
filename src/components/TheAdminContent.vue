<template>
  <div class="admin-content">
    <div
        :class="{'toggled' : this.menu}"
        class="wrapper"
    >
      <TheHeader
          @leftMenuMobileShow="leftMenuMobileShow"
      />
      <TheSidebar
        @menuSideBarClosed="menuSideBarClosed"
      />

      <main class="page-content">
        <Preloader />
        <Breadcrumb
            v-if="getBreadcrumbBool"
        />
        <router-view></router-view>
      </main>
      <transition name="fade">
        <div
          v-if="buttonShow"
          @click="arrowButtonGoTop"
          class="btn-up"
        >
          <i class="bi bi-arrow-up-short"></i>
        </div>
      </transition>
    </div>
  </div>
</template>

<script>
import TheHeader from "@/components/TheHeader.vue";
import TheSidebar from "@/components/TheSidebar.vue";
import Breadcrumb from "@/components/UI/BaseBreadcrumb.vue";
import Preloader from "@/components/UI/BasePreloader.vue";

export default {
  name: 'TheAdminContent',

  mounted: function () {
    this.checkScrollPosition();
    window.addEventListener('scroll', this.checkScrollPosition);
  },

  components: {
    TheHeader,
    TheSidebar,
    Breadcrumb,
    Preloader,
  },

  computed: {
    getBreadcrumbBool() {
      let noBreadcrumbAdmin = [
          'historyUsersIndex',
          'carDetail',
          'carCreate',
          'autoPartsDetail',
          'autoPartsCreate',
          'autoTiresDetail',
          'dashboardAdmin'
      ];

      return (noBreadcrumbAdmin.includes(this.$route.name)) ? false : true;
    }
  },

  methods: {
    checkScrollPosition() {
      this.buttonShow = window.pageYOffset > 200;
    },

    arrowButtonGoTop() {
      scroll({
        top: 0,
        behavior: "smooth"
      });
    },

    leftMenuMobileShow(menu) {
      this.menu = menu;
    },

    menuSideBarClosed(){
      this.menu = !this.menu;
    }
  },

  watch: {
    '$route' () {
      this.menu = false;
    }
  },

  data() {
    return {
      buttonShow: false,
      menu: false
    }
  }
}
</script>

<style lang="scss" scoped>
@import "@/components/style/admin-content.scss";
</style>
