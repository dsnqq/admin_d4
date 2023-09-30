import Vue from 'vue';
import Vuex from 'vuex';
import carAdmin from './modules/carAdmin/carAdmin';
import sparePartsStatistics from './modules/sparePartsStatistics/sparePartsStatistics';
import tireStatistics from './modules/tireStatistics/tireStatistics';
import historyUsers from './modules/historyUsers/historyUsers';
import autoParts from './modules/autoParts/autoParts';
import orderSale from './modules/orderSale/orderSale';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        carAdmin,
        sparePartsStatistics,
        tireStatistics,
        historyUsers,
        autoParts,
        orderSale,
    },
    strict: process.env.NODE_ENV === 'development'
})