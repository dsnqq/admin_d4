export const COLUMNS = [
    {
        title: "Изображение",
        components: () => import("@/components/autoParts/components/AutoPartsListColumn/AutoPartsListColumnImages.vue"),
    },
    {
        title: "Марка и модель",
        components: () => import("@/components/autoParts/components/AutoPartsListColumn/AutoPartsListColumnDefault.vue"),
        content: "title"
    },
    {
        title: "Год",
        components: () => import("@/components/autoParts/components/AutoPartsListColumn/AutoPartsListColumnDefault.vue"),
        content: "year"
    },
    {
        title: "Объём",
        components: () => import("@/components/autoParts/components/AutoPartsListColumn/AutoPartsListColumnDefault.vue"),
        content: "value"
    },
    {
        title: "Тип топлива",
        components: () => import("@/components/autoParts/components/AutoPartsListColumn/AutoPartsListColumnDefault.vue"),
        content: "fuel",
        contentExtension: "typeEngines"
    },
    {
        title: "Название запчасти",
        components: () => import("@/components/autoParts/components/AutoPartsListColumn/AutoPartsListColumnTitle.vue"),
        content: "autoParts.name"
    },
    {
        title: "Артикул",
        components: () => import("@/components/autoParts/components/AutoPartsListColumn/AutoPartsListColumnDefault.vue"),
        content: "model"
    },
    {
        title: "Цена",
        components: () => import("@/components/autoParts/components/AutoPartsListColumn/AutoPartsListColumnPrice.vue"),
    },
    {
        title: "Номер запчасти",
        components: () => import("@/components/autoParts/components/AutoPartsListColumn/AutoPartsListColumnDefault.vue"),
        content: "sparePartNumber",
        className: "productlist"
    },
    {
        title: "Дата создания",
        components: () => import("@/components/autoParts/components/AutoPartsListColumn/AutoPartsListColumnDefault.vue"),
        content: "dateAdded"
    },
    {
        title: "Статус",
        components: () => import("@/components/autoParts/components/AutoPartsListColumn/AutoPartsListColumnStatus.vue"),
    },
    {
        title: "Описание",
        components: () => import("@/components/autoParts/components/AutoPartsListColumn/AutoPartsListColumnDefault.vue"),
        content: "description",
        className: "td-description"
    },
    {
        title: "Действия",
        components: () => import("@/components/autoParts/components/AutoPartsListColumn/AutoPartsListColumnActions.vue"),
        className: "text-lg-center"
    },
]