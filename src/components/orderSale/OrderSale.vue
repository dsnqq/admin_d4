<template>
  <LayoutDefault>
    <template #header>
      {{ DICTIONARY.lastOrderOnTop }}
    </template>
    <template #tableThead>
      <tr>
        <th v-for="(c, i) in COLUMNS" :key="i" scope="col">
          {{ c.title }}
        </th>
      </tr>
    </template>
    <template #tableTbody>
      <tr v-for="(order, i) in orderSale" :key="i">
        <td v-for="(c, index) in COLUMNS" :key="index" :data-th="c.title">
          <template v-if="c.type === 'default'">
            {{ order[c.name] }}
          </template>
          <template v-if="c.type === 'address'">
            <span :title="order[c.name2]" class="cursor-pointer">
              {{ order[c.name] }}
            </span>
          </template>
          <template v-else-if="c.type === 'email'">
            <span :title="order[c.name]">
              {{ order[c.name] }}
            </span>
          </template>
          <template v-else-if="c.type === 'products'">
            <div class="products-on-order">
              <div v-for="(p, j) in order[c.name]" :key="j">
                {{ getInformationAbout(p) }}
              </div>
            </div>
          </template>
        </td>
      </tr>
    </template>
    <template #pagination>
      <Pagination
        :totals="orderTotal"
        :count-chunk="isMobile ? 4 : 5"
        :class="{ 'card-body-pagination-mobile': isMobile }"
        @setPageByTotal="setPageByTotal"
      />
    </template>
  </LayoutDefault>
</template>

<script setup>
import LayoutDefault from '@/layouts/LayoutDefault.vue';
import Pagination from '@/components/UI/BasePagination.vue';
import { COLUMNS } from '@/components/orderSale/constants/constants';
import { DICTIONARY } from '@/constants/constants';
import { ref, onMounted, computed } from 'vue';
import { useStore } from '@/composables/useStore';
import { useDevice } from '@/composables/useDevice';

const pageNum = ref(1);
const store = useStore();
const isMobile = useDevice();

const orderSale = computed(() => store.getters['orderSale/ORDER_SALE']);
const orderTotal = computed(() => store.getters['orderSale/ORDER_TOTALS']);

const getOrderSale = (page) => store.dispatch('orderSale/GET_ORDER_SALE', page);
const getOrderTotals = () => store.dispatch('orderSale/GET_ORDER_TOTALS');

const setPageByTotal = (page) => {
  pageNum.value = page;
  getOrderSale(pageNum.value);
};

const getInformationAbout = (product) =>
  `${product.number}) ${product.name} (цена: ${product.price}$)`;

onMounted(() => {
  getOrderSale(pageNum.value);
  getOrderTotals();
});
</script>

<style lang="scss" scoped>
@import '@/components/orderSale/style/order-sale.scss';
</style>
