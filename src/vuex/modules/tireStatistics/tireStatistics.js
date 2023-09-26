import axios from "axios";
import {KEYS} from '/src/constants/constants';

export default {
    namespaced: true,
    state: {
        tireStatistics: {},
        tireStatisticsDay: {},
        totalsTireStatistics: 0,
        lockingPool: 0
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
        IS_UI_LOCKED(state) {
            return state.lockingPool > 0
        },
    },
    actions: {
        async GET_TIRE_STATISTICS({commit}, param) {
            commit('LOCK_UI');
            return axios.post(
                '/index.php?route=api/tire_statistics/index',
                {
                    key: KEYS,
                    page: param,
                }
            )
                .then((response) => {
                    commit('UN_LOCK_UI');
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
                '/index.php?route=api/tire_statistics/index/totals',
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
            commit('LOCK_UI');
            return  axios.post(
                '/index.php?route=api/tire_statistics/index/day',
                {
                    key: KEYS,
                }
            )
                .then((response) => {
                    commit('UN_LOCK_UI');
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
            state.tireStatistics = tireStatistics;
        },
        SET_TOTALS_TIRE_STATISTICS: (state, totalsTireStatistics) => {
            state.totalsTireStatistics = totalsTireStatistics;
        },
        SET_DAY_TIRE_STATISTICS: (state, tireStatisticsDay) => {
            state.tireStatisticsDay = tireStatisticsDay;
        },
        LOCK_UI: (state) => {
            state.lockingPool++;
        },
        UN_LOCK_UI: (state) => {
            state.lockingPool--;
        },
    }
}