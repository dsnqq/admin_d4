import DashboardAdmin from "../components/dashboardAdmin/DashboardAdmin.vue";
import AutoPartsAdmin from "../components/autoParts/AutoPartsAdmin.vue";
import HistoryUsers from "../components/historyUsers/HistoryUsers.vue";
import CarsAdmin from "../components/carsAdmin/CarsAdmin.vue";
import TireStatistics from "../components/tireStatistics/TireStatistics.vue";
import SparePartsStatistics from "../components/sparePartsStatistics/SparePartsStatistics.vue";

import VueRouter from "vue-router";

const routes = [
    {
        path: '/',
        name: 'dashboardAdmin',
        component: DashboardAdmin,
    },
    {
        path: '/auto-parts',
        name: 'autoParts',
        component: AutoPartsAdmin,
    },
    {
        path: '/history-users',
        name: 'historyUsers',
        component: HistoryUsers,
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
        path: '/create-car',
        name: 'carCreate',
        component: CarsAdmin,
    },
    {
        path: '/tire-statistics',
        name: 'tireStatistics',
        component: TireStatistics,
    },
    {
        path: '/spare-parts-statistics',
        name: 'sparePartsStatistics',
        component: SparePartsStatistics,
    },
];

export default new VueRouter({
    mode:'history',
    base: process.env.BASE_URL,
    routes
});