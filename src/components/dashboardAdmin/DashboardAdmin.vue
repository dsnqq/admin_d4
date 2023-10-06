<template>
      <div>
        <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-2 row-cols-xxl-4">
          <div class="col">
            <div class="card overflow-hidden radius-10">
              <div class="card-body">
                <div class="d-flex align-items-stretch justify-content-between overflow-hidden">
                  <div class="w-50">
                    <p>Запчасти (Активные/Неактив)</p>
                    <h4 class="">77301/1078 шт.</h4>
                  </div>
                  <div class="w-50">
                    <p class="mb-3 float-end text-success">+ 16% <i class="bi bi-arrow-up"></i></p>
                    <div id="chart1"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="card overflow-hidden radius-10">
              <div class="card-body">
                <div class="d-flex align-items-stretch justify-content-between overflow-hidden">
                  <div class="w-50">
                    <p>Шины (Активные/Неактив)</p>
                    <h4 class="">14/1 шт.</h4>
                  </div>
                  <div class="w-50">
                    <p class="mb-3 float-end text-danger">- 3.4% <i class="bi bi-arrow-down"></i></p>
                    <div id="chart2"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="card overflow-hidden radius-10">
              <div class="card-body">
                <div class="d-flex align-items-stretch justify-content-between overflow-hidden">
                  <div class="w-50">
                    <p>Сумма всех запчастей</p>
                    <h4 class="">80000$</h4>
                  </div>
                  <div class="w-50">
                    <p class="mb-3 float-end text-success">+ 24% <i class="bi bi-arrow-up"></i></p>
                    <div id="chart3"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="card overflow-hidden radius-10">
              <div class="card-body">
                <div class="d-flex align-items-stretch justify-content-between overflow-hidden">
                  <div class="w-50">
                    <p>Сумма всех шин</p>
                    <h4 class="">3000$</h4>
                  </div>
                  <div class="w-50">
                    <p class="mb-3 float-end text-success">+ 8.2% <i class="bi bi-arrow-up"></i></p>
                    <div id="chart4"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          
          <div class="col">
            <div class="card overflow-hidden radius-10">
              <div class="card-body">
                <div class="d-flex align-items-stretch justify-content-between overflow-hidden">
                  <div class="w-50">
                    <p>Просмотры З/Ч за этот месяц</p>
                    <h4 class="">5600 шт.</h4>
                  </div>
                  <div class="w-50">
                    <p class="mb-3 float-end text-success">+ 8.2% <i class="bi bi-arrow-up"></i></p>
                    <div id="chart4"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col">
            <div class="card overflow-hidden radius-10">
              <div class="card-body">
                <div class="d-flex align-items-stretch justify-content-between overflow-hidden">
                  <div class="w-50">
                    <p>Кол-во пользователей</p>
                    <h4 class="">14 чел.</h4>
                  </div>
                  <div class="w-50">
                    <p class="mb-3 float-end text-success">+ 8.2% <i class="bi bi-arrow-up"></i></p>
                    <div id="chart4"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 row-cols-xxl-4">
          <div class="col">
            <div class="card radius-10">
              <div class="card-body">
                <div class="d-flex align-items-center">
                  <div class="">
                    <p class="mb-1">Свежие запчасти</p>
                    <h4 class="mb-0 text-primary">1145 шт.</h4>
                  </div>
                  <div class="ms-auto fs-2 text-primary">
                    <i class="bi bi-bell"></i>
                  </div>
                </div>
                <hr class="my-2">
                <small class="mb-0"><i class="bi bi-arrow-up"></i> <span>Добавлено в этом месяце</span></small>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="card radius-10">
              <div class="card-body">
                <div class="d-flex align-items-center">
                  <div class="">
                    <p class="mb-1">Проданные запчасти</p>
                    <h4 class="mb-0 text-danger">249 шт.</h4>
                  </div>
                  <div class="ms-auto fs-2 text-danger">
                    <i class="bi bi-pencil"></i>
                  </div>
                </div>
                <hr class="my-2">
                <small class="mb-0"><i class="bi bi-arrow-up"></i> <span>Продано в этом месяце</span></small>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="card radius-10">
              <div class="card-body">
                <div class="d-flex align-items-center">
                  <div class="">
                    <p class="mb-1">Заказы</p>
                    <h4 class="mb-0 text-success">1845 шт.</h4>
                  </div>
                  <div class="ms-auto fs-2 text-success">
                    <i class="bi bi-envelope"></i>
                  </div>
                </div>
                <hr class="my-2">
                <small class="mb-0"><i class="bi bi-arrow-up"></i> <span>Заказов через корзину</span></small>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="card radius-10">
              <div class="card-body">
                <div class="d-flex align-items-center">
                  <div class="">
                    <p class="mb-1">В архиве</p>
                    <h4 class="mb-0 text-orange">645 шт.</h4>
                  </div>
                  <div class="ms-auto fs-2 text-orange">
                    <i class="bi bi-book"></i>
                  </div>
                </div>
                <hr class="my-2">
                <small class="mb-0"><i class="bi bi-arrow-up"></i> <span>Сейчас запчастей в архиве</span></small>
              </div>
            </div>
          </div>
        </div>
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-3 row-cols-xl-3 row-cols-xxl-3">
          <div class="col">
            <div class="card radius-10">
              <div class="card-body text-center">
                <div class="widget-icon mx-auto mb-3 bg-light-success text-success">
                  <i class="bi bi-currency-dollar"></i>
                </div>
                <h3>3.4 <i class="bi bi-pencil"></i></h3>
                <p class="mb-0">Доллар США (USD)</p>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="card radius-10">
              <div class="card-body text-center">
                <div class="widget-icon mx-auto mb-3 bg-light-primary text-primary">
                  <i class="bi bi-cash"></i>
                </div>
                <h3>107 <i class="bi bi-pencil"></i></h3>
                <p class="mb-0">Рос. рубль (RUB)</p>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="card radius-10">
              <div class="card-body text-center">
                <div class="widget-icon mx-auto mb-3 bg-light-orange text-orange">
                  <i class="bi bi-currency-euro"></i>
                </div>
                <h3>3.5 <i class="bi bi-pencil"></i></h3>
                <p class="mb-0">Евро (EUR)</p>
              </div>
            </div>
          </div>
        </div>
      </div>
</template>

<script>
  export default {
    name: "DashboardAdmin"
  }
</script>
