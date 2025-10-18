export const COLUMNS_DAY = [
  {
    title: 'Дата',
    content: 'date',
    prefix: '',
  },
  {
    title: 'Количество просмотров',
    content: 'count',
    prefix: ' шт.',
  },
];

export const COLUMNS_MAIN = [
  {
    title: 'Дата',
    content: 'date',
  },
  {
    title: 'Название',
    content: 'name',
  },
  {
    title: 'Артикул',
    content: 'article',
  },
  {
    title: 'Статус З/Ч',
    content: 'status',
  },
  {
    title: 'Кол-во просмотров',
    content: 'views',
  },
];

export const ENDPOINTS = {
  GET_TIRE_STATISTICS: '/index.php?route=api/tire_statistics/index',
  GET_TIRE_STATISTICS_TOTALS:
    '/index.php?route=api/tire_statistics/index/totals',
  GET_TIRE_STATISTICS_DAY: '/index.php?route=api/tire_statistics/index/day',
};
