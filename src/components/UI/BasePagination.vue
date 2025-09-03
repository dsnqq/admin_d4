<template>
  <div class="row">
    <v-pagination
      v-if="totals > 20"
      v-model="pageNum"
      :records="totals"
      :per-page="20"
      :options="paginationOptions"
      @paginate="setPageByTotal"
    ></v-pagination>
  </div>
</template>

<script>
export default {
  name: 'BasePagination',

  props: {
    totals: Number,
    deleteText: Boolean,
    countChunk: {
      type: Number,
      default: 5,
    },
  },

  data() {
    return {
      pageNum: 1,

      paginationOptions: {
        chunk: 5,
        texts: {
          count: 'Отображается с {from} по {to} (всего {count} шт.)|{count}',
        },
      },
    };
  },

  mounted() {
    if (this.deleteText) {
      this.paginationOptions.texts.count = '';
    }

    if (this.countChunk) {
      this.paginationOptions.chunk = this.$props.countChunk;
    }
  },

  methods: {
    setPageByTotal(page) {
      this.pageNum = page;
      window.scrollTo(0, 0);
      this.$emit('setPageByTotal', page);
    },
  },
};
</script>
