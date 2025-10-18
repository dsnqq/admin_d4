export const COLUMNS = [
  {
    title: 'Изображение',
    components: () =>
      import(
        '@/components/autoTiresArchive/AutoTiresArchiveListColumnImages.vue'
      ),
    className: 'auto-tires-list-column-images',
  },
  {
    title: 'Год',
    components: () =>
      import(
        '@/components/autoTiresArchive/AutoTiresArchiveListColumnDefault.vue'
      ),
    content: 'year',
  },
  {
    title: 'Название шины',
    components: () =>
      import(
        '@/components/autoTiresArchive/AutoTiresArchiveListColumnDefault.vue'
      ),
    content: 'name',
  },
  {
    title: 'Артикул',
    components: () =>
      import(
        '@/components/autoTiresArchive/AutoTiresArchiveListColumnDefault.vue'
      ),
    content: 'model',
  },
  {
    title: 'Цена за штуку',
    components: () =>
      import(
        '@/components/autoTiresArchive/AutoTiresArchiveListColumnPrice.vue'
      ),
    content: 'priceUSD',
  },
  {
    title: 'Дата удаления',
    components: () =>
      import(
        '@/components/autoTiresArchive/AutoTiresArchiveListColumnDefault.vue'
      ),
    content: 'dateDeleted',
  },
  {
    title: 'Описание',
    components: () =>
      import(
        '@/components/autoTiresArchive/AutoTiresArchiveListColumnDefault.vue'
      ),
    content: 'description',
    className: 'td-description',
  },
  {
    title: 'Действия',
    components: () =>
      import(
        '@/components/autoTiresArchive/AutoTiresArchiveListColumnActions.vue'
      ),
  },
];

export const ENDPOINTS = {
  GET_AUTO_TIRES_ARCHIVE_FROM_API:
    '/index.php?route=api/auto_tires_archive/tires',
  GET_AUTO_TIRES_ARCHIVE_TOTALS:
    '/index.php?route=api/auto_tires_archive/tires/totals',
  RESTORE_AUTO_TIRES_ARCHIVE_BY_API:
    '/index.php?route=api/auto_tires_archive/tires/restore/',
};
