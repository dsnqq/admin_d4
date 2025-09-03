<template>
  <div class="row">
    <v-pagination
      v-if="totals > 20"
      v-model="pageNum"
      :records="totals"
      :per-page="20"
      @paginate="setPageByTotal"
      :options="paginationOptions"
    ></v-pagination>
  </div>
</template>

<script>
export default {
  name: "BasePagination",

  mounted() {
    if (this.deleteText) {
      this.paginationOptions.texts.count = "";
    }

    if (this.countChunk) {
      this.paginationOptions.chunk = this.$props.countChunk;
    }
  },

  props: {
    totals: Number,
    deleteText: Boolean,
    countChunk: {
      type: Number,
      default: 5,
    },
  },

  methods: {
    setPageByTotal(page) {
      this.pageNum = page;
      window.scrollTo(0, 0);
      this.$emit("setPageByTotal", page);
    },
  },

  data() {
    return {
      pageNum: 1,

      paginationOptions: {
        chunk: 5,
        texts: {
          count: "Отображается с {from} по {to} (всего {count} шт.)|{count}",
        },
      },
    };
  },
};
</script>
