<template>
  <LayoutTableRow>
    <template v-slot:header>
      <h6 class="mb-0 text-uppercase">
        {{ DICTIONARY.pageStatistics }}
      </h6>
    </template>
    <template v-slot:tableThead>
      <th v-for="(c, index) in COLUMNS_DAY" :key="index" scope="col">
        {{ c.title }}
      </th>
    </template>
    <template v-slot:tableTbody>
      <tr v-for="(item, i) in SPARE_PARTS_STATISTICS_DAY" :key="i">
        <td v-for="(c, index) in COLUMNS_DAY" :key="index" :data-th="c.title">
          {{ item[c.content] + c.prefix }}
        </td>
      </tr>
    </template>
  </LayoutTableRow>
</template>

<script>
import { COLUMNS_DAY } from "@/components/sparePartsStatistics/constants/constants";
import { DICTIONARY } from "@/constants/constants";
import LayoutTableRow from "@/layouts/LayoutTableRow.vue";
import { mapActions, mapGetters } from "vuex";

export default {
  name: "SparePartsStatisticsDay",
  components: { LayoutTableRow },

  mounted() {
    this.GET_SPARE_PARTS_STATISTICS_DAY();
  },

  computed: {
    ...mapGetters("sparePartsStatistics", ["SPARE_PARTS_STATISTICS_DAY"]),
  },

  methods: {
    ...mapActions("sparePartsStatistics", ["GET_SPARE_PARTS_STATISTICS_DAY"]),
  },

  data() {
    return {
      DICTIONARY,
      COLUMNS_DAY,
    };
  },
};
</script>
