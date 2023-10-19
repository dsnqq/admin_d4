<template>
  <header class="top-header">
    <nav class="navbar navbar-expand gap-3">
      <div class="mobile-toggle-icon fs-3">
        <i class="bi bi-list"></i>
      </div>
      <!---
      <form class="searchbar">
        <div class="position-absolute top-50 translate-middle-y search-icon ms-3"><i class="bi bi-search"></i></div>
        <input class="form-control" type="text" placeholder="Здесь можно что-нибудь найти...">
        <div class="position-absolute top-50 translate-middle-y search-close-icon"><i class="bi bi-x-lg"></i></div>
      </form>--->
      <a href="https://d4.by/admin" class="fs-6">
        Перейти в старую админ-панель
      </a>
      <div class="top-navbar-right ms-auto">
        <ul class="navbar-nav align-items-center">
          <li class="nav-item search-toggle-icon">
            <a class="nav-link" href="#">
              <div class="">
                <i class="bi bi-search"></i>
              </div>
            </a>
          </li>
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
                      На главную d4.by
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
                    Выйти
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
      }
    },

    data() {
      return {
        domain: DOMAIN
      }
    }
  }
</script>