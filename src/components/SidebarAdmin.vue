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
        <a href="">
          <div class="parent-icon"><i class="bi bi-house-fill"></i>
          </div>
          <div class="menu-title">Главная панель</div>
        </a>
      </li>
      <li>
        <a href="">
          <div class="parent-icon"><i class="bi bi-basket2-fill"></i>
          </div>
          <div class="menu-title">Мои запчасти</div>
        </a>
      </li>
      <li>
        <a href="">
          <div class="parent-icon"><i class="bi bi-journal-text"></i>
          </div>
          <div class="menu-title">История пользователей</div>
        </a>
      </li>
      <li>
        <a href="">
          <div class="parent-icon"><i class="bi bi-wrench"></i>
          </div>
          <div class="menu-title">Авто в разборе</div>
        </a>
      </li>
      <li>
        <a href="">
          <div class="parent-icon"><i class="bi bi-info-square-fill"></i>
          </div>
          <div class="menu-title">Статистика шин</div>
        </a>
      </li>
      <li>
        <a href="">
          <div class="parent-icon"><i class="bi bi-info-square-fill"></i>
          </div>
          <div class="menu-title">Статистика З/Ч</div>
        </a>
      </li>
      /*
        Добавить запчасть
        Архив Запчастей
        Архив Шин
        Добавить шину
        Мои шины
      */
    </ul>
  </aside>
</template>

<script>
  export default {
    name: "SidebarAdmin",
  }
</script>