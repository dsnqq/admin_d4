import Vue from 'vue';
import Vuex from 'vuex';
import carAdmin from '@/components/carsAdmin/vuex/store';
import sparePartsStatistics from '@/components/sparePartsStatistics/vuex/store';
import tireStatistics from '@/components/tireStatistics/vuex/store';
import historyUsers from '@/components/historyUsers/vuex/store';
import autoParts from '@/components/autoParts/vuex/store';
import autoPartsArchive from '@/components/autoPartsArchive/vuex/store';
import orderSale from '@/components/orderSale/vuex/store';
import dashboardAdmin from '@/components/dashboardAdmin/vuex/store';
import autoTires from '@/components/autoTires/vuex/store';
import autoTiresArchive from '@/components/autoTiresArchive/vuex/store';
import authAdmin from '@/components/authAdmin/vuex/store';
import generalStore from '@/vuex/store';

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    carAdmin,
    sparePartsStatistics,
    tireStatistics,
    historyUsers,
    autoParts,
    orderSale,
    dashboardAdmin,
    autoPartsArchive,
    autoTires,
    autoTiresArchive,
    authAdmin,
    generalStore,
  },
  strict: process.env.NODE_ENV === 'development',
});
