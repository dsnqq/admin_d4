import CarsAdmin from "../components/carsAdmin/CarsAdmin.vue";

import VueRouter from "vue-router";

const routes = [
    {
        path: '/',
        name: 'dashboardAdmin',
        meta: {
            title: 'Главная панель',
        },
        component: () => import('../components/dashboardAdmin/DashboardAdmin.vue'),
    },
    {
        path: '/auto-parts',
        name: 'autoParts',
        meta: {
            title: 'Автозапчасти',
        },
        component: () => import('../components/autoParts/AutoPartsAdmin.vue'),
    },
    {
        path: '/history-users',
        name: 'historyUsers',
        meta: {
            title: 'История пользователей',
        },
        component: () => import('../components/historyUsers/HistoryUsers.vue'),
    },
    {
        path: '/cars',
        name: 'carsAdmin',
        meta: {
            title: 'Авто в разборе',
        },
        component: CarsAdmin,
    },
    {
        path: '/car/:id',
        name: 'carDetail',
        meta: {
            title: 'Авто в разборе',
        },
        component: CarsAdmin,
    },
    {
        path: '/car/create',
        name: 'carCreate',
        meta: {
            title: 'Добавление авто',
        },
        component: CarsAdmin,
    },
    {
        path: '/tire-statistics',
        name: 'tireStatistics',
        meta: {
            title: 'Статистика шин',
        },
        component: () => import('../components/tireStatistics/TireStatistics.vue'),
    },
    {
        path: '/spare-parts-statistics',
        name: 'sparePartsStatistics',
        meta: {
            title: 'Статистика запчастей',
        },
        component: () => import('../components/sparePartsStatistics/SparePartsStatistics.vue'),
    },
];

export default new VueRouter({
    mode:'history',
    base: process.env.BASE_URL,
    routes
});