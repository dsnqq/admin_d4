<template>
  <div class="not-found">
    <div class="error-404 d-flex align-items-center justify-content-center">
      <div class="container">
        <div class="card py-5">
          <div class="row g-0">
            <div class="col col-xl-5">
              <div class="card-body p-4">
                <h1 class="display-1">
                  <span class="text-danger">4</span>
                  <span class="text-primary">0</span>
                  <span class="text-success">4</span>
                </h1>
                <h2 class="font-weight-bold display-4">Здесь ничего нет</h2>
                <p>
                  Вы достигли края вселенной.
                  <br>Страница, которую вы ищете, не найдена.
                  <br>Не волнуйтесь и вернитесь на предыдущую страницу.
                </p>
                <div class="mt-5">
                  <router-link
                      :to="{name: 'dashboardAdmin'}"
                      class="btn btn-danger btn-lg px-md-5 radius-30"
                  >
                    Главная панель
                  </router-link>
                </div>
              </div>
            </div>
            <div class="col-xl-7">
              <img src="/assets/images/404-error.png" class="img-fluid">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: "NotFound",
  }
</script>