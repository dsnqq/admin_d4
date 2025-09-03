<template>
  <tr>
    <CarListItemColumn
      v-for="(itemColumn, index) in LIST_ITEM_COLUMN"
      :key="index"
      :num="index"
      :name="itemColumn"
      :store="store"
      :number="number"
    />
  </tr>
</template>

<script>
import { LIST_ITEM_COLUMN } from "@/components/carsAdmin/constants/constants";
import CarListItemColumn from "@/components/carsAdmin/CarListItemColumn.vue";

export default {
  name: "CarListItem",

  components: {
    CarListItemColumn,
  },

  data() {
    return {
      LIST_ITEM_COLUMN,
    };
  },

  props: {
    store: {
      type: Object,
    },

    number: {
      type: Number,
    },
  },
};
</script>
