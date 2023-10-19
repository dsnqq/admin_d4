<template>
  <div class="admin-content">
    <div class="wrapper">
      <HeaderAdmin/>
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
import HeaderAdmin from "@/components/HeaderAdmin.vue";
import SidebarAdmin from "@/components/SidebarAdmin.vue";
import BreadcrumbAdmin from "@/components/BreadcrumbAdmin.vue";
import PreloaderAdmin from "@/components/UI/PreloaderAdmin.vue";

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
          'autoPartsDetail',
          'autoPartsCreate'
      ];

      return (noBreadcrumbAdmin.includes(this.$route.name)) ? false : true;
    }
  }
}
</script>