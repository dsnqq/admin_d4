<template>
  <component :is="historyUsers()"></component>
</template>

<script>
export default {
  name: "AutoTires",

  components: {
    HistoryUsersIndex: () => import("@/components/historyUsers/components/HistoryUsersIndex.vue"),
    HistoryUsersList: () => import("@/components/historyUsers/components/HistoryUsersList.vue")
  },

  methods: {
    historyUsers() {
      if(this.$route.name === "historyUsersIndex"){
        return 'HistoryUsersIndex';
      }

      return 'HistoryUsersList';
    }
  },
}
</script>