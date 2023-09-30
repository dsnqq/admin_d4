<template>
  <header class="top-header">
    <nav class="navbar navbar-expand gap-3">
      <div class="mobile-toggle-icon fs-3">
        <i class="bi bi-list"></i>
      </div>
      <form class="searchbar">
        <div class="position-absolute top-50 translate-middle-y search-icon ms-3"><i class="bi bi-search"></i></div>
        <input class="form-control" type="text" placeholder="Здесь можно что-нибудь найти...">
        <div class="position-absolute top-50 translate-middle-y search-close-icon"><i class="bi bi-x-lg"></i></div>
      </form>
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
                Даниил Разработчик
              </div>
            </a>
          </li>
          <li class="nav-item dropdown dropdown-large">
            <a class="nav-link dropdown-toggle dropdown-toggle-nocaret">
              <div class="notifications">
                <span class="notify-badge">8</span>
                <i class="bi bi-bell-fill"></i>
              </div>
            </a>
          </li>
          <li class="nav-item dropdown dropdown-large">
            <a class="nav-link dropdown-toggle dropdown-toggle-nocaret">
              <div class="d-flex align-items-center">
                <div class="ms-3">
                  <span>
                    На главную
                    <i class="bi bi-house-fill"></i>
                  </span>
                </div>
              </div>
            </a>
          </li>
          <li class="nav-item dropdown dropdown-large">
            <a class="nav-link dropdown-toggle dropdown-toggle-nocaret">
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
  export default {
    name: "HeaderAdmin",
  }
</script>