<template>
  <header class="top-header">
    <nav class="navbar navbar-expand gap-3">
      <div
          @click="leftMenuMobileShow"
          class="mobile-toggle-icon fs-3"
      >
        <i class="bi bi-list"></i>
      </div>
      <a href="https://d4.by/admin" class="fs-6 top-header__oldest">
        Старая версия
      </a>
      <div class="top-navbar-right ms-auto">
        <ul class="navbar-nav align-items-center">
          <li class="nav-item dropdown dropdown-user-setting">
            <a class="nav-link dropdown-toggle dropdown-toggle-nocaret">
              <div class="user-setting d-flex align-items-center">
                {{ userInformationAbout.firstname + ' ' + userInformationAbout.lastname}}
              </div>
            </a>
          </li>
          <li class="nav-item dropdown dropdown-large">
            <router-link
                :to="{name: 'orderSale'}"
                class="nav-link dropdown-toggle dropdown-toggle-nocaret"
            >
              <div class="notifications">
                <span
                    v-if="NOTIFICATION > 0"
                    class="notify-badge"
                >
                  {{NOTIFICATION}}
                </span>
                <i class="bi bi-bell-fill"></i>
              </div>
            </router-link>
          </li>
          <li class="nav-item dropdown dropdown-large">
              <a
                  :href="domain"
                  target="_blank"
                  class="nav-link dropdown-toggle dropdown-toggle-nocaret"
              >
                <div class="d-flex align-items-center">
                  <div class="ms-3">
                    <span>
                      <span class="mobile-hidden">На главную d4.by</span>
                      <i class="bi bi-house-fill"></i>
                    </span>
                  </div>
                </div>
              </a>
          </li>
          <li class="nav-item dropdown dropdown-large">
            <a
                @click.prevent="logout"
                class="nav-link dropdown-toggle dropdown-toggle-nocaret cursor-pointer"
            >
              <div class="d-flex align-items-center">
                <div class="ms-3">
                  <span>
                    <span class="mobile-hidden">Выйти</span>
                    <i class="bi bi-lock-fill"></i>
                  </span>
                </div>
              </div>
            </a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
</template>

<script>
  import {mapActions, mapGetters} from "vuex";
  import {DOMAIN} from "@/constants/constants";

  export default {
    name: "HeaderAdmin",

    mounted() {
      this.NOTIFICATION_FROM_API();
    },

    computed: {
      userInformationAbout() {
        return JSON.parse(localStorage.user);
      },

      ...mapGetters('generalStore', [
        'NOTIFICATION',
      ]),
    },

    methods: {
      ...mapActions('generalStore', [
        'NOTIFICATION_FROM_API',
      ]),

      logout() {
        localStorage.user = '';
        location.reload();
      },

      leftMenuMobileShow (){
        this.menu = !this.menu;
        this.$emit('leftMenuMobileShow', this.menu);
      }
    },

    data() {
      return {
        domain: DOMAIN,
        menu: false,
      }
    }
  }
</script>

<style lang="scss" scoped>
@import "@/components/style/header-admin.scss";
</style>