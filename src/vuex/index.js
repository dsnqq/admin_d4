import Vue from 'vue';
import Vuex from 'vuex';
import carAdmin from './modules/carAdmin/carAdmin';
import sparePartsStatistics from './modules/sparePartsStatistics/sparePartsStatistics';
import tireStatistics from './modules/tireStatistics/tireStatistics';
import historyUsers from './modules/historyUsers/historyUsers';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        carAdmin,
        sparePartsStatistics,
        tireStatistics,
        historyUsers,
    },
    strict: process.env.NODE_ENV === 'development'
})