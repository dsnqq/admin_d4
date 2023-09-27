<template>
  <div>
    <BreadcrumbAdmin>
      <template v-slot:buttons>
        <router-link
            :to="{name: 'historyUsers'}"
            class="btn btn-dark"
        >
          Вернуться назад
        </router-link>
      </template>
    </BreadcrumbAdmin>
    <hr>
    <div class="card">
      <div class="card-body">
        <div class="row">
          <table class="table table-border-1 mb-0 table-center-td">
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
              <tr
                v-for="(userItem, i) in USER_HISTORY"
                :key="i"
              >
                <td>
                  <img
                      :src="userItem.image"
                  >
                </td>
                <td>
                  {{ userItem.name }}
                </td>
                <td>
                  {{ userItem.priceUSD }}
                  <br>
                  {{ userItem.priceBYN }}
                </td>
                <td>
                  {{ userItem.productModel }}
                </td>
                <td>
                  {{ userItem.valueName }}
                </td>
                <td>
                  {{ userItem.dataChange }}
                </td>
                <td>
                  {{ userItem.valueOld }}
                </td>
                <td>
                  {{ userItem.valueNew }}
                </td>
                <td>
                  {{ userItem.nowSection }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import BreadcrumbAdmin from "@/components/BreadcrumbAdmin.vue";
  import {mapActions, mapGetters} from "vuex";

  export default {
    name: "HistoryUsersIndex",

    components: {
      BreadcrumbAdmin,
    },

    mounted() {
      this.GET_USER_HISTORY(this.id);
    },

    computed: {
      ...mapGetters('historyUsers', [
        'USER_HISTORY'
      ])
    },

    methods: {
      ...mapActions('historyUsers', [
        'GET_USER_HISTORY'
      ]),
    },

    data() {
      return {
        id: this.$route.params.id,
      };
    }
  }
</script>