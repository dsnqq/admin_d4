<template>
  <div class="dashboard-admin">
    <div
      v-if="DASHBOARD_INFORMATION.sectionS"
      class="row row-cols-1 row-cols-lg-2 row-cols-xl-2 row-cols-xxl-2"
    >
      <div
        v-for="(s, i) in DASHBOARD_INFORMATION.sectionS"
        :key="i"
        class="col"
      >
        <div class="dashboard-admin__card card overflow-hidden radius-10">
          <div class="card-body">
            <div
              class="d-flex align-items-stretch justify-content-between overflow-hidden"
            >
              <div>
                <p>{{ s.title }}</p>
                <h4>{{ s.text }}</h4>
              </div>
              <div>
                <p class="mb-3 float-end" :class="s.iconColorClass">
                  <i :class="s.iconClass"></i>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div
      v-if="DASHBOARD_INFORMATION.sectionM"
      class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 row-cols-xxl-2"
    >
      <div
        v-for="(m, i) in DASHBOARD_INFORMATION.sectionM"
        :key="i"
        class="col"
      >
        <div class="dashboard-admin__card card radius-10">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div>
                <p class="mb-1">{{ m.title }}</p>
                <h4 :class="m.colorClass" class="mb-0">{{ m.result }} шт.</h4>
              </div>
              <div :class="m.colorClass" class="ms-auto fs-2">
                <i :class="m.iconClass"></i>
              </div>
            </div>
            <hr class="my-2" />
            <small class="mb-0">
              <i class="bi bi-arrow-up"></i>
              <span>{{ m.text }}</span>
            </small>
          </div>
        </div>
      </div>
    </div>
    <div
      v-if="DASHBOARD_INFORMATION.currency"
      class="row row-cols-2 row-cols-sm-3 row-cols-md-3 row-cols-xl-3 row-cols-xxl-3"
    >
      <div class="col">
        <div class="card radius-10">
          <div class="card-body text-center">
            <div class="widget-icon mx-auto mb-3 bg-light-success text-success">
              <i class="bi bi-currency-dollar"></i>
            </div>
            <h3>
              <input
                v-if="columnEditUSD"
                placeholder="Курс USD"
                v-model="DASHBOARD_INFORMATION.currency.USD"
                class="dashboard-admin__input--edits"
                type="text"
              />
              <span v-else>
                {{ DASHBOARD_INFORMATION.currency.USD }}
              </span>
              <i
                v-if="!columnEditUSD"
                @click="editCurrencyUSD"
                class="bi bi-pencil text-warning"
              ></i>
              <i
                v-else
                @click="saveCurrencyUSD"
                class="lni lni-save p-2 text-success"
              ></i>
            </h3>
            <p class="mb-0">Доллар США (USD)</p>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card radius-10">
          <div class="card-body text-center">
            <div class="widget-icon mx-auto mb-3 bg-light-primary text-primary">
              <i class="bi bi-cash"></i>
            </div>
            <h3>
              <input
                v-if="columnEditRUB"
                placeholder="Курс RUB"
                v-model="DASHBOARD_INFORMATION.currency.RUB"
                class="dashboard-admin__input--edits"
                type="text"
              />
              <span v-else>
                {{ DASHBOARD_INFORMATION.currency.RUB }}
              </span>
              <i
                v-if="!columnEditRUB"
                @click="editCurrencyRUB"
                class="bi bi-pencil text-warning"
              ></i>
              <i
                v-else
                @click="saveCurrencyRUB"
                class="lni lni-save p-2 text-success"
              ></i>
            </h3>
            <p class="mb-0">Рос. рубль (RUB)</p>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card radius-10">
          <div class="card-body text-center">
            <div class="widget-icon mx-auto mb-3 bg-light-orange text-orange">
              <i class="bi bi-currency-euro"></i>
            </div>
            <h3>
              <h3>
                <input
                  v-if="columnEditEUR"
                  placeholder="Курс EUR"
                  v-model="DASHBOARD_INFORMATION.currency.EUR"
                  class="dashboard-admin__input--edits"
                  type="text"
                />
                <span v-else>
                  {{ DASHBOARD_INFORMATION.currency.EUR }}
                </span>
                <i
                  v-if="!columnEditEUR"
                  @click="editCurrencyEUR"
                  class="bi bi-pencil text-warning"
                ></i>
                <i
                  v-else
                  @click="saveCurrencyEUR"
                  class="lni lni-save p-2 text-success"
                ></i>
              </h3>
            </h3>
            <p class="mb-0">Евро (EUR)</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";

export default {
  name: "DashboardAdmin",

  mounted() {
    this.GET_DASHBOARD_INFORMATION();
  },

  computed: {
    ...mapGetters("dashboardAdmin", ["DASHBOARD_INFORMATION"]),
  },

  methods: {
    ...mapActions("dashboardAdmin", [
      "GET_DASHBOARD_INFORMATION",
      "SET_CURRENCY_FROM_API",
    ]),

    saveCurrencyUSD() {
      let param = {
        currency: "USD",
        value: this.DASHBOARD_INFORMATION.currency.USD,
      };

      this.SET_CURRENCY_FROM_API(param);
      this.editCurrencyUSD();
    },

    saveCurrencyRUB() {
      let param = {
        currency: "RUB",
        value: this.DASHBOARD_INFORMATION.currency.RUB,
      };

      this.SET_CURRENCY_FROM_API(param);
      this.editCurrencyRUB();
    },

    saveCurrencyEUR() {
      let param = {
        currency: "EUR",
        value: this.DASHBOARD_INFORMATION.currency.EUR,
      };

      this.SET_CURRENCY_FROM_API(param);
      this.editCurrencyEUR();
    },

    editCurrencyUSD() {
      this.columnEditUSD = !this.columnEditUSD;
    },

    editCurrencyRUB() {
      this.columnEditRUB = !this.columnEditRUB;
    },

    editCurrencyEUR() {
      this.columnEditEUR = !this.columnEditEUR;
    },
  },

  data() {
    return {
      columnEditUSD: false,
      columnEditRUB: false,
      columnEditEUR: false,
    };
  },
};
</script>

<style lang="scss" scoped>
@import "@/components/dashboardAdmin/style/dashboard-admin.scss";
</style>
