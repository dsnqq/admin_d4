<template>
  <LayoutDefault>
    <template v-slot:header>
      {{ DICTIONARY.lastOrderOnTop }}
    </template>
    <template v-slot:tableThead>
      <tr>
        <th v-for="(c, i) in COLUMNS" :key="i" scope="col">
          {{ c.title }}
        </th>
      </tr>
    </template>
    <template v-slot:tableTbody>
      <tr v-for="(order, i) in ORDER_SALE" :key="i">
        <td :data-th="c.title" v-for="(c, index) in COLUMNS" :key="index">
          <template v-if="c.type == 'default'">
            {{ order[c.name] }}
          </template>
          <template v-if="c.type == 'address'">
            <span :title="order[c.name2]" class="cursor-pointer">
              {{ order[c.name] }}
            </span>
          </template>
          <template v-else-if="c.type == 'email'">
            <span :title="order[c.name]">
              {{ order[c.name] }}
            </span>
          </template>
          <template v-else-if="c.type == 'products'">
            <div class="products-on-order">
              <div v-for="(p, j) in order[c.name]" :key="j">
                {{ getInformationAbout(p) }}
              </div>
            </div>
          </template>
        </td>
      </tr>
    </template>
    <template v-slot:pagination>
      <Pagination
        :totals="ORDER_TOTALS"
        @setPageByTotal="setPageByTotal"
        :countChunk="isMobile ? 4 : 5"
        :class="{ 'card-body-pagination-mobile': isMobile }"
      />
    </template>
  </LayoutDefault>
</template>

<script>
import LayoutDefault from "@/layouts/LayoutDefault.vue";
import Pagination from "@/components/UI/BasePagination.vue";
import { COLUMNS } from "@/components/orderSale/constants/constants";
import { DICTIONARY } from "@/constants/constants";
import { mapActions, mapGetters } from "vuex";
import { mixins } from "@/mixins/mixins";

export default {
  name: "OrderSale",

  mounted() {
    this.GET_ORDER_SALE(this.pageNum);
    this.GET_ORDER_TOTALS();
  },

  mixins: [mixins],

  computed: {
    ...mapGetters("orderSale", ["ORDER_SALE", "ORDER_TOTALS"]),
  },

  components: {
    LayoutDefault,
    Pagination,
  },

  methods: {
    ...mapActions("orderSale", ["GET_ORDER_SALE", "GET_ORDER_TOTALS"]),

    setPageByTotal(page) {
      this.pageNum = page;
      this.GET_ORDER_SALE(this.pageNum);
    },

    getInformationAbout(product) {
      return (
        product.number + ") " + product.name + " (цена: " + product.price + "$)"
      );
    },
  },

  data() {
    return {
      pageNum: 1,
      COLUMNS,
      DICTIONARY,
    };
  },
};
</script>

<style lang="scss" scoped>
@import "@/components/orderSale/style/order-sale.scss";
</style>
