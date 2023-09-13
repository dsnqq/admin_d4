<template>
  <div id="app">
    <div class="wrapper">
      <HeaderAdmin />
      <SidebarAdmin />

      <main class="page-content">
        <BreadcrumbAdmin />
        <component :is="getContent()" />
      </main>
    </div>
  </div>
</template>

<script>
import HeaderAdmin from "./components/HeaderAdmin.vue";
import SidebarAdmin from "./components/SidebarAdmin.vue";
import BreadcrumbAdmin from "./components/BreadcrumbAdmin.vue";

export default {
  name: 'App',

  components: {
    HeaderAdmin,
    SidebarAdmin,
    BreadcrumbAdmin,
    AutoPartsAdmin : () => import("./components/autoParts/AutoPartsAdmin.vue"),
    DashboardAdmin : () => import("./components/dashboardAdmin/DashboardAdmin.vue"),
  },

  methods: {
    getContent() {
      return "DashboardAdmin";
    }
  }
}
</script>