import { YEARS } from '@/constants/constants';
import { mapActions, mapGetters } from 'vuex';

export let autoPartsListOptionsFilters = {
  mounted() {
    this.GET_TYPES_OF_AUTO_PARTS();
    this.GET_BREND_MODEL_CAR_AUTO_PARTS();
  },

  computed: {
    ...mapGetters('autoParts', [
      'TYPES_OF_AUTO_PARTS',
      'BREND_MODEL_CAR_AUTO_PARTS',
    ]),

    optionsFilters() {
      return [
        {
          title: 'Марка и Модель',
          type: 'select',
          vModel: 'car',
          params: this.BREND_MODEL_CAR_AUTO_PARTS,
          className: 'd-flex justify-content-sm-between align-items-center',
          customLabel: 'name',
        },
        {
          title: 'Название запчасти',
          type: 'select',
          vModel: 'types',
          params: this.TYPES_OF_AUTO_PARTS,
          customLabel: 'name',
        },
        {
          title: 'Номер запчасти',
          type: 'input',
          inputType: 'text',
          vModel: 'sparePartNumber',
          autocomplete: 'off',
        },
        {
          title: 'Артикул',
          type: 'input',
          inputType: 'text',
          vModel: 'model',
          autocomplete: 'off',
        },
        {
          title: 'Тип топлива',
          type: 'select',
          vModel: 'fuel',
          params: ['Не выбрано', 'дизель', 'бензин', 'гибрид', 'электро'],
        },
        {
          title: 'Объём',
          type: 'input',
          inputType: 'text',
          vModel: 'value',
          autocomplete: 'off',
        },
        {
          title: 'Статус',
          type: 'select',
          vModel: 'status',
          params: ['Все объявления', 'Активно', 'Неактивно'],
        },
        [
          {
            title: 'Год',
            textLabel: 'от',
            type: 'select',
            vModel: 'yearStart',
            params: YEARS,
            className: 'card-filter-item__form--is-year',
            classNameItem: 'card-filter-item__select--is-year',
          },
          {
            title: 'Год',
            textLabel: 'до',
            type: 'select',
            vModel: 'yearLast',
            params: YEARS,
            className: 'card-filter-item__form--is-year',
            classNameItem: 'card-filter-item__select--is-year',
          },
        ],
      ];
    },
  },

  methods: {
    ...mapActions('autoParts', [
      'GET_TYPES_OF_AUTO_PARTS',
      'GET_BREND_MODEL_CAR_AUTO_PARTS',
    ]),
  },
};
