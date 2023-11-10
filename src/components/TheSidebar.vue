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
        <h4 class="logo-text">
          {{DICTIONARY.logo}}
        </h4>
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
          v-for="link in LEFT_MENU"
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
  import {DICTIONARY} from "@/constants/constants";
  import {LEFT_MENU} from "@/constants/constants";
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
        LEFT_MENU,
        DICTIONARY
      }
    }
  }
</script>

<style lang="scss" scoped>
@import "@/components/style/t-slidebar.scss";
</style>
