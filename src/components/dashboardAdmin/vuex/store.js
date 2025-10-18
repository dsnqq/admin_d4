import axios from 'axios';
import { DOMAIN_API, KEYS } from '/src/constants/constants';
import { ENDPOINTS } from '@/components/dashboardAdmin/constants/constants';

export default {
  namespaced: true,

  state: {
    dashboardInformations: {},
  },
  getters: {
    DASHBOARD_INFORMATION: (state) => state.dashboardInformations,
  },
  actions: {
    async GET_DASHBOARD_INFORMATION({ commit }) {
      try {
        this.dispatch('generalStore/LOCK_UI');

        const response = await axios.post(
          DOMAIN_API + ENDPOINTS.GET_DASHBOARD_INFORMATION,
          {
            key: KEYS,
          },
        );

        this.dispatch('generalStore/UN_LOCK_UI');
        commit(
          'SET_DASHBOARD_INFORMATION',
          response.data.dashboardInformations,
        );

        return response.data.dashboardInformations;
      } catch (e) {
        console.error(e);

        return e;
      }
    },
    async SET_CURRENCY_FROM_API({ commit }, param) {
      try {
        await axios.post(DOMAIN_API + ENDPOINTS.SET_CURRENCY_FROM_API, {
          currency: param.currency,
          value: param.value,
        });

        commit('SET_CURRENCY');

        return param;
      } catch (e) {
        console.error(e);

        return e;
      }
    },
  },
  mutations: {
    SET_CURRENCY: () => alert('Курс изменен!'),
    SET_DASHBOARD_INFORMATION: (state, dashboardInformations) => {
      state.dashboardInformations = Object.freeze(dashboardInformations);
    },
  },
};
