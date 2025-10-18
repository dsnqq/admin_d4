<template>
  <div class="dashboard-admin">
    <div
      v-if="dashboardInformation.sectionS"
      class="row row-cols-1 row-cols-lg-2 row-cols-xl-2 row-cols-xxl-2"
    >
      <div
        v-for="(s, i) in dashboardInformation.sectionS"
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
      v-if="dashboardInformation.sectionM"
      class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 row-cols-xxl-2"
    >
      <div
        v-for="(m, i) in dashboardInformation.sectionM"
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
      v-if="dashboardInformation.currency"
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
                v-model="dashboardInformation.currency.USD"
                placeholder="Курс USD"
                class="dashboard-admin__input--edits"
                type="text"
              />
              <span v-else>
                {{ dashboardInformation.currency.USD }}
              </span>
              <i
                v-if="!columnEditUSD"
                class="bi bi-pencil text-warning"
                @click="editCurrencyUSD"
              ></i>
              <i
                v-else
                class="lni lni-save p-2 text-success"
                @click="saveCurrencyUSD"
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
                v-model="dashboardInformation.currency.RUB"
                placeholder="Курс RUB"
                class="dashboard-admin__input--edits"
                type="text"
              />
              <span v-else>
                {{ dashboardInformation.currency.RUB }}
              </span>
              <i
                v-if="!columnEditRUB"
                class="bi bi-pencil text-warning"
                @click="editCurrencyRUB"
              ></i>
              <i
                v-else
                class="lni lni-save p-2 text-success"
                @click="saveCurrencyRUB"
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
                  v-model="dashboardInformation.currency.EUR"
                  placeholder="Курс EUR"
                  class="dashboard-admin__input--edits"
                  type="text"
                />
                <span v-else>
                  {{ dashboardInformation.currency.EUR }}
                </span>
                <i
                  v-if="!columnEditEUR"
                  class="bi bi-pencil text-warning"
                  @click="editCurrencyEUR"
                ></i>
                <i
                  v-else
                  class="lni lni-save p-2 text-success"
                  @click="saveCurrencyEUR"
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

<script setup>
import { useStore } from '@/composables/useStore';
import { computed, onMounted, ref, unref } from 'vue';

const store = useStore();

const columnEditUSD = ref(false);
const columnEditRUB = ref(false);
const columnEditEUR = ref(false);

onMounted(() => {
  store.dispatch('dashboardAdmin/GET_DASHBOARD_INFORMATION');
});

const dashboardInformation = computed(
  () => store.getters['dashboardAdmin/DASHBOARD_INFORMATION'],
);

const saveCurrencyUSD = () => {
  store.dispatch('dashboardAdmin/SET_CURRENCY_FROM_API', {
    currency: 'USD',
    value: dashboardInformation.value.currency.USD,
  });

  editCurrencyUSD();
};

const saveCurrencyRUB = () => {
  store.dispatch('dashboardAdmin/SET_CURRENCY_FROM_API', {
    currency: 'RUB',
    value: dashboardInformation.value.currency.RUB,
  });

  editCurrencyRUB();
};

const saveCurrencyEUR = () => {
  store.dispatch('dashboardAdmin/SET_CURRENCY_FROM_API', {
    currency: 'EUR',
    value: dashboardInformation.value.currency.EUR,
  });

  editCurrencyEUR();
};

const editCurrencyUSD = () => {
  columnEditUSD.value = !unref(columnEditUSD);
};

const editCurrencyRUB = () => {
  columnEditRUB.value = !unref(columnEditRUB);
};

const editCurrencyEUR = () => {
  columnEditEUR.value = !unref(columnEditEUR);
};
</script>

<style lang="scss" scoped>
@import '@/components/dashboardAdmin/style/dashboard-admin.scss';
</style>
