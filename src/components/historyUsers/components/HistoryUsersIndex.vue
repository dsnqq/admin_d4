<template>
  <div>
    <BreadcrumbAdmin>
      <template v-slot:buttons>
        <router-link
            :to="{name: 'historyUsers'}"
            class="btn btn-primary"
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
        <div class="row">
          <pagination
              v-model="pageNum"
              :records="userHistoryTotal"
              :per-page="30"
              @paginate="setPageByTotal"
              :options="paginationOptions"
          ></pagination>
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
      this.GET_USER_HISTORY(this.param);
      this.GET_USER_HISTORY_TOTAL(this.id);
    },

    computed: {
      ...mapGetters('historyUsers', [
        'USER_HISTORY',
        'USER_HISTORY_TOTAL'
      ]),

      userHistoryTotal() {
        return parseInt(this.USER_HISTORY_TOTAL);
      },
    },

    methods: {
      ...mapActions('historyUsers', [
        'GET_USER_HISTORY',
        'GET_USER_HISTORY_TOTAL'
      ]),

      setPageByTotal(page) {
        this.pageNum = page;
        this.param.page = page;
        this.GET_USER_HISTORY(this.param);
      },
    },

    data() {
      return {
        id: this.$route.params.id,
        pageNum: 1,
        paginationOptions: {
          chunk: 6,
          texts: {
            count: 'Отображается с {from} по {to} (всего {count} шт.)|{count}',
          }
        },
        param: {
          user_id: this.$route.params.id,
          page: 1,
        }
      };
    }
  }
</script>

<style lang="scss" scoped>
@import "./src/components/historyUsers/components/style/history-users-index.scss";
</style>