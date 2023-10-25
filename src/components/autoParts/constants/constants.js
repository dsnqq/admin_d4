export const COLUMNS = [
    {
        title: "Изображение",
        components: () => import("@/components/autoParts/AutoPartsListColumnImages.vue"),
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
        components: () => import("@/components/autoParts/AutoPartsListColumnDefault.vue"),
        content: "description",
        className: "td-description"
    },
    {
        title: "Действия",
        components: () => import("@/components/autoParts/AutoPartsListColumnActions.vue"),
        className: "text-lg-center"
    },
]