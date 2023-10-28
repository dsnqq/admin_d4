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
        component: () => import('../components/autoParts/AutoPartsList.vue'),
    },
    {
        path: '/auto-parts/create',
        name: 'autoPartsCreate',
        meta: {
            title: 'Добавить автозапчасть',
        },
        component: () => import('../components/autoParts/AutoPartsIndex.vue'),
    },
    {
        path: '/auto/:id',
        name: 'autoPartsDetail',
        meta: {
            title: 'Автозапчасть',
        },
        props: true,
        component: () => import('../components/autoParts/AutoPartsIndex.vue'),
    },
    {
        path: '/auto-parts-archive',
        name: 'autoPartsArchive',
        meta: {
            title: 'Архив автозапчастей',
        },
        component: () => import('../components/autoPartsArchive/AutoPartsArchiveList.vue'),
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
        component: () => import('../components/carsAdmin/CarsAdmin.vue'),
    },
    {
        path: '/car/:id',
        name: 'carDetail',
        meta: {
            title: 'Авто в разборе',
        },
        component: () => import('../components/carsAdmin/CarsAdmin.vue'),
    },
    {
        path: '/car/create',
        name: 'carCreate',
        meta: {
            title: 'Добавление авто',
        },
        component: () => import('../components/carsAdmin/CarsAdmin.vue'),
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
        path: '/login',
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
        path: '/auto-tires',
        name: 'autoTires',
        meta: {
            title: 'Шины',
        },
        component: () => import('../components/autoTires/AutoTires.vue'),
    },
    {
        path: '/auto-tires-archive',
        name: 'autoTiresArchive',
        meta: {
            title: 'Архив шин',
        },
        component: () => import('../components/autoTiresArchive/AutoTiresArchive.vue'),
    },
    {
        path: '*',
        name: 'notFound',
        meta: {
            title: 'Здесь ничего нет',
        },
        component: () => import('../components/TheNotFound.vue'),
    },
];

export default new VueRouter({
    mode:'history',
    base: process.env.BASE_URL,
    routes
});