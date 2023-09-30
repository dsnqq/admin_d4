<template>
  <tr>
    <CarListItemColumn
        v-for="(itemColumn, index) in LIST_ITEM_COLUMN"
        :key="index"
        :name="itemColumn"
        :store="store"
        :number="number"
    />
  </tr>
</template>

<script>
  import {LIST_ITEM_COLUMN} from '../constants/constants';
  import CarListItemColumn from "./CarListItemColumn.vue";

  export default {
    name: "CarListItem",

    components: {
      CarListItemColumn
    },

    data() {
      return {
        LIST_ITEM_COLUMN
      }
    },

    props: {
      store: {
        type: Object
      },

      number: {
        type: Number
      },
    },
  }
</script>