<template>
  <div>
    тут статистика автозапчастей
  </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
  name: "SparePartsStatistics",

  mounted() {
    this.GET_SPARE_PARTS_STATISTICS();
  },

  computed: {
    ...mapGetters([
      'SPARE_PARTS_STATISTICS'
    ])
  },

  methods: {
    ...mapActions([
      'GET_SPARE_PARTS_STATISTICS'
    ]),
  }
}
</script>