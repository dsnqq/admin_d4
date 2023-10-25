<template>
  <div id="app">
    <TheAdminContent v-if="loginUserChecked"/>
    <AuthAdmin v-else/>
  </div>
</template>

<script>
import AuthAdmin from "@/components/authAdmin/AuthAdmin.vue";
import TheAdminContent from "@/components/TheAdminContent.vue";

export default {
  name: 'App',

  computed: {
    loginUserChecked() {
      if(!localStorage.user) return false;
      let user = JSON.parse(localStorage.user);
      return user.user_id;
    }
  },

  components: {
    TheAdminContent,
    AuthAdmin
  }
}
</script>

<style>
@import "../src/assets/css/bootstrap.min.css";
@import "../src/assets/css/bootstrap-extended.css";
@import "../src/assets/css/style.css";
@import "../src/assets/css/icons.css";
</style>

<style lang="scss">
@import "../src/assets/scss/style.scss";
</style>