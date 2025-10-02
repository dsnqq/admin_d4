const AutoPartsList = () => import('@/components/autoParts/AutoPartsList.vue');
const AutoPartsIndex = () =>
  import('@/components/autoParts/AutoPartsIndex.vue');

const AUTO_PARTS_META = {
  autoParts: { title: 'Автозапчасти' },
  autoPartsCreate: { title: 'Добавить З/Ч' },
  autoPartsDetail: { title: 'Автозапчасть' },
};

export const autoPartsRouter = [
  {
    path: '/auto-parts',
    name: 'autoParts',
    meta: AUTO_PARTS_META.autoParts,
    component: AutoPartsList,
  },
  {
    path: '/auto-parts/create',
    name: 'autoPartsCreate',
    meta: AUTO_PARTS_META.autoPartsCreate,
    component: AutoPartsIndex,
  },
  {
    path: '/auto/:id',
    name: 'autoPartsDetail',
    meta: AUTO_PARTS_META.autoPartsDetail,
    props: true,
    component: AutoPartsIndex,
  },
];
