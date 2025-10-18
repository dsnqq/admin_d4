export const COLUMNS = [
  {
    title: '№',
    name: 'order_id',
    type: 'default',
  },
  {
    title: 'Покупатель',
    name: 'name',
    type: 'default',
  },
  {
    title: 'E-mail',
    name: 'email',
    type: 'email',
  },
  {
    title: 'Телефон',
    name: 'telephone',
    type: 'default',
  },
  {
    title: 'Адрес',
    name: 'shipping_adress',
    name2: 'information',
    type: 'address',
  },
  {
    title: 'Состав заказа',
    name: 'product_order',
    type: 'products',
  },
  {
    title: 'Комментарий',
    name: 'comment',
    type: 'default',
  },
  {
    title: 'Полная стоимость',
    name: 'total',
    type: 'default',
  },
  {
    title: 'Дата заказа',
    name: 'date_added',
    type: 'default',
  },
];

export const ENDPOINTS = {
  GET_ORDER_SALE: '/index.php?route=api/order_sale/index/',
  GET_ORDER_TOTALS: '/index.php?route=api/order_sale/index/totals',
};
