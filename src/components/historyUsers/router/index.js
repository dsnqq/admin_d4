export let historyUsersRouter = [
    {
        path: '/history-users',
        name: 'historyUsers',
        meta: {
            title: 'История пользователей',
        },
        component: () => import('@/components/historyUsers/HistoryUsers.vue'),
    },
    {
        path: '/history-users/:id',
        name: 'historyUsersIndex',
        meta: {
            title: 'История пользователя',
        },
        component: () => import('@/components/historyUsers/components/HistoryUsersIndex.vue'),
    }
];