import { autoPartsRouter } from '@/components/autoParts/router';
import { carsRouter } from '@/components/carsAdmin/router';
import { autoTiresRouter } from '@/components/autoTires/router';
import { historyUsersRouter } from '@/components/historyUsers/router';

import VueRouter from 'vue-router';

let defaults = [
  {
    path: '/',
    name: 'dashboardAdmin',
    meta: {
      title: 'Главная панель',
    },
    component: () => import('../components/dashboardAdmin/DashboardAdmin.vue'),
  },
  {
    path: '/auto-parts-archive',
    name: 'autoPartsArchive',
    meta: {
      title: 'Архив автозапчастей',
    },
    component: () =>
      import('../components/autoPartsArchive/AutoPartsArchiveList.vue'),
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
    component: () =>
      import('../components/sparePartsStatistics/SparePartsStatistics.vue'),
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
    path: '/auto-tires-archive',
    name: 'autoTiresArchive',
    meta: {
      title: 'Архив шин',
    },
    component: () =>
      import('../components/autoTiresArchive/AutoTiresArchiveList.vue'),
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

const routes = [].concat(
  defaults,
  autoPartsRouter,
  carsRouter,
  autoTiresRouter,
  historyUsersRouter,
);

export default new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes,
  scrollBehavior(to, from, savedPosition) {
    return savedPosition ?? { x: 0, y: 0 };
  },
});
