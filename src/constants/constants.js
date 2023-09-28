// SET TYPE BODY CAR
export const BODYS = [
    "седан",
    "хэтчбек",
    "универсал",
    "купе",
    "кабриолет",
    "минивеэн",
    "пикап",
    "фургон",
    "тягач",
    "лифтбек",
    "внедорожник"
];

// SET TYPE POWER
export const TYPE_POWERS = [
    "дизель",
    "бензин",
    "гибрид",
    "электро"
];

// SET KEYS FOR API
export const KEYS = "ttoCiOHMPjOkCjQBRE8OheHGWMi6hITr7iYmWDupyWXdKmP8DYTLp0xxrtbFLManRy2ETpfqHe8O60lOylGpcsv737SKM2IzXQDxam7dUMOkhqyKjypBnxaFW20qOoXxVQJBarMEQyxLlPsw5RXT3l0GLIasoSujCUDhAg83yXIBvMDZBEaBumdO3oXMtvvkhv3XdhQcL4RHZIHxdc3J0JJy8PbCImuwGsXFzKaXIEDC0wx7F7J3f1PoTHXtwA5L";

// SET YEARS
let today = new Date();
let year = today.getFullYear();
let yearsNum = parseInt(year) - 1980;
let years = [];

for(let i = 0; i <= yearsNum; i++) {
    var y = 1980 + i;
    years.push(y);
}

export const YEARS = years;

// SET domain
export const DOMAIN = "https://d4.by";

// SET column
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

// SET column for Edit on List
export const LIST_COLUMN_EDIT = [
    "vin",
    "country"
];

// SET TABLE HEAD
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
        options: TYPE_POWERS,
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