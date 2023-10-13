<template>
  <div id="app">
    <AdminContent
      v-if="login"
    />
    <AuthAdmin
        @setLoginTrue="setLoginTrue"
        v-else
    />
  </div>
</template>

<script>
import AdminContent from "@/components/AdminContent.vue";
import AuthAdmin from "@/components/authAdmin/AuthAdmin.vue";

export default {
  name: 'App',

  components: {
    AdminContent,
    AuthAdmin,
  },

  mounted() {
    if(localStorage.login) {
      this.login = localStorage.login;
    }
  },

  methods: {
    setLoginTrue() {
      this.login = true;
      localStorage.login = this.login;
    },
  },

  data() {
    return {
      login: localStorage.login
    }
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