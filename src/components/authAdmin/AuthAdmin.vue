<template>
  <div class="wrapper auth-admin" @keyup.enter="handleAuthOnSystem">
    <div
      v-if="!auth.status"
      class="alert border-0 bg-light-danger alert-dismissible fade show py-2"
    >
      <div class="d-flex align-items-center">
        <div class="fs-3 text-danger"><i class="bi bi-x-circle-fill"></i></div>
        <div class="ms-3">
          <div class="text-danger">
            {{ auth.message }}
          </div>
        </div>
      </div>
      <button
        type="button"
        class="btn-close"
        data-bs-dismiss="alert"
        aria-label="Close"
        @click.prevent="closeAlertMessage"
      ></button>
    </div>
    <main class="authentication-content">
      <div class="container-fluid">
        <div class="authentication-card">
          <div class="card shadow rounded-0 overflow-hidden">
            <div class="row g-0">
              <div
                class="col-lg-6 bg-login d-flex align-items-center justify-content-center"
              >
                <img
                  :src="`./assets/images/login-img.jpg`"
                  class="img-fluid"
                  alt=""
                />
              </div>
              <div class="col-lg-6">
                <div class="card-body p-4 p-sm-5">
                  <h5 class="card-title">Вход</h5>
                  <p class="card-text">
                    Для использования системы - авторизуйтесь!
                  </p>
                  <hr />
                  <div class="form-body">
                    <div class="row g-3">
                      <div class="col-12">
                        <label for="inputEmailAddress" class="form-label"
                          >Логин</label
                        >
                        <div class="ms-auto position-relative">
                          <div
                            class="position-absolute top-50 translate-middle-y search-icon px-3"
                          >
                            <i class="bi bi-envelope-fill"></i>
                          </div>
                          <input
                            id="inputEmailAddress"
                            v-model="param.login"
                            type="text"
                            class="form-control radius-30 ps-5"
                            :class="{ 'is-invalid': !loginValidate.status }"
                            placeholder="Введите логин"
                            autocomplete="off"
                            @input="loginValidateChecked"
                          />
                          <div
                            v-if="!loginValidate.status"
                            class="invalid-feedback"
                          >
                            {{ loginValidate.message }}
                          </div>
                        </div>
                      </div>
                      <div class="col-12">
                        <label for="inputChoosePassword" class="form-label"
                          >Пароль</label
                        >
                        <div class="ms-auto position-relative">
                          <div
                            class="position-absolute top-50 translate-middle-y search-icon px-3"
                          >
                            <i class="bi bi-lock-fill"></i>
                          </div>
                          <input
                            id="inputChoosePassword"
                            v-model="param.password"
                            type="password"
                            class="form-control radius-30 ps-5"
                            :class="{ 'is-invalid': !passwordValidate.status }"
                            placeholder="Введите пароль"
                            @input="passwordValidateChecked"
                          />
                          <div
                            v-if="!passwordValidate.status"
                            class="invalid-feedback"
                          >
                            {{ passwordValidate.message }}
                          </div>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-check form-switch">
                          <input
                            id="flexSwitchCheckChecked"
                            class="form-check-input"
                            type="checkbox"
                            checked=""
                          />
                          <label
                            class="form-check-label"
                            for="flexSwitchCheckChecked"
                            >Запомнить меня</label
                          >
                        </div>
                      </div>
                      <div class="col-6 text-end">
                        <a href="https://d4.by">На главную</a>
                      </div>
                      <div class="col-12">
                        <div class="d-grid">
                          <button
                            class="btn btn-primary radius-30"
                            title="Войти"
                            @click.prevent="handleAuthOnSystem"
                          >
                            Войти
                          </button>
                        </div>
                      </div>
                      <div class="col-12">
                        <p class="mb-0">
                          © 2006-2021 Компания «D4.by», УНП 290794808
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { reactive, computed, watch } from 'vue';
import { useRouter } from '@/composables/useRouter';
import { useStore } from '@/composables/useStore';

const router = useRouter();
const store = useStore();

const auth = reactive({
  status: true,
  message: 'Данные не верны! Попробуйте снова!',
});

const loginValidate = reactive({
  message: '',
  status: true,
});

const passwordValidate = reactive({
  message: '',
  status: true,
});

const param = reactive({
  login: '',
  password: '',
});

const USER = computed(() => store.getters['authAdmin/USER']);

const LOGIN_FROM_API = (data) => {
  return store.dispatch('authAdmin/LOGIN_FROM_API', data);
};

const loginValidateChecked = () => {
  const lg = param.login;

  if (lg === '' || lg.length < 3 || lg.length > 7) {
    loginValidate.message = 'Проверьте правильность поля логин!';
    loginValidate.status = false;
  } else {
    loginValidate.status = true;
  }
};

const passwordValidateChecked = () => {
  const ps = param.password;

  if (ps === '' || ps.length < 4 || ps.length > 12) {
    passwordValidate.message = 'Проверьте правильность поля пароль!';
    passwordValidate.status = false;
  } else {
    passwordValidate.status = true;
  }
};

const handleAuthOnSystem = () => {
  auth.status = true;
  passwordValidate.status = true;
  loginValidate.status = true;

  passwordValidateChecked();
  loginValidateChecked();

  if (passwordValidate.status && loginValidate.status) {
    LOGIN_FROM_API(param);
  } else {
    auth.status = false;
  }
};

const closeAlertMessage = () => {
  auth.status = true;
};

watch(USER, () => {
  if (USER.value.user_id != null) {
    router.push({ name: 'dashboardAdmin' }).catch(() => {});
    location.reload();
  } else {
    auth.status = false;
    auth.message = 'Неверные логин или пароль! Попробуйте снова!';
  }
});
</script>

<style lang="scss" scoped>
@import '@/components/authAdmin/style/auth-admin.scss';
</style>
