export let carsRouter = [
  {
    path: '/cars',
    name: 'carsAdmin',
    meta: {
      title: 'Авто в разборе',
    },
    component: () => import('@/components/carsAdmin/CarContent.vue'),
  },
  {
    path: '/car/:id',
    name: 'carDetail',
    meta: {
      title: 'Авто в разборе',
    },
    component: () => import('@/components/carsAdmin/CarIndex.vue'),
  },
  {
    path: '/car/create',
    name: 'carCreate',
    meta: {
      title: 'Добавление авто',
    },
    component: () => import('@/components/carsAdmin/CarIndex.vue'),
  },
];
