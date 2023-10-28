<template>
  <div class="card">
    <div class="card-body">
      <div class="row">
        <div>
          <table class="table align-middle table-striped table-border-1 rwd-table middle-responsive">
            <thead>
            <tr>
              <th
                  v-for="(c, index) in COLUMNS"
                  :key="index"
              >
                {{c.title}}
              </th>
            </tr>
            </thead>
            <tbody class="card-body__grid">
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
            </tbody>
          </table>
        </div>
      </div>
      <Pagination
          :totals="AUTO_TIRES_TOTALS"
          @setPageByTotal="setPageByTotal"
      />
    </div>
  </div>
</template>

<script>
  import {COLUMNS} from "@/components/autoTires/constants/constants";
  import Pagination from "@/components/UI/BasePagination.vue";
  import {mapActions, mapGetters} from "vuex";

  export default {
    name: "AutoTiresList",

    mounted() {
      this.GET_AUTO_TIRES_FROM_API(this.param.pageNum);
      this.GET_AUTO_TIRES_TOTALS();
    },

    components: {
      Pagination,
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
@import "/node_modules/lightbox2/dist/css/lightbox.min.css";
@import "@/assets/scss/table-adaptive.scss";
</style>
