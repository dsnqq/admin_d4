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
      menu: false
    }
  }
}
</script>

<style lang="scss" scoped>
@import "@/components/style/admin-content.scss";
</style>