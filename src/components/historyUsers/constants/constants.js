export const COLUMNS_INDEX = [
    {
        title: "Изображение",
        name: "image",
        name2: "",
        type: "image"
    },
    {
        title: "Запчасть",
        name: "name",
        name2: "",
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
        name2: "",
        type: "default"
    },
    {
        title: "Что менялось/Действие",
        name: "valueName",
        name2: "",
        type: "default"
    },
    {
        title: "Дата изменения",
        name: "dataChange",
        name2: "",
        type: "default"
    },
    {
        title: "Было",
        name: "valueOld",
        name2: "",
        type: "default"
    },
    {
        title: "Стало",
        name: "valueNew",
        name2: "",
        type: "default"
    },
    {
        title: "Местоположение текущее",
        name: "nowSection",
        name2: "",
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
        className: "text-xxl-center",
        name: "status",
        type: "status",
    },
    {
        title: "Действие",
        className: "text-xxl-center",
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