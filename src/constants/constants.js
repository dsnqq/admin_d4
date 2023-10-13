export const KEYS = "ttoCiOHMPjOkCjQBRE8OheHGWMi6hITr7iYmWDupyWXdKmP8DYTLp0xxrtbFLManRy2ETpfqHe8O60lOylGpcsv737SKM2IzXQDxam7dUMOkhqyKjypBnxaFW20qOoXxVQJBarMEQyxLlPsw5RXT3l0GLIasoSujCUDhAg83yXIBvMDZBEaBumdO3oXMtvvkhv3XdhQcL4RHZIHxdc3J0JJy8PbCImuwGsXFzKaXIEDC0wx7F7J3f1PoTHXtwA5L";

export const DOMAIN = "https://d4.by";

export const DICTIONARY = {
    goBack: "Вернуться назад",
    lastOrderOnTop: "Последние заказы отображаются вверху",
};

export const STATUS = [
    "Активно",
    "Неактивно"
];

let today = new Date();
let year = today.getFullYear();
let yearsNum = parseInt(year) - 1980;
let years = [];

for(let i = 0; i <= yearsNum; i++) {
    var y = 1980 + i;
    years.push(y);
}

export const YEARS = years;

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

export const TRANSMISSION = [
    "АКПП",
    "МКПП",
    "Робот",
    "Вариатор",
];

export const FUELS = [
    "дизель",
    "бензин",
    "гибрид",
    "электро"
];

export const TYPE_ENGINES_DISEL = [
    "CDi",
    "CDT",
    "CDTi",
    "CRD",
    "CRDi",
    "cTDi",
    "D",
    "D-4D",
    "D-CAT",
    "D5",
    "DCi",
    "DDiS",
    "Di",
    "DiD",
    "DT",
    "DTH",
    "DTi",
    "DTL",
    "HDi",
    "HPI",
    "HPT",
    "i-CTDi",
    "i-DTEC",
    "JTD",
    "SDi",
    "TD",
    "TDCi",
    "TDDi",
    "TDi",
    "TDi PD",
    "TDS",
    "TiD",
    "VCDi",
    "XDI",
];

export const TYPE_ENGINES_BENZ = [
    "FSI",
    "GDi",
    "HPi",
    "i",
    "IDE",
    "JTS",
    "Kompr",
    "MPI",
    "TCE",
    "TFSI",
    "THP",
    "Ti",
    "TSI",
    "VTEC",
    "VTI",
    "VVT-i",
    "карб",
    "моно",
];

export const TYPE_ENGINES_ALL = [
    "CDi",
    "CDT",
    "CDTi",
    "CRD",
    "CRDi",
    "cTDi",
    "D",
    "D-4D",
    "D-CAT",
    "D5",
    "DCi",
    "DDiS",
    "Di",
    "DiD",
    "DT",
    "DTH",
    "DTi",
    "DTL",
    "HDi",
    "HPI",
    "HPT",
    "i-CTDi",
    "i-DTEC",
    "JTD",
    "SDi",
    "TD",
    "TDCi",
    "TDDi",
    "TDi",
    "TDi PD",
    "TDS",
    "TiD",
    "VCDi",
    "XDI",
    "FSI",
    "GDi",
    "HPi",
    "i",
    "IDE",
    "JTS",
    "Kompr",
    "MPI",
    "TCE",
    "TFSI",
    "THP",
    "Ti",
    "TSI",
    "VTEC",
    "VTI",
    "VVT-i",
    "карб",
    "моно",
];