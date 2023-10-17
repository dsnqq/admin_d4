import {YEARS, BODYS, FUELS} from "@/constants/constants";

export const LIST_ITEM_COLUMN = [
    "images",
    "marka",
    "model",
    "vin",
    "country",
    "year",
    "typePower",
    "volume",
    "power",
    "aboutPower",
    "body",
    "color",
    "action"
];

export const LIST_COLUMN_EDIT = [
    "vin",
    "country"
];

export const TABLE_HEADS = [
    {
        id: 1,
        name: "Фото",
        index: false,
        login: "",
        type: "",
    },
    {
        id: 2,
        name: "Марка",
        index: true,
        login: "marka",
        type: "select",
        optionsMarka: [],
    },
    {
        id: 3,
        name: "Модель",
        index: true,
        login: "model",
        type: "select",
        optionsModel: [],
    },
    {
        id: 4,
        name: "VIN",
        index: true,
        login: "vin",
        type: "input",
    },
    {
        id: 5,
        name: "Страна эксплуатации",
        index: true,
        login: "country",
        type: "input",
    },
    {
        id: 6,
        name: "Год",
        index: true,
        login: "year",
        type: "select",
        options: YEARS,
    },
    {
        id: 7,
        name: "Тип двигателя",
        index: true,
        login: "typePower",
        type: "select",
        options: FUELS,
    },
    {
        id: 8,
        name: "Объем двигателя",
        index: true,
        login: "volume",
        type: "input",
    },
    {
        id: 9,
        name: "Маркировка двигателя",
        index: true,
        login: "power",
        type: "input",
    },
    {
        id: 10,
        name: "Особенности двигателя",
        index: true,
        login: "aboutPower",
        type: "input",
    },
    {
        id: 11,
        name: "Кузов",
        index: true,
        login: "body",
        type: "select",
        options: BODYS,
    },
    {
        id: 12,
        name: "Цвет",
        index: true,
        login: "color",
        type: "input",
    },
    {
        id: 13,
        name: "Действие",
        index: false,
        login: "",
        type: "",
    },
];