<template>
  <div>
    <hr>
    <div class="card">
      <div class="card-body">
        <div class="row">
          <table class="table table-border-1 mb-0">
            <thead>
            <tr>
              <th scope="col">
                Имя
              </th>
              <th scope="col">
                Логин
              </th>
              <th
                  class="text-center"
                  scope="col"
              >
                Статус
              </th>
              <th
                  class="text-center"
                  scope="col"
              >
                Действие
              </th>
            </tr>
            </thead>
            <tbody>
              <tr
                v-for="(userItem, i) in USER_HISTORY_LIST"
                :key="i"
              >
                <td>
                  {{ userItem.firstname + ` ` + userItem.lastname }}
                </td>
                <td>
                  {{ userItem.username }}
                </td>
                <td class="text-center">
                  {{ getStatusUser(userItem.status) }}
                </td>
                <td class="text-center">
                  <router-link
                      :to="`/history-users/${userItem.user_id}`"
                      class="text-primary"
                  >
                    <i class="bi bi-eye-fill"></i>
                  </router-link>
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
import {mapActions, mapGetters} from "vuex";

export default {
  name: "HistoryUsers",

  mounted() {
    this.GET_USER_HISTORY_LIST();
  },

  computed: {
    ...mapGetters('historyUsers', [
      'USER_HISTORY_LIST'
    ])
  },

  methods: {
    ...mapActions('historyUsers', [
      'GET_USER_HISTORY_LIST',
    ]),

    getStatusUser(status) {
      return (status == 1) ? 'Активно' : 'Неактивно';
    }
  }

}
</script>

<style lang="scss" scoped>
@import "./src/components/historyUsers/style/history-users";
</style>