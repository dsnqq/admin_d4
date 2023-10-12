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
          <table
              class="table table-border-1 mb-0 table-center-td"
          >
            <thead>
            <tr>
              <th
                  v-for="(c, i) in columns"
                  :key="i"
                  scope="col"
              >
                {{c.title}}
              </th>
            </tr>
            </thead>
            <tbody>
            <tr
                v-for="(userItem, i) in USER_HISTORY"
                :key="i"
            >
              <td
                  v-for="(c, index) in columns"
                  :key="index"
              >
                <template v-if="c.type == 'default'">
                  {{userItem[c.name]}}
                </template>
                <template v-if="c.type == 'image'">
                  <img :src="userItem[c.name]" />
                </template>
                <template v-if="c.type == 'price'">
                  {{userItem[c.name]}}<br>{{userItem[c.name2]}}
                </template>
              </td>
            </tr>
            </tbody>
          </table>
        </div>
        <div class="row">
          <v-pagination
              v-model="pageNum"
              :records="userHistoryTotal"
              :per-page="30"
              @paginate="setPageByTotal"
              :options="paginationOptions"
          ></v-pagination>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {COLUMNS_INDEX} from '@/components/historyUsers/constants/constants'
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
      columns: COLUMNS_INDEX,
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