<template>
  <div class="card">
    <div class="card-header text-center">
      {{DICTIONARY.lastOrderOnTop}}
    </div>
    <div class="card-body">
      <div class="row">
        <table class="table table-border-1 mb-0 rwd-table middle-responsive">
          <thead>
            <tr>
              <th
                  v-for="(c, i) in COLUMNS"
                  :key="i"
                  scope="col"
              >
                {{c.title}}
              </th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(order, i) in ORDER_SALE"
              :key="i"
            >
              <td
                  :data-th="c.title"
                  v-for="(c, index) in COLUMNS"
                  :key="index"
              >
                <template v-if="c.type == 'default'">
                  {{ order[c.name] }}
                </template>
                <template v-if="c.type == 'address'">
                  <span
                      :title="order[c.name2]"
                      class="cursor-pointer"
                  >
                    {{ order[c.name] }}
                  </span>
                </template>
                <template v-else-if="c.type == 'email'">
                  <span
                      :title="order[c.name]"
                  >
                    {{ order[c.name] }}
                  </span>
                </template>
                <template v-else-if="c.type == 'products'">
                  <div
                      v-for="(p, j) in order[c.name]"
                      :key="j"
                  >
                    {{ getInformationAbout(p) }}
                  </div>
                </template>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <PaginationAdmin
          :totals="ORDER_TOTALS"
          @setPageByTotal="setPageByTotal"
      />
    </div>
  </div>
</template>

<script>
  import PaginationAdmin from "@/components/UI/PaginationAdmin.vue";
  import {COLUMNS} from "@/components/orderSale/constants/constants";
  import {DICTIONARY} from "@/constants/constants";
  import {mapActions, mapGetters} from "vuex";

  export default {
    name: "OrderSale",

    mounted() {
      this.GET_ORDER_SALE(this.pageNum);
      this.GET_ORDER_TOTALS();
    },

    computed: {
      ...mapGetters('orderSale', [
        'ORDER_SALE',
        'ORDER_TOTALS'
      ]),
    },

    components: {
      PaginationAdmin
    },

    methods: {
      ...mapActions('orderSale', [
        'GET_ORDER_SALE',
        'GET_ORDER_TOTALS'
      ]),

      setPageByTotal(page) {
        this.pageNum = page;
        this.GET_ORDER_SALE(this.pageNum);
      },

      getInformationAbout(product) {
        return product.number + ") " + product.name + " (цена: " + product.price + "$)";
      }
    },

    data() {
      return {
        pageNum: 1,
        COLUMNS,
        DICTIONARY,
      };
    }
  }
</script>

<style lang="scss" scoped>
@import "@/assets/scss/table-adaptive.scss";
</style>