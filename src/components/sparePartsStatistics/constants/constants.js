import { DOMAIN_API_V2 } from '@/constants/constants';

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
  GET_SPARE_PARTS_STATISTICS: DOMAIN_API_V2 + 'product-statistics',
  GET_SPARE_PARTS_STATISTICS_TOTALS:
    '/index.php?route=api/spare_parts_statistics/index/totals',
  GET_SPARE_PARTS_STATISTICS_DAY:
    '/index.php?route=api/spare_parts_statistics/index/day',
};
