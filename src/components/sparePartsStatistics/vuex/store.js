import axios from 'axios';
import { DOMAIN_API, KEYS } from '/src/constants/constants';
import { ENDPOINTS } from '@/components/sparePartsStatistics/constants/constants';

export default {
  namespaced: true,
  state: {
    sparePartsStatistics: {},
    sparePartsStatisticsDay: {},
    totalsSparePartsStatistics: 0,
  },
  getters: {
    SPARE_PARTS_STATISTICS: (state) => state.sparePartsStatistics,
    TOTALS_SPARE_PARTS_STATISTICS: (state) => state.totalsSparePartsStatistics,
    SPARE_PARTS_STATISTICS_DAY: (state) => state.sparePartsStatisticsDay,
  },
  actions: {
    async GET_SPARE_PARTS_STATISTICS({ commit }, param) {
      try {
        this.dispatch('generalStore/LOCK_UI');

        const response = await axios.get(ENDPOINTS.GET_SPARE_PARTS_STATISTICS, {
          key: KEYS,
          page: param,
        });

        this.dispatch('generalStore/UN_LOCK_UI');
        commit('SET_SPARE_PARTS_STATISTICS_TO_STATE', response.data.data);

        return response.data.data;
      } catch (e) {
        console.error(e);
        return e;
      }
    },
    async GET_SPARE_PARTS_STATISTICS_TOTALS({ commit }) {
      try {
        const response = await axios.post(
          DOMAIN_API + ENDPOINTS.GET_SPARE_PARTS_STATISTICS_TOTALS,
          {
            key: KEYS,
          },
        );

        commit(
          'SET_TOTALS_SPARE_PARTS_STATISTICS',
          response.data.totalsSparePartsStatistics,
        );

        return response.data.totalsSparePartsStatistics;
      } catch (e) {
        console.error(e);
        return e;
      }
    },
    async GET_SPARE_PARTS_STATISTICS_DAY({ commit }) {
      try {
        this.dispatch('generalStore/LOCK_UI');

        const response = await axios.post(
          DOMAIN_API + ENDPOINTS.GET_SPARE_PARTS_STATISTICS_DAY,
          {
            key: KEYS,
          },
        );

        this.dispatch('generalStore/UN_LOCK_UI');
        commit(
          'SET_DAY_SPARE_PARTS_STATISTICS',
          response.data.sparePartsStatisticsDay,
        );

        return response.data.sparePartsStatisticsDay;
      } catch (e) {
        console.error(e);
        return e;
      }
    },
  },
  mutations: {
    SET_SPARE_PARTS_STATISTICS_TO_STATE: (state, sparePartsStatistics) => {
      state.sparePartsStatistics = Object.freeze(sparePartsStatistics);
    },
    SET_TOTALS_SPARE_PARTS_STATISTICS: (state, totalsSparePartsStatistics) => {
      state.totalsSparePartsStatistics = Object.freeze(
        totalsSparePartsStatistics,
      );
    },
    SET_DAY_SPARE_PARTS_STATISTICS: (state, sparePartsStatisticsDay) => {
      state.sparePartsStatisticsDay = Object.freeze(sparePartsStatisticsDay);
    },
  },
};
