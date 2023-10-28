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

export const WHEEL_DIAMETER_R = [
    "R12",
    "R12C",
    "R13",
    "R13C",
    "R14",
    "R14C",
    "R15",
    "R15C",
    "R16",
    "R16.5",
    "R16C",
    "R17",
    "R17.5",
    "R17C",
    "R18",
    "R19",
    "R19.5",
    "R20",
    "R21",
    "R22",
    "R22.5",
    "R23",
    "R24",
    "R24.5",
    "R25"
];

export const WHEEL_WIDTH_J = [
    "5",
    "5.5",
    "6",
    "6.5",
    "7",
    "7.5",
    "8",
    "8.5",
    "9",
    "9.5",
    "10",
    "10.5",
    "11",
    "11.5",
    "12",
    "12.5"
];

export const NUMBER_OF_HOLES = [
    "3",
    "4",
    "5",
    "6",
    "10"
];

export const PCD = [
    "98",
    "100",
    "105",
    "108",
    "110",
    "112",
    "114.3",
    "115",
    "118",
    "120",
    "120.7",
    "127",
    "130",
    "139.7",
    "150",
    "160",
    "161",
    "165.1",
    "170",
    "180",
    "205"
];

export const DIAMETER = [
    "52.1",
    "54.1",
    "56.1",
    "56.6",
    "57.1",
    "58.1",
    "59.1",
    "59.6",
    "60.1",
    "63.4",
    "64.1",
    "65.1",
    "66.1",
    "66.6",
    "67.1",
    "70.1",
    "71.2",
    "72.6",
    "74.1",
    "78.1",
    "84.1",
    "85.1",
    "89.1",
    "93.1",
    "95.1",
    "98.1",
    "100.1",
    "108.1"
];