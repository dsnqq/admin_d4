<template>
  <aside class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
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
    </div>
    <ul class="metismenu" id="menu">
      <li
          v-for="link in links"
          :key="link.index"
      >
        <router-link :to="{name: link.component}">
          <div class="parent-icon">
            <i
                class="bi"
                :class="link.icon"
            ></i>
          </div>
          <div class="menu-title">
            {{ link.title }}
          </div>
        </router-link>
      </li>
    </ul>
  </aside>
</template>

<script>
  export default {
    name: "SidebarAdmin",

    data() {
      return {
        links: [
          {title: 'Главная панель', component: 'dashboardAdmin', icon: 'bi-house-fill'},
          {title: 'Мои запчасти', component: 'autoParts', icon: 'bi-basket2-fill'},
          {title: 'Архив Запчастей', component: 'autoPartsArchive', icon: 'bi-archive'},
          {title: 'Добавить запчасть', component: 'autoPartsCreate', icon: 'bi-plus-square'},
          {title: 'История пользователей', component: 'historyUsers', icon: 'bi-journal-text'},
          {title: 'Авто в разборе', component: 'carsAdmin', icon: 'bi-wrench'},
          {title: 'Мои шины', component: 'autoTires', icon: 'bi-vinyl'},
          {title: 'Архив Шин', component: 'autoTiresArchive', icon: 'bi-archive'},
          {title: 'Добавить шину', component: '', icon: 'bi-plus-square'},
          {title: 'Статистика шин', component: 'tireStatistics', icon: 'bi-info-square-fill'},
          {title: 'Статистика З/Ч', component: 'sparePartsStatistics', icon: 'bi-info-square-fill'},
        ]
      }
    }
  }
</script>