export const COLUMNS = [
  {
    title: 'Изображение',
    components: () =>
      import(
        '@/components/autoPartsArchive/AutoPartsArchiveListColumnImages.vue'
      ),
    className: 'auto-parts-list-column-images',
  },
  {
    title: 'Марка и модель',
    components: () =>
      import(
        '@/components/autoPartsArchive/AutoPartsArchiveListColumnDefault.vue'
      ),
    content: 'title',
  },
  {
    title: 'Год',
    components: () =>
      import(
        '@/components/autoPartsArchive/AutoPartsArchiveListColumnDefault.vue'
      ),
    content: 'year',
  },
  {
    title: 'Объём',
    components: () =>
      import(
        '@/components/autoPartsArchive/AutoPartsArchiveListColumnDefault.vue'
      ),
    content: 'value',
  },
  {
    title: 'Тип топлива',
    components: () =>
      import(
        '@/components/autoPartsArchive/AutoPartsArchiveListColumnDefault.vue'
      ),
    content: 'fuel',
    contentExtension: 'typeEngines',
  },
  {
    title: 'Название запчасти',
    components: () =>
      import(
        '@/components/autoPartsArchive/AutoPartsArchiveListColumnTitle.vue'
      ),
    content: 'autoParts.name',
  },
  {
    title: 'Артикул',
    components: () =>
      import(
        '@/components/autoPartsArchive/AutoPartsArchiveListColumnDefault.vue'
      ),
    content: 'model',
  },
  {
    title: 'Цена',
    components: () =>
      import(
        '@/components/autoPartsArchive/AutoPartsArchiveListColumnPrice.vue'
      ),
  },
  {
    title: 'Номер запчасти',
    components: () =>
      import(
        '@/components/autoPartsArchive/AutoPartsArchiveListColumnDefault.vue'
      ),
    content: 'sparePartNumber',
    className: 'productlist',
  },
  {
    title: 'Дата удаления',
    components: () =>
      import(
        '@/components/autoPartsArchive/AutoPartsArchiveListColumnDefault.vue'
      ),
    content: 'dateDeleted',
  },
  {
    title: 'Описание',
    components: () =>
      import(
        '@/components/autoPartsArchive/AutoPartsArchiveListColumnDefault.vue'
      ),
    content: 'description',
    className: 'td-description',
  },
  {
    title: 'Действия',
    components: () =>
      import(
        '@/components/autoPartsArchive/AutoPartsArchiveListColumnActions.vue'
      ),
    className: 'text-xxl-center',
  },
];
