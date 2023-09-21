import CarsAdmin from "../components/carsAdmin/CarsAdmin.vue";

import VueRouter from "vue-router";

const routes = [
    {
        path: '/',
        name: 'dashboardAdmin',
        component: () => import('../components/dashboardAdmin/DashboardAdmin.vue'),
    },
    {
        path: '/auto-parts',
        name: 'autoParts',
        component: () => import('../components/autoParts/AutoPartsAdmin.vue'),
    },
    {
        path: '/history-users',
        name: 'historyUsers',
        component: () => import('../components/historyUsers/HistoryUsers.vue'),
    },
    {
        path: '/cars',
        name: 'carsAdmin',
        component: CarsAdmin,
    },
    {
        path: '/car/:id',
        name: 'carDetail',
        component: CarsAdmin,
    },
    {
        path: '/car/create',
        name: 'carCreate',
        component: CarsAdmin,
    },
    {
        path: '/tire-statistics',
        name: 'tireStatistics',
        component: () => import('../components/tireStatistics/TireStatistics.vue'),
    },
    {
        path: '/spare-parts-statistics',
        name: 'sparePartsStatistics',
        component: () => import('../components/sparePartsStatistics/SparePartsStatistics.vue'),
    },
];

export default new VueRouter({
    mode:'history',
    base: process.env.BASE_URL,
    routes
});