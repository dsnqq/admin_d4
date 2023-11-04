<template>
  <LayoutDefault>
    <template v-slot:tableThead>
      <th
          v-for="(c, index) in COLUMNS"
          :key="index"
      >
        {{c.title}}
      </th>
    </template>
    <template v-slot:tableTbody>
      <tr
          v-for="(autoTire, i) in AUTO_TIRES"
          :key="i"
      >
        <td
            v-for="(c, index) in COLUMNS"
            :key="index"
            :data-th="c.title"
            :class="c.className"
        >
          <component
              :is="c.components"
              :images="autoTire.images"
              :title="autoTire.name"
              :index="i"
              :id="autoTire.product_id"
              :showAll="autoTire.imagesShowAllImage"
              :content="autoTire[c.content]"
              :contentExtension="autoTire[c.contentExtension]"
              :priceUSD="autoTire.priceUSD"
              :priceBYN="autoTire.priceBYN"
              :status="autoTire.status"
              :linkToSite="autoTire.linkToSite"
          ></component>
        </td>
      </tr>
    </template>
    <template v-slot:pagination>
      <Pagination
          :totals="AUTO_TIRES_TOTALS"
          :countChunk="isMobile ? 4 : 5"
          @setPageByTotal="setPageByTotal"
          :class="{'card-body-pagination-mobile' : isMobile}"
      />
      <BaseButtonFixedAdd
          component="autoTiresCreate"
      />
    </template>
  </LayoutDefault>
</template>

<script>
  import LayoutDefault from "@/layouts/LayoutDefault.vue";
  import {COLUMNS} from "@/components/autoTires/constants/constants";
  import Pagination from "@/components/UI/BasePagination.vue";
  import {mapActions, mapGetters} from "vuex";
  import {mixins} from "@/mixins/mixins";

  export default {
    name: "AutoTiresList",

    mounted() {
      this.GET_AUTO_TIRES_FROM_API(this.param.pageNum);
      this.GET_AUTO_TIRES_TOTALS();
    },

    mixins: [mixins],

    components: {
      Pagination,
      LayoutDefault,
      BaseButtonFixedAdd: () => import("@/components/UI/BaseButtonFixedAdd.vue"),
    },

    computed: {
      ...mapGetters('autoTires', [
        'AUTO_TIRES',
        'AUTO_TIRES_TOTALS'
      ]),
    },


    methods: {
      ...mapActions('autoTires', [
        'GET_AUTO_TIRES_FROM_API',
        'GET_AUTO_TIRES_TOTALS'
      ]),

      setPageByTotal(page) {
        this.param.pageNum = page;
        this.GET_AUTO_TIRES_FROM_API(this.param.pageNum);
      },
    },

    data() {
      return {
        COLUMNS,
        param: {
          pageNum: 1,
        },
      };
    }

  }
</script>

<style lang="scss" scoped>
@import "@/components/autoTires/style/auto-tires-list.scss";
</style>
