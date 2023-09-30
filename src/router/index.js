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
        path: '/auto/:id',
        name: 'autoPartsDetail',
        meta: {
            title: 'Автозапчасть',
        },
        component: () => import('../components/autoParts/components/AutoPartsIndex.vue'),
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
        path: '/history-users/:id',
        name: 'historyUsersIndex',
        meta: {
            title: 'История пользователя',
        },
        component: () => import('../components/historyUsers/components/HistoryUsersIndex.vue'),
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
    {
        path: '/admin',
        name: 'authAdmin',
        component: () => import('../components/authAdmin/AuthAdmin.vue'),
    },
    {
        path: '/order-sale',
        name: 'orderSale',
        meta: {
            title: 'Заказы',
        },
        component: () => import('../components/orderSale/OrderSale.vue'),
    },
    {
        path: '*',
        name: 'notFound',
        meta: {
            title: 'Здесь ничего нет',
        },
        component: () => import('../components/NotFound.vue'),
    },
];

export default new VueRouter({
    mode:'history',
    base: process.env.BASE_URL,
    routes
});