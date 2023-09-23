<template>
  <div id="app">
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
import HeaderAdmin from "./components/HeaderAdmin.vue";
import SidebarAdmin from "./components/SidebarAdmin.vue";
import BreadcrumbAdmin from "./components/BreadcrumbAdmin.vue";
import PreloaderAdmin from "./components/UI/PreloaderAdmin.vue";

export default {
  name: 'App',

  components: {
    HeaderAdmin,
    SidebarAdmin,
    BreadcrumbAdmin,
    PreloaderAdmin,
  },
}
</script>

<style>
@import "../src/assets/css/bootstrap.min.css";
@import "../src/assets/css/bootstrap-extended.css";
@import "../src/assets/css/style.css";
@import "../src/assets/css/icons.css";
</style>