<template>
  <div class="card">
    <div class="card-header text-center">
      {{dictionary.lastOrderOnTop}}
    </div>
    <div class="card-body">
      <div class="row">
        <table class="table table-border-1 mb-0">
          <thead>
            <tr>
              <th
                  v-for="(c, i) in columns"
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
                  v-for="(c, index) in columns"
                  :key="index"
              >
                <template v-if="c.type == 'default'">
                  {{ order[c.name] }}
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
      <div class="row">
        <v-pagination
            v-model="pageNum"
            :records="orderSaleTotal"
            :per-page="50"
            :options="paginationOptions"
            @paginate="setPageByTotal"
        ></v-pagination>
      </div>
    </div>
  </div>
</template>

<script>
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

      orderSaleTotal() {
        return parseInt(this.ORDER_TOTALS);
      },
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
        columns: COLUMNS,
        dictionary: DICTIONARY,
        paginationOptions: {
          chunk: 6,
          texts: {
            count: 'Отображается с {from} по {to} (всего {count} шт.)|{count}',
          }
        },
      };
    }
  }
</script>