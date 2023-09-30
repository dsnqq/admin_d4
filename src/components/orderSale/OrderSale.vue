<template>
  <div class="card">
    <div class="card-header text-center">
      Последние заказы отображаются вверху
    </div>
    <div class="card-body">
      <div class="row">
        <table class="table table-border-1 mb-0">
          <thead>
          <tr>
            <th scope="col">Заказ №</th>
            <th scope="col">Покупатель</th>
            <th scope="col">E-mail</th>
            <th scope="col">Телефон</th>
            <th scope="col">Город</th>
            <th scope="col">Адрес</th>
            <th scope="col">Состав заказа</th>
            <th scope="col">Комментарий</th>
            <th scope="col">Полная стоимость</th>
            <th scope="col">Дата заказа</th>
          </tr>
          </thead>
          <tbody>
          <tr
            v-for="(order, i) in ORDER_SALE"
            :key="i"
          >
            <td>
              {{ order.order_id }}
            </td>
            <td>
              {{ order.name }}
            </td>
            <td>
              {{ order.email }}
            </td>
            <td>
              {{ order.telephone }}
            </td>
            <td>
              {{ order.information }}
            </td>
            <td>
              {{ order.shipping_adress }}
            </td>
            <td>
              <div
                v-for="(product, index) in order.product_order"
                :key="index"
              >
                {{ getInformationAbout(product) }}
              </div>
            </td>
            <td>
              {{ order.comment }}
            </td>
            <td>
              {{ order.total }}
            </td>
            <td>
              {{ order.date_added }}
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