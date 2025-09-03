<template>
  <div>
    <Breadcrumb>
      <template v-slot:buttons>
        <router-link :to="{ name: 'historyUsers' }" class="btn btn-primary">
          {{ DICTIONARY.goBack }}
        </router-link>
      </template>
    </Breadcrumb>
    <hr />
    <LayoutDefault>
      <template v-slot:tableThead>
        <th v-for="(c, i) in COLUMNS_INDEX" :key="i" scope="col">
          {{ c.title }}
        </th>
      </template>
      <template v-slot:tableTbody>
        <tr v-for="(userItem, i) in USER_HISTORY" :key="i">
          <td
            v-for="(c, index) in COLUMNS_INDEX"
            :key="index"
            :data-th="c.title"
            v-html="renderContentOnColumn(userItem[c.name], c.type)"
          ></td>
        </tr>
      </template>
      <template v-slot:pagination>
        <Pagination
          :totals="USER_HISTORY_TOTAL"
          @setPageByTotal="setPageByTotal"
          :countChunk="isMobile ? 4 : 5"
          :class="{ 'card-body-pagination-mobile': isMobile }"
        />
      </template>
    </LayoutDefault>
  </div>
</template>

<script>
import LayoutDefault from "@/layouts/LayoutDefault.vue";
import Pagination from "@/components/UI/BasePagination.vue";
import { COLUMNS_INDEX } from "@/components/historyUsers/constants/constants";
import { DICTIONARY } from "@/constants/constants";
import Breadcrumb from "@/components/UI/BaseBreadcrumb.vue";
import { mapActions, mapGetters } from "vuex";
import { mixins } from "@/mixins/mixins";

export default {
  name: "HistoryUsersIndex",

  components: {
    Breadcrumb,
    Pagination,
    LayoutDefault,
  },

  mixins: [mixins],

  mounted() {
    this.GET_USER_HISTORY(this.param);
    this.GET_USER_HISTORY_TOTAL(this.id);
  },

  computed: {
    ...mapGetters("historyUsers", ["USER_HISTORY", "USER_HISTORY_TOTAL"]),
  },

  methods: {
    ...mapActions("historyUsers", [
      "GET_USER_HISTORY",
      "GET_USER_HISTORY_TOTAL",
    ]),

    renderContentOnColumn(content, type) {
      return type == "image" ? '<img src="' + content + '" />' : content;
    },

    setPageByTotal(page) {
      this.pageNum = page;
      this.param.page = page;
      this.GET_USER_HISTORY(this.param);
    },
  },

  data() {
    return {
      id: this.$route.params.id,
      COLUMNS_INDEX,
      DICTIONARY,
      pageNum: 1,
      param: {
        user_id: this.$route.params.id,
        page: 1,
      },
    };
  },
};
</script>

<style lang="scss" scoped>
@import "@/components/historyUsers/style/history-users-index.scss";
</style>
