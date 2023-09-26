<template>
  <div class="admin-content">
    <PreloaderAdmin />
    <div class="wrapper">
      <HeaderAdmin />
      <SidebarAdmin />

      <main class="page-content">
        <BreadcrumbAdmin />
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
}
</script>