<template>
  <tr>
    <th
        v-for="tableHeadItem in TABLE_HEADS"
        :key="tableHeadItem.id"
    >
      {{tableHeadItem.name}}
    </th>
  </tr>
</template>

<script>
import {TABLE_HEADS} from '../../../constants/constants';
export default {
  name: "CarListItemHead",

  data() {
    return {
      TABLE_HEADS
    };
  }
}
</script>

<style scoped lang="scss">
@import "./src/components/carsAdmin/style/car-list-item-head.scss";
</style>