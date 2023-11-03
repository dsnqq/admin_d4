<template>
  <div class="card">
    <div class="card-header py-2">
      <Filters
        :options="optionsFilters"
        @setFilterOnAutoPartsPage="setFilterOnAutoPartsPage"
        @resetFilters="resetFilters"
      />
    </div>
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
                  v-for="(auto, i) in AUTO_PARTS"
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
                      :images="auto.images"
                      :title="auto.autoParts.name"
                      :index="i"
                      :id="auto.product_id"
                      :showAll="auto.imagesShowAllImage"
                      :content="auto[c.content]"
                      :contentExtension="auto[c.contentExtension]"
                      :priceUSD="auto.priceUSD"
                      :priceBYN="auto.priceBYN"
                      :status="auto.status"
                      :linkToSite="auto.linkToSite"
                      :view="auto.view"
                  ></component>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <Pagination
          :totals="AUTO_PARTS_TOTALS"
          :storageCache="storageCache"
          :countChunk="isMobile ? 4 : 5"
          @setPageByTotal="setPageByTotal"
          :class="{'card-body-pagination-mobile' : isMobile}"
      />
      <BaseButtonFixedAdd
         component="autoPartsCreate"
      />
    </div>
  </div>
</template>

<script>
  import {COLUMNS} from "@/components/autoParts/constants/constants";
  import {autoPartsOptionsFilters} from "@/components/autoParts/mixins/autoPartsOptionsFilters.mixins";
  import {mixins} from "@/mixins/mixins";
  import {mapActions, mapGetters} from "vuex";

  export default {
    name: "AutoPartsList",

    mixins: [mixins, autoPartsOptionsFilters],

    mounted() {
      this.GET_AUTO_PARTS_FROM_API(this.param);
      this.GET_AUTO_PARTS_TOTALS(this.param);
    },

    components: {
      Filters: () => import("@/components/UI/BaseFilters.vue"),
      BaseButtonFixedAdd: () => import("@/components/UI/BaseButtonFixedAdd.vue"),
      Pagination: () => import("@/components/UI/BasePagination.vue")
    },

    computed: {
      ...mapGetters('autoParts', [
        'AUTO_PARTS',
        'AUTO_PARTS_TOTALS'
      ]),

      storageCache() {
        return (localStorage.getItem('localCacheFilters') !== null) ? JSON.parse(localStorage.localCacheFilters) : {};
      },
    },

    methods: {
      ...mapActions('autoParts', [
        'GET_AUTO_PARTS_FROM_API',
        'GET_AUTO_PARTS_TOTALS'
      ]),

      setFilterOnAutoPartsPage(param) {
        for (let key in param) {
          if(param[key] !== undefined) {
            this.param.filters[key] = param[key];
          }
        }

        this.GET_AUTO_PARTS_FROM_API(this.param);
        this.GET_AUTO_PARTS_TOTALS(this.param);
      },

      setPageByTotal(page) {
        this.param.pageNum = page;
        this.GET_AUTO_PARTS_FROM_API(this.param);
      },

      resetFilters() {
        this.param = {
            pageNum: this.param.pageNum,
            filters: {
              sparePartNumber: '',
              model: '',
              status: 'Все объявления',
              fuel: 'Не выбрано',
              value: '',
              yearStart: '',
              yearLast: '',
              types: {},
              car: {},
          }
        }

        this.GET_AUTO_PARTS_FROM_API(this.param);
        this.GET_AUTO_PARTS_TOTALS(this.param);
      },
    },

    data() {
      return {
        COLUMNS,
        param: {
          pageNum: 1,
          filters: {
            sparePartNumber: '',
            model: '',
            status: 'Все объявления',
            fuel: 'Не выбрано',
            value: '',
            yearStart: '',
            yearLast: '',
            types: {},
            car: {},
          }
        },
      };
    }
  }
</script>

<style lang="scss" scoped>
@import "./src/components/autoParts/style/auto-parts-list";
@import "@/assets/scss/table-adaptive.scss";
</style>
