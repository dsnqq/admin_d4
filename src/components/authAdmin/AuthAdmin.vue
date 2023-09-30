<template>
  <div class="wrapper">
    <main class="authentication-content">
      <div class="container-fluid">
        <div class="authentication-card">
          <div class="card shadow rounded-0 overflow-hidden">
            <div class="row g-0">
              <div class="col-lg-6 bg-login d-flex align-items-center justify-content-center">
                <img src="/assets/images/login-img.jpg" class="img-fluid" alt="">
              </div>
              <div class="col-lg-6">
                <div class="card-body p-4 p-sm-5">
                  <h5 class="card-title">Вход</h5>
                  <p class="card-text">Для использования системы - авторизуйтесь!</p>
                  <hr>
                  <form class="form-body">
                    <div class="row g-3">
                      <div class="col-12">
                        <label for="inputEmailAddress" class="form-label">Логин</label>
                        <div class="ms-auto position-relative">
                          <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i class="bi bi-envelope-fill"></i></div>
                          <input type="email" class="form-control radius-30 ps-5" id="inputEmailAddress" placeholder="Введите логин">
                        </div>
                      </div>
                      <div class="col-12">
                        <label for="inputChoosePassword" class="form-label">Пароль</label>
                        <div class="ms-auto position-relative">
                          <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i class="bi bi-lock-fill"></i></div>
                          <input type="password" class="form-control radius-30 ps-5" id="inputChoosePassword" placeholder="Введите пароль">
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-check form-switch">
                          <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked="">
                          <label class="form-check-label" for="flexSwitchCheckChecked">Запомнить меня</label>
                        </div>
                      </div>
                      <div class="col-6 text-end">	<a href="https://d4.by">На главную</a>
                      </div>
                      <div class="col-12">
                        <div class="d-grid">
                          <button
                              type="submit"
                              class="btn btn-primary radius-30"
                              v-on:click.prevent="loginEnter"
                          >Войти</button>
                        </div>
                      </div>
                      <div class="col-12">
                        <p class="mb-0">© 2006-2021 Компания «D4.by», УНП 290794808</p>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script>
  export default {
    name: "AuthAdmin",

    methods: {
      loginEnter() {
        this.$emit('setLoginTrue');
      }
    }
  }
</script>