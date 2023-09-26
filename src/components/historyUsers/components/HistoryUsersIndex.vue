<template>
  <div>
    <hr>
    <router-link
        :to="{name: 'historyUsers'}"
        class="btn btn-dark"
    >
      Вернуться назад
    </router-link>
    <div class="card">
      <div class="card-body">
        <div class="row">
          <table class="table table-border-1 mb-0">
            <thead>
            <tr>
              <th scope="col">Изображение</th>
              <th scope="col">Запчасть</th>
              <th scope="col">Цена</th>
              <th scope="col">Артикул</th>
              <th scope="col">Что менялось/Действие</th>
              <th scope="col">Дата изменения</th>
              <th scope="col">Было</th>
              <th scope="col">Стало</th>
              <th scope="col">Местоположение текущее</th>
            </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>1</td>
                <td>1</td>
                <td>1</td>
                <td>1</td>
                <td>1</td>
                <td>1</td>
                <td>1</td>
                <td>1</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: "HistoryUsersIndex",


  }
</script>