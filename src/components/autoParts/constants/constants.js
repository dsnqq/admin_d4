import {DIAMETER, NUMBER_OF_HOLES, PCD, WHEEL_DIAMETER_R, WHEEL_WIDTH_J} from "@/constants/constants";

export const COLUMNS = [
    {
        title: "Изображение",
        components: () => import("@/components/autoParts/AutoPartsListColumnImages.vue"),
        className: "auto-parts-list-column-images"
    },
    {
        title: "Марка и модель",
        components: () => import("@/components/autoParts/AutoPartsListColumnDefault.vue"),
        content: "title"
    },
    {
        title: "Год",
        components: () => import("@/components/autoParts/AutoPartsListColumnDefault.vue"),
        content: "year"
    },
    {
        title: "Объём",
        components: () => import("@/components/autoParts/AutoPartsListColumnDefault.vue"),
        content: "value"
    },
    {
        title: "Тип топлива",
        components: () => import("@/components/autoParts/AutoPartsListColumnDefault.vue"),
        content: "fuel",
        contentExtension: "typeEngines"
    },
    {
        title: "Название запчасти",
        components: () => import("@/components/autoParts/AutoPartsListColumnTitle.vue"),
        content: "autoParts.name"
    },
    {
        title: "Артикул",
        components: () => import("@/components/autoParts/AutoPartsListColumnDefault.vue"),
        content: "model"
    },
    {
        title: "Цена",
        components: () => import("@/components/autoParts/AutoPartsListColumnPrice.vue"),
    },
    {
        title: "Номер запчасти",
        components: () => import("@/components/autoParts/AutoPartsListColumnDefault.vue"),
        content: "sparePartNumber",
        className: "productlist"
    },
    {
        title: "Дата создания",
        components: () => import("@/components/autoParts/AutoPartsListColumnDefault.vue"),
        content: "dateAdded"
    },
    {
        title: "Статус",
        components: () => import("@/components/autoParts/AutoPartsListColumnStatus.vue"),
    },
    {
        title: "Описание",
        components: () => import("@/components/autoParts/AutoPartsListColumnDescription.vue"),
        content: "description",
        contentTheNote: "theNote",
        className: "td-description"
    },
    {
        title: "Действия",
        components: () => import("@/components/autoParts/AutoPartsListColumnActions.vue"),
        className: "text-xxl-center"
    },
];

export const FIELD_POST_TO_SEND = [
    'description',
    'year',
    'diameter',
    'model',
    'modification',
    'fuel',
    'value',
    'youtube',
    'transmission',
    'typeEngines',
    'typeBody',
    'wheelDiameterR',
    'wheelWidthJ',
    'numberOfHoles',
    'departureE',
    'firstname',
    'stock',
    'telephone',
    'theNote',
    'sparePartNumber',
    'pcd',
    'priceUSD'
];

export const FIELDS_FOR_CAST_DISK_DRIVE = [
    {
        label: "Диаметр R, дюймы",
        id: "wheelDiameterR",
        vModel: "wheelDiameterR",
        options: WHEEL_DIAMETER_R,
    },
    {
        label: "Ширина J, дюймы",
        id: "wheelWidthJ",
        vModel: "wheelWidthJ",
        options: WHEEL_WIDTH_J,
    },
    {
        label: "Кол-во отверстий",
        id: "numberOfHoles",
        vModel: "numberOfHoles",
        options: NUMBER_OF_HOLES,
    },
    {
        label: "Расстояние между отверстиями PCD, мм",
        id: "pcd",
        vModel: "pcd",
        options: PCD,
    },
    {
        label: "Вылет ET, мм",
        vModel: "departureE",
    },
    {
        label: "Диаметр центрального отверстия DIA, мм",
        id: "diameter",
        vModel: "diameter",
        options: DIAMETER
    }
];