<template>
  <aside class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
      <div>
        <img src="assets/images/logo-icon.png" class="logo-icon" alt="logo icon">
      </div>
      <div>
        <h4 class="logo-text">D4.by</h4>
      </div>
    </div>
    <ul class="metismenu" id="menu">
      <li>
        <router-link :to="{name: 'dashboardAdmin'}">
          <div class="parent-icon"><i class="bi bi-house-fill"></i>
          </div>
          <div class="menu-title">Главная панель</div>
        </router-link>
      </li>
      <li>
        <router-link :to="{name: 'autoParts'}">
          <div class="parent-icon"><i class="bi bi-basket2-fill"></i>
          </div>
          <div class="menu-title">Мои запчасти</div>
        </router-link>
      </li>
      <li>
        <router-link :to="{name: 'historyUsers'}">
          <div class="parent-icon"><i class="bi bi-journal-text"></i>
          </div>
          <div class="menu-title">История пользователей</div>
        </router-link>
      </li>
      <li>
        <router-link :to="{name: 'carsAdmin'}">
          <div class="parent-icon"><i class="bi bi-wrench"></i>
          </div>
          <div class="menu-title">Авто в разборе</div>
        </router-link>
      </li>
      <li>
        <router-link :to="{name: 'tireStatistics'}">
          <div class="parent-icon"><i class="bi bi-info-square-fill"></i>
          </div>
          <div class="menu-title">Статистика шин</div>
        </router-link>
      </li>
      <li>
        <router-link :to="{name: 'sparePartsStatistics'}">
          <div class="parent-icon"><i class="bi bi-info-square-fill"></i>
          </div>
          <div class="menu-title">Статистика З/Ч</div>
        </router-link>
      </li>
      <!--
        Добавить запчасть
        Архив Запчастей
        Архив Шин
        Добавить шину
        Мои шины
      -->
    </ul>
  </aside>
</template>

<script>
  export default {
    name: "SidebarAdmin",
  }
</script>