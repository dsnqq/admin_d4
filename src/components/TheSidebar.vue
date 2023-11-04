<template>
  <aside class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
      <router-link
          class="sidebar-header__link"
          :to="{name: 'dashboardAdmin'}"
      >
      <div>
        <img
            :src="`/assets/images/logo-icon.png`"
            class="logo-icon"
            alt="d4.by - logo"
        />
      </div>
      <div>
        <h4 class="logo-text">D4.by</h4>
      </div>
      </router-link>
      <div
          @click="menuSideBarClosed"
          class="toggle-icon ms-auto desktop-hidden"
      >
        <i class="bi bi-x-lg"></i>
      </div>
    </div>
    <ul class="metismenu" id="menu">
      <li
          v-for="link in links"
          :key="link.index"
      >
        <a
           v-if="checkPermissions(link.permissions)"
           @click.prevent="linkToComponent(link.component)"
           class="cursor-pointer"
        >
          <div class="parent-icon">
            <i
                class="bi"
                :class="link.icon"
            ></i>
          </div>
          <div class="menu-title">
            {{ link.title }}
          </div>
        </a>
      </li>
    </ul>
  </aside>
</template>

<script>
  import {mixins} from "@/mixins/mixins";

  export default {
    name: "TheSidebar",

    mixins: [mixins],

    methods: {
      menuSideBarClosed() {
        this.$emit("menuSideBarClosed");
      },

      checkPermissions(p) {
        return p.includes(parseInt(JSON.parse(localStorage.user).user_id)) || p.length == 0;
      },

      linkToComponent(linkComponent) {
        this.$router.push({ name: linkComponent }).catch(()=>{});
        if(this.isMobile) {
          this.$emit("menuSideBarClosed");
        }
      }
    },

    data() {
      return {
        links: [
          {title: 'Главная панель', component: 'dashboardAdmin', icon: 'bi-house-fill', permissions: []},
          {title: 'Мои запчасти', component: 'autoParts', icon: 'bi-basket2-fill', permissions: []},
          {title: 'Архив Запчастей', component: 'autoPartsArchive', icon: 'bi-archive', permissions: []},
          {title: 'Добавить запчасть', component: 'autoPartsCreate', icon: 'bi-plus-square', permissions: []},
          {title: 'История пользователей', component: 'historyUsers', icon: 'bi-journal-text', permissions: [7,8,22,2]},
          {title: 'Авто в разборе', component: 'carsAdmin', icon: 'bi-wrench', permissions: []},
          {title: 'Добавить авто в разборе', component: 'carCreate', icon: 'bi-wrench', permissions: []},
          {title: 'Мои шины', component: 'autoTires', icon: 'bi-vinyl', permissions: []},
          {title: 'Архив Шин', component: 'autoTiresArchive', icon: 'bi-archive', permissions: []},
          {title: 'Добавить шину', component: 'autoTiresCreate', icon: 'bi-plus-square', permissions: [7,8,22,2]},
          {title: 'Статистика шин', component: 'tireStatistics', icon: 'bi-info-square-fill', permissions: [7,8,22,2]},
          {title: 'Статистика З/Ч', component: 'sparePartsStatistics', icon: 'bi-info-square-fill', permissions: [7,8,22,2]},
        ]
      }
    }
  }
</script>

<style lang="scss" scoped>
@import "@/components/style/sidebar-admin.scss";
</style>
