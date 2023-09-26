<template>
  <div id="app">
    <AdminContent
      v-if="login"
    />
    <AuthAdmin
        v-else
    />
  </div>
</template>

<script>
import AdminContent from "./components/AdminContent.vue";
import AuthAdmin from "./components/authAdmin/AuthAdmin.vue";

export default {
  name: 'App',

  components: {
    AdminContent,
    AuthAdmin,
  },

  computed: {
    isUserLogin: function () {
      return false;
    }
  },

  data() {
    return {
      login: false
    }
  }
}
</script>

<style>
@import "../src/assets/css/bootstrap.min.css";
@import "../src/assets/css/bootstrap-extended.css";
@import "../src/assets/css/style.css";
@import "../src/assets/css/icons.css";
@import "../src/assets/scss/style.scss";
</style>