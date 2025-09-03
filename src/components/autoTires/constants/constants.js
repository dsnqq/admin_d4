import {
  DIAMETER,
  NUMBER_OF_HOLES,
  PCD,
  WHEEL_DIAMETER_R,
  WHEEL_WIDTH_J,
} from "@/constants/constants";

export const COLUMNS = [
  {
    title: "Изображение",
    components: () =>
      import("@/components/autoTires/AutoTiresListColumnImages.vue"),
    className: "auto-tires-list-column-images",
  },
  {
    title: "Год",
    components: () =>
      import("@/components/autoTires/AutoTiresListColumnDefault.vue"),
    content: "year",
  },
  {
    title: "Название шины",
    components: () =>
      import("@/components/autoTires/AutoTiresListColumnDefault.vue"),
    content: "name",
    className: "td-description",
  },
  {
    title: "Артикул",
    components: () =>
      import("@/components/autoTires/AutoTiresListColumnDefault.vue"),
    content: "model",
  },
  {
    title: "Цена за штуку",
    components: () =>
      import("@/components/autoTires/AutoTiresListColumnPrice.vue"),
  },
  {
    title: "Дата создания",
    components: () =>
      import("@/components/autoTires/AutoTiresListColumnDefault.vue"),
    content: "dateAdded",
  },
  {
    title: "Статус",
    components: () =>
      import("@/components/autoTires/AutoTiresListColumnStatus.vue"),
    content: "status",
  },
  {
    title: "Описание",
    components: () =>
      import("@/components/autoTires/AutoTiresListColumnDefault.vue"),
    content: "description",
    className: "td-description",
  },
  {
    title: "Действия",
    components: () =>
      import("@/components/autoTires/AutoTiresListColumnActions.vue"),
    className: "text-xxl-center",
  },
];

export const FIELD_POST_TO_SEND = [
  "description",
  "year",
  "diameter",
  "model",
  "modification",
  "fuel",
  "value",
  "youtube",
  "transmission",
  "typeEngines",
  "typeBody",
  "wheelDiameterR",
  "wheelWidthJ",
  "numberOfHoles",
  "departureE",
  "firstname",
  "stock",
  "telephone",
  "sparePartNumber",
  "pcd",
  "priceUSD",
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
    options: DIAMETER,
  },
];
