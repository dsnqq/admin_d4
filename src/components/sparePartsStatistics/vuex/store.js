import axios from "axios";
import {DOMAIN_API, KEYS} from '/src/constants/constants';

export default {
    namespaced: true,
    state: {
        sparePartsStatistics: {},
        sparePartsStatisticsDay: {},
        totalsSparePartsStatistics: 0,
    },
    getters: {
        SPARE_PARTS_STATISTICS(state) {
            return state.sparePartsStatistics;
        },
        TOTALS_SPARE_PARTS_STATISTICS(state) {
            return state.totalsSparePartsStatistics;
        },
        SPARE_PARTS_STATISTICS_DAY(state) {
            return state.sparePartsStatisticsDay;
        },
    },
    actions: {
        async GET_SPARE_PARTS_STATISTICS({commit}, param) {
            this.dispatch('generalStore/LOCK_UI');
            return axios.post(
                DOMAIN_API + '/index.php?route=api/spare_parts_statistics/index',
                {
                    key: KEYS,
                    page: param,
                }
            )
                .then((response) => {
                    this.dispatch('generalStore/UN_LOCK_UI');
                    commit('SET_SPARE_PARTS_STATISTICS_TO_STATE', response.data.sparePartsStatistics);
                    return response.data.sparePartsStatistics;
                })
                .catch(function (error) {
                    console.log(error);
                    return error;
                });
        },

        GET_SPARE_PARTS_STATISTICS_TOTALS({commit}) {
            return  axios.post(
                DOMAIN_API + '/index.php?route=api/spare_parts_statistics/index/totals',
                {
                    key: KEYS,
                }
            )
                .then((response) => {
                    commit('SET_TOTALS_SPARE_PARTS_STATISTICS', response.data.totalsSparePartsStatistics);
                    return response.data.totalsSparePartsStatistics;
                })
                .catch(function (error) {
                    console.log(error);
                    return error;
                });
        },

        GET_SPARE_PARTS_STATISTICS_DAY({commit}) {
            this.dispatch('generalStore/LOCK_UI');
            return  axios.post(
                DOMAIN_API + '/index.php?route=api/spare_parts_statistics/index/day',
                {
                    key: KEYS,
                }
            )
                .then((response) => {
                    this.dispatch('generalStore/UN_LOCK_UI');
                    commit('SET_DAY_SPARE_PARTS_STATISTICS', response.data.sparePartsStatisticsDay);
                    return response.data.sparePartsStatisticsDay;
                })
                .catch(function (error) {
                    console.log(error);
                    return error;
                });
        },
    },
    mutations: {
        SET_SPARE_PARTS_STATISTICS_TO_STATE: (state, sparePartsStatistics) => {
            state.sparePartsStatistics = Object.freeze(sparePartsStatistics);
        },
        SET_TOTALS_SPARE_PARTS_STATISTICS: (state, totalsSparePartsStatistics) => {
            state.totalsSparePartsStatistics = Object.freeze(totalsSparePartsStatistics);
        },
        SET_DAY_SPARE_PARTS_STATISTICS: (state, sparePartsStatisticsDay) => {
            state.sparePartsStatisticsDay = Object.freeze(sparePartsStatisticsDay);
        },
    }
}