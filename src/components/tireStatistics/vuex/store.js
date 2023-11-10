import axios from "axios";
import {DOMAIN_API, KEYS} from '/src/constants/constants';

export default {
    namespaced: true,
    state: {
        tireStatistics: {},
        tireStatisticsDay: {},
        totalsTireStatistics: 0,
    },
    getters: {
        TIRE_STATISTICS(state) {
            return state.tireStatistics;
        },
        TOTALS_TIRE_STATISTICS(state) {
            return state.totalsTireStatistics;
        },
        TIRE_STATISTICS_DAY(state) {
            return state.tireStatisticsDay;
        },
    },
    actions: {
        async GET_TIRE_STATISTICS({commit}, param) {
            this.dispatch('generalStore/LOCK_UI');
            return axios.post(
                DOMAIN_API + '/index.php?route=api/tire_statistics/index',
                {
                    key: KEYS,
                    page: param,
                }
            )
                .then((response) => {
                    this.dispatch('generalStore/UN_LOCK_UI');
                    commit('SET_TIRE_STATISTICS_TO_STATE', response.data.tireStatistics);
                    return response.data.tireStatistics;
                })
                .catch(function (error) {
                    console.log(error);
                    return error;
                });
        },

        GET_TIRE_STATISTICS_TOTALS({commit}) {
            return  axios.post(
                DOMAIN_API + '/index.php?route=api/tire_statistics/index/totals',
                {
                    key: KEYS,
                }
            )
                .then((response) => {
                    commit('SET_TOTALS_TIRE_STATISTICS', response.data.totalsTireStatistics);
                    return response.data.totalsTireStatistics;
                })
                .catch(function (error) {
                    console.log(error);
                    return error;
                });
        },

        GET_TIRE_STATISTICS_DAY({commit}) {
            this.dispatch('generalStore/LOCK_UI');
            return  axios.post(
                DOMAIN_API + '/index.php?route=api/tire_statistics/index/day',
                {
                    key: KEYS,
                }
            )
                .then((response) => {
                    this.dispatch('generalStore/UN_LOCK_UI');
                    commit('SET_DAY_TIRE_STATISTICS', response.data.tireStatisticsDay);
                    return response.data.tireStatisticsDay;
                })
                .catch(function (error) {
                    console.log(error);
                    return error;
                });
        },
    },
    mutations: {
        SET_TIRE_STATISTICS_TO_STATE: (state, tireStatistics) => {
            state.tireStatistics = Object.freeze(tireStatistics);
        },
        SET_TOTALS_TIRE_STATISTICS: (state, totalsTireStatistics) => {
            state.totalsTireStatistics = Object.freeze(totalsTireStatistics);
        },
        SET_DAY_TIRE_STATISTICS: (state, tireStatisticsDay) => {
            state.tireStatisticsDay = Object.freeze(tireStatisticsDay);
        },
    }
}