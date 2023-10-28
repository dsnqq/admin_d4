export const COLUMNS = [
    {
        title: "Изображение",
        components: () => import("@/components/autoTires/AutoTiresListColumnImages.vue"),
        className: "auto-tires-list-column-images"
    },
    {
        title: "Год",
        components: () => import("@/components/autoTires/AutoTiresListColumnDefault.vue"),
        content: "year"
    },
    {
        title: "Название шины",
        components: () => import("@/components/autoTires/AutoTiresListColumnDefault.vue"),
        content: "name",
        className: "td-description"
    },
    {
        title: "Артикул",
        components: () => import("@/components/autoTires/AutoTiresListColumnDefault.vue"),
        content: "model"
    },
    {
        title: "Цена за штуку",
        components: () => import("@/components/autoTires/AutoTiresListColumnPrice.vue"),
    },
    {
        title: "Дата создания",
        components: () => import("@/components/autoTires/AutoTiresListColumnDefault.vue"),
        content: "dateAdded"
    },
    {
        title: "Статус",
        components: () => import("@/components/autoTires/AutoTiresListColumnStatus.vue"),
        content: "status"
    },
    {
        title: "Описание",
        components: () => import("@/components/autoTires/AutoTiresListColumnDefault.vue"),
        content: "description",
        className: "td-description"
    },
    {
        title: "Действия",
        components: () => import("@/components/autoTires/AutoTiresListColumnActions.vue"),
        className: "text-xxl-center"
    }
]