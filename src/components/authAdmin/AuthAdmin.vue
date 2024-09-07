<template>
  <div class="wrapper auth-admin">
    <div
        v-if="!this.auth.status"
        class="alert border-0 bg-light-danger alert-dismissible fade show py-2"
    >
      <div class="d-flex align-items-center">
        <div class="fs-3 text-danger"><i class="bi bi-x-circle-fill"></i>
        </div>
        <div class="ms-3">
          <div class="text-danger">
            {{this.auth.message}}
          </div>
        </div>
      </div>
      <button
          @click.prevent="closeAlertMessage"
          type="button"
          class="btn-close"
          data-bs-dismiss="alert"
          aria-label="Close">
      </button>
    </div>
    <main class="authentication-content">
      <div class="container-fluid">
        <div class="authentication-card">
          <div class="card shadow rounded-0 overflow-hidden">
            <div class="row g-0">
              <div class="col-lg-6">
                <div class="card-body p-4 p-sm-5">
                  <h5 class="card-title">Вход</h5>
                  <p class="card-text">Для использования системы - авторизуйтесь!</p>
                  <hr>
                  <div class="form-body">
                    <div class="row g-3">
                      <div class="col-12">
                        <label for="inputEmailAddress" class="form-label">Логин</label>
                        <div class="ms-auto position-relative">
                          <div class="position-absolute top-50 translate-middle-y search-icon px-3">
                            <i class="bi bi-envelope-fill"></i>
                          </div>
                          <input
                              v-model="param.login"
                              @input="loginValidateChecked"
                              type="text"
                              class="form-control radius-30 ps-5"
                              :class="{'is-invalid' : !loginValidate.status}"
                              id="inputEmailAddress"
                              placeholder="Введите логин"
                              autocomplete="off"
                          >
                          <div v-if="!loginValidate.status" class="invalid-feedback">
                            {{loginValidate.message}}
                          </div>
                        </div>
                      </div>
                      <div class="col-12">
                        <label for="inputChoosePassword" class="form-label">Пароль</label>
                        <div class="ms-auto position-relative">
                          <div class="position-absolute top-50 translate-middle-y search-icon px-3">
                            <i class="bi bi-lock-fill"></i>
                          </div>
                          <input
                              v-model="param.password"
                              @input="passwordValidateChecked"
                              type="password"
                              class="form-control radius-30 ps-5"
                              :class="{'is-invalid' : !passwordValidate.status}"
                              id="inputChoosePassword"
                              placeholder="Введите пароль"
                          />
                          <div v-if="!passwordValidate.status" class="invalid-feedback">
                            {{passwordValidate.message}}
                          </div>
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
                              class="btn btn-primary radius-30"
                              @click.prevent="loginEnter"
                              title="Войти"
                          >
                            Войти
                          </button>
                        </div>
                      </div>
                      <div class="col-12">
                        <p class="mb-0">© 2006-2021 Компания «D4.by», УНП 290794808</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-6 bg-login d-flex align-items-center justify-content-center">
                <img :src="`./assets/images/login-img.jpg`" class="img-fluid" alt="" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script>
  import {mapActions, mapGetters} from "vuex";
  import autoParts from "@/components/autoParts/vuex/store";

  export default {
    name: "AuthAdmin",

    mounted() {
      let userNameByUrl = window.location.search.replace('?username=','');

      if (userNameByUrl) {
        this.param.login = userNameByUrl;
        this.param.password = '';

        this.LOGIN_FROM_API(this.param);
      }
    },

    computed: {
      ...mapGetters('authAdmin', [
        'USER',
      ]),
    },

    methods: {
      ...mapActions('authAdmin', [
        'LOGIN_FROM_API',
      ]),

      loginValidateChecked () {
        let lg = this.param.login;

        if (lg === "" || lg.length < 3 || lg.length > 7) {
          this.loginValidate.message = "Проверьте правильность поля логин!";
          this.loginValidate.status = false;
        } else {
          this.loginValidate.status = true;
        }
      },

      passwordValidateChecked() {
        let ps = this.param.password;

        if(ps === "" || ps.length < 4 || ps.length > 12){
          this.passwordValidate.message = "Проверьте правильность поля пароль!";
          this.passwordValidate.status = false;
        } else {
          this.passwordValidate.status = true;
        }
      },

      loginEnter() {
        this.auth.status = true;
        this.passwordValidate.status = true;
        this.loginValidate.status = true;

        this.passwordValidateChecked();
        this.loginValidateChecked();

        if(this.passwordValidate.status && this.loginValidate.status){
          this.LOGIN_FROM_API(this.param);
        } else {
          this.auth.status = false;
        }
      },

      closeAlertMessage() {
        this.auth.status = true;
      }
    },

    watch: {
      'USER': function() {
        if(this.USER.user_id != null) {
          this.$router.push({ name: 'autoParts' }).catch(()=>{});
          location.reload();
        } else {
          this.auth.status = false;
          this.auth.message = 'Неверные логин или пароль! Попробуйте снова!';
        }
      }
    },

    data() {
      return {
        auth: {
          status: true,
          message: "Данные не верны! Попробуйте снова!",
        },
        loginValidate: {
          message: "",
          status: true,
        },
        passwordValidate: {
          message: "",
          status: true,
        },
        param: {
          login: '',
          password: ''
        }
      }
    }
  }
</script>

<style lang="scss" scoped>
@import "@/components/authAdmin/style/auth-admin.scss";
</style>