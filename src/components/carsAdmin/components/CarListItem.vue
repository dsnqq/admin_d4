<template>
  <div>
    <CarListItemColumn
        v-for="(itemColumn, index) in LIST_ITEM_COLUMN"
        :key="index"
        :name="itemColumn"
        :store="store"
        :number="number"
        :class="{'car-list-wrapper-column--is-images': isColumnImage(itemColumn)}"
        class="car-list-wrapper__column"
    />
  </div>
</template>

<script>
  import {LIST_ITEM_COLUMN} from '../../../constants/constants';
  import CarListItemColumn from "./CarListItemColumn.vue";

  export default {
    name: "CarListItem",

    components: {
      CarListItemColumn
    },

    methods: {
      isColumnImage: function(column) {
        return column === "images";
      }
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