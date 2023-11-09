<template>
  <div>
    <Breadcrumb>
      <template v-slot:buttons>
        <router-link
            :to="{name: 'historyUsers'}"
            class="btn btn-primary"
        >
          {{DICTIONARY.goBack}}
        </router-link>
      </template>
    </Breadcrumb>
    <hr>
    <LayoutDefault>
      <template v-slot:tableThead>
        <tr>
          <th
              v-for="(c, i) in COLUMNS_INDEX"
              :key="i"
              scope="col"
          >
            {{c.title}}
          </th>
        </tr>
      </template>
      <template v-slot:tableTbody>
        <tr
            v-for="(userItem, i) in USER_HISTORY"
            :key="i"
        >
          <td
              v-for="(c, index) in COLUMNS_INDEX"
              :key="index"
              :data-th="c.title"
          >
            <template v-if="c.type == 'default'">
              {{userItem[c.name]}}
            </template>
            <template v-else-if="c.type == 'image'">
              <img :src="userItem[c.name]" />
            </template>
            <template v-else-if="c.type == 'price'">
              {{userItem[c.name]}}<br>{{userItem[c.name2]}}
            </template>
          </td>
        </tr>
      </template>
      <template v-slot:pagination>
        <Pagination
            :totals="USER_HISTORY_TOTAL"
            @setPageByTotal="setPageByTotal"
            :countChunk="isMobile ? 4 : 5"
            :class="{'card-body-pagination-mobile' : isMobile}"
        />
      </template>
    </LayoutDefault>
  </div>
</template>

<script>
import LayoutDefault from "@/layouts/LayoutDefault.vue";
import Pagination from "@/components/UI/BasePagination.vue";
import {COLUMNS_INDEX} from '@/components/historyUsers/constants/constants'
import {DICTIONARY} from '@/constants/constants'
import Breadcrumb from "@/components/UI/BaseBreadcrumb.vue";
import {mapActions, mapGetters} from "vuex";
import {mixins} from "@/mixins/mixins";

export default {
  name: "HistoryUsersIndex",

  components: {
    Breadcrumb,
    Pagination,
    LayoutDefault
  },

  mixins: [mixins],

  mounted() {
    this.GET_USER_HISTORY(this.param);
    this.GET_USER_HISTORY_TOTAL(this.id);
  },

  computed: {
    ...mapGetters('historyUsers', [
      'USER_HISTORY',
      'USER_HISTORY_TOTAL'
    ]),
  },

  methods: {
    ...mapActions('historyUsers', [
      'GET_USER_HISTORY',
      'GET_USER_HISTORY_TOTAL'
    ]),

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
      }
    };
  }
}
</script>

<style lang="scss" scoped>
@import "./src/components/historyUsers/components/style/history-users-index.scss";
</style>