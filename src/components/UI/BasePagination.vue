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

    props: {
      totals: Number,
      storageCache: Object
    },

    mounted() {
      if(this.$props.storageCache !== null) {
        let localCacheFilters = this.$props.storageCache;

        if (localCacheFilters.length !== 0) {
          this.pageNum = (localCacheFilters.page) ? localCacheFilters.page : 1;
        }
      }
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
            count: 'Отображается с {from} по {to} (всего {count} шт.)|{count}',
          }
        },
      };
    }
  }
</script>