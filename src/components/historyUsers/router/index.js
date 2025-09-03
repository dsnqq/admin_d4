export let historyUsersRouter = [
  {
    path: '/history-users',
    name: 'historyUsers',
    meta: {
      title: 'Пользователи',
    },
    component: () => import('@/components/historyUsers/HistoryUsersList.vue'),
  },
  {
    path: '/history-users/:id',
    name: 'historyUsersIndex',
    meta: {
      title: 'История пользователя',
    },
    component: () => import('@/components/historyUsers/HistoryUsersIndex.vue'),
  },
];
