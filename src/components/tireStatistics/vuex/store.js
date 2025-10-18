import axios from 'axios';
import { DOMAIN_API, KEYS } from '/src/constants/constants';
import { ENDPOINTS } from '@/components/tireStatistics/constants/constants';

export default {
  namespaced: true,
  state: {
    tireStatistics: {},
    tireStatisticsDay: {},
    totalsTireStatistics: 0,
  },
  getters: {
    TIRE_STATISTICS: (state) => state.tireStatistics,
    TOTALS_TIRE_STATISTICS: (state) => state.totalsTireStatistics,
    TIRE_STATISTICS_DAY: (state) => state.tireStatisticsDay,
  },
  actions: {
    async GET_TIRE_STATISTICS({ commit }, param) {
      try {
        this.dispatch('generalStore/LOCK_UI');
        const response = await axios.post(
          DOMAIN_API + ENDPOINTS.GET_TIRE_STATISTICS,
          {
            key: KEYS,
            page: param,
          },
        );

        this.dispatch('generalStore/UN_LOCK_UI');
        commit('SET_TIRE_STATISTICS_TO_STATE', response.data.tireStatistics);

        return response.data.tireStatistics;
      } catch (e) {
        console.error(e);
        return e;
      }
    },
    async GET_TIRE_STATISTICS_TOTALS({ commit }) {
      try {
        const response = await axios.post(
          DOMAIN_API + ENDPOINTS.GET_TIRE_STATISTICS_TOTALS,
          {
            key: KEYS,
          },
        );
        commit(
          'SET_TOTALS_TIRE_STATISTICS',
          response.data.totalsTireStatistics,
        );
        return response.data.totalsTireStatistics;
      } catch (e) {
        console.error(e);

        return e;
      }
    },
    async GET_TIRE_STATISTICS_DAY({ commit }) {
      try {
        this.dispatch('generalStore/LOCK_UI');

        const response = await axios.post(
          DOMAIN_API + ENDPOINTS.GET_TIRE_STATISTICS_DAY,
          {
            key: KEYS,
          },
        );

        this.dispatch('generalStore/UN_LOCK_UI');
        commit('SET_DAY_TIRE_STATISTICS', response.data.tireStatisticsDay);

        return response.data.tireStatisticsDay;
      } catch (e) {
        console.error(e);

        return e;
      }
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
  },
};
