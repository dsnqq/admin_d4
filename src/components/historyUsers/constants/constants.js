export const COLUMNS_INDEX = [
    {
        title: "Изображение",
        name: "image",
        type: "image"
    },
    {
        title: "Запчасть",
        name: "name",
        type: "default"
    },
    {
        title: "Цена",
        name: "priceUSD",
        name2: "priceBYN",
        type: "price"
    },
    {
        title: "Артикул",
        name: "productModel",
        type: "default"
    },
    {
        title: "Что менялось/Действие",
        name: "valueName",
        type: "default"
    },
    {
        title: "Дата изменения",
        name: "dataChange",
        type: "default"
    },
    {
        title: "Было",
        name: "valueOld",
        type: "default"
    },
    {
        title: "Стало",
        name: "valueNew",
        type: "default"
    },
    {
        title: "Местоположение текущее",
        name: "nowSection",
        type: "default"
    },
];

export const COLUMNS_LIST = [
    {
        title: "Имя",
        className: "",
        name: "firstname",
        name2: "lastname",
        type: "name",
    },
    {
        title: "Логин",
        className: "",
        name: "username",
        type: "default",
    },
    {
        title: "Статус",
        className: "text-center",
        name: "status",
        type: "status",
    },
    {
        title: "Действие",
        className: "text-center",
        type: "action",
        links: [
            {
                url: "/history-users/",
                url2: "user_id",
                className: "text-primary",
                iconClass: "bi bi-eye-fill"
            }
        ]
    }
];