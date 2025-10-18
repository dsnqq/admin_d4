import axios from 'axios';
import { DOMAIN_API, KEYS } from '/src/constants/constants';
import { ENDPOINTS } from '@/components/orderSale/constants/constants';

export default {
  namespaced: true,

  state: {
    orders: {},
    totals: 0,
  },
  getters: {
    ORDER_SALE: (state) => state.orders,
    ORDER_TOTALS: (state) => state.totals,
  },
  actions: {
    async GET_ORDER_SALE({ commit }, page) {
      try {
        const response = await axios.post(
          DOMAIN_API + ENDPOINTS.GET_ORDER_SALE + page,
          {
            key: KEYS,
          },
        );
        commit('SET_ORDER_SALE', response.data.orders);
        return response.data.orders;
      } catch (e) {
        console.error(e);
        return e;
      }
    },
    async GET_ORDER_TOTALS({ commit }) {
      try {
        const response = await axios.post(
          DOMAIN_API + ENDPOINTS.GET_ORDER_TOTALS,
          {
            key: KEYS,
          },
        );
        commit('SET_ORDER_TOTALS', response.data.totals);
        return response.data.totals;
      } catch (e) {
        console.error(e);
        return e;
      }
    },
  },
  mutations: {
    SET_ORDER_SALE: (state, orders) => {
      state.orders = Object.freeze(orders);
    },
    SET_ORDER_TOTALS: (state, totals) => {
      state.totals = Object.freeze(totals);
    },
  },
};
