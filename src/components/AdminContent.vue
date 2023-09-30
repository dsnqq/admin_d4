<template>
  <div class="admin-content">
    <div class="wrapper">
      <HeaderAdmin />
      <SidebarAdmin />

      <main class="page-content">
        <PreloaderAdmin />
        <BreadcrumbAdmin
            v-if="getBreadcrumbBool"
        />
        <router-view></router-view>
      </main>
    </div>
  </div>
</template>

<script>
import HeaderAdmin from "./HeaderAdmin.vue";
import SidebarAdmin from "./SidebarAdmin.vue";
import BreadcrumbAdmin from "./BreadcrumbAdmin.vue";
import PreloaderAdmin from "./UI/PreloaderAdmin.vue";

export default {
  name: 'AdminContent',

  components: {
    HeaderAdmin,
    SidebarAdmin,
    BreadcrumbAdmin,
    PreloaderAdmin,
  },

  computed: {
    getBreadcrumbBool() {
      let noBreadcrumbAdmin = [
          'historyUsersIndex',
          'carsAdmin',
          'carDetail',
          'carCreate',
          'autoPartsDetail'
      ];

      return (noBreadcrumbAdmin.includes(this.$route.name)) ? false : true;
    }
  }
}
</script>