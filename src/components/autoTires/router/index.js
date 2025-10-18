export const autoTiresRouter = [
  {
    path: '/auto-tires',
    name: 'autoTires',
    meta: {
      title: 'Шины',
    },
    component: () => import('@/components/autoTires/AutoTiresList.vue'),
  },
  {
    path: '/auto-tires/:id',
    name: 'autoTiresDetail',
    meta: {
      title: 'Шина',
    },
    props: true,
    component: () => import('@/components/autoTires/AutoTiresIndex.vue'),
  },
  {
    path: '/auto-tires/create',
    name: 'autoTiresCreate',
    meta: {
      title: 'Добавить шину',
    },
    component: () => import('@/components/autoTires/AutoTiresIndex.vue'),
  },
];
