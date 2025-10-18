export const COLUMNS = [
  {
    title: 'Изображение',
    components: () =>
      import('@/components/autoTires/AutoTiresListColumnImages.vue'),
    className: 'auto-tires-list-column-images',
  },
  {
    title: 'Год',
    components: () =>
      import('@/components/autoTires/AutoTiresListColumnDefault.vue'),
    content: 'year',
  },
  {
    title: 'Название шины',
    components: () =>
      import('@/components/autoTires/AutoTiresListColumnDefault.vue'),
    content: 'name',
    className: 'td-description',
  },
  {
    title: 'Артикул',
    components: () =>
      import('@/components/autoTires/AutoTiresListColumnDefault.vue'),
    content: 'model',
  },
  {
    title: 'Цена за штуку',
    components: () =>
      import('@/components/autoTires/AutoTiresListColumnPrice.vue'),
  },
  {
    title: 'Дата создания',
    components: () =>
      import('@/components/autoTires/AutoTiresListColumnDefault.vue'),
    content: 'dateAdded',
  },
  {
    title: 'Статус',
    components: () =>
      import('@/components/autoTires/AutoTiresListColumnStatus.vue'),
    content: 'status',
  },
  {
    title: 'Описание',
    components: () =>
      import('@/components/autoTires/AutoTiresListColumnDefault.vue'),
    content: 'description',
    className: 'td-description',
  },
  {
    title: 'Действия',
    components: () =>
      import('@/components/autoTires/AutoTiresListColumnActions.vue'),
    className: 'text-xxl-center',
  },
];

export const ENDPOINTS = {
  GET_AUTO_TIRES_FROM_API: '/index.php?route=api/auto_tires/tires',
  GET_AUTO_TIRES_TOTALS: '/index.php?route=api/auto_tires/tires/totals',
  CHANGE_AUTO_TIRES_STATUS:
    '/index.php?route=api/auto_tires/tires/change_status/',
  GET_AUTO_TIRES_INDEX: '/index.php?route=api/auto_tires/tires/index/',
  SET_AUTO_TIRES_IMAGE_FROM_LIST:
    '/index.php?route=api/auto_tires/tires/add_images/',
  CHANGE_AUTO_TIRES_PRICE:
    '/index.php?route=api/auto_tires/tires/change_price/',
  DELET_AUTO_TIRES_BY_API: '/index.php?route=api/auto_tires/tires/delete/',
  EDIT_AUTO_TIRES_FROM_API: '/index.php?route=api/auto_tires/tires/',
  SET_AUTO_TIRES_FROM_API: '/index.php?route=api/auto_tires/tires/create',
};
