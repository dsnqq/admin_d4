export let autoPartsRouter = [
  {
    path: '/auto-parts',
    name: 'autoParts',
    meta: {
      title: 'Автозапчасти',
    },
    component: () => import('@/components/autoParts/AutoPartsList.vue'),
  },
  {
    path: '/auto-parts/create',
    name: 'autoPartsCreate',
    meta: {
      title: 'Добавить З/Ч',
    },
    component: () => import('@/components/autoParts/AutoPartsIndex.vue'),
  },
  {
    path: '/auto/:id',
    name: 'autoPartsDetail',
    meta: {
      title: 'Автозапчасть',
    },
    props: true,
    component: () => import('@/components/autoParts/AutoPartsIndex.vue'),
  },
];
