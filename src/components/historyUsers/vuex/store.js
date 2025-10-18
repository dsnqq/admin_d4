import axios from 'axios';
import { DOMAIN_API, KEYS } from '/src/constants/constants';
import { ENDPOINTS } from '@/components/historyUsers/constants/constants';

export default {
  namespaced: true,
  state: {
    userHistoryList: {},
    userHistory: {},
    userHistoryTotal: 0,
  },
  getters: {
    USER_HISTORY_LIST: (state) => state.userHistoryList,
    USER_HISTORY: (state) => state.userHistory,
    USER_HISTORY_TOTAL: (state) => state.userHistoryTotal,
    IS_UI_LOCKED: (state) => state.lockingPool > 0,
  },
  actions: {
    async GET_USER_HISTORY_LIST({ commit }, param) {
      this.dispatch('generalStore/LOCK_UI');
      try {
        const response = await axios.post(
          DOMAIN_API + ENDPOINTS.GET_USER_HISTORY_LIST,
          {
            key: KEYS,
            page: param,
          },
        );

        this.dispatch('generalStore/UN_LOCK_UI');
        commit('SET_USER_HISTORY_LIST', response.data.userHistoryList);
        return response.data.userHistoryList;
      } catch (e) {
        console.error(e);
        return e;
      }
    },
    async GET_USER_HISTORY({ commit }, param) {
      this.dispatch('generalStore/LOCK_UI');
      try {
        const response = await axios.post(
          DOMAIN_API + ENDPOINTS.GET_USER_HISTORY + param.user_id,
          {
            page: param.page,
            key: KEYS,
          },
        );

        this.dispatch('generalStore/UN_LOCK_UI');
        commit('SET_USER_HISTORY', response.data.userHistory);
        return response.data.userHistory;
      } catch (e) {
        console.error(e);
        return e;
      }
    },
    async GET_USER_HISTORY_TOTAL({ commit }, user_id) {
      try {
        const response = await axios.post(
          DOMAIN_API + ENDPOINTS.GET_USER_HISTORY_TOTAL + user_id + '/total',
          {
            key: KEYS,
          },
        );
        commit('SET_USER_HISTORY_TOTAL', response.data.userHistoryTotal);
        return response.data.userHistoryTotal;
      } catch (e) {
        console.error(e);
        return e;
      }
    },
  },
  mutations: {
    SET_USER_HISTORY_LIST: (state, userHistoryList) => {
      state.userHistoryList = Object.freeze(userHistoryList);
    },
    SET_USER_HISTORY: (state, userHistory) => {
      state.userHistory = Object.freeze(userHistory);
    },
    SET_USER_HISTORY_TOTAL: (state, userHistoryTotal) => {
      state.userHistoryTotal = Object.freeze(userHistoryTotal);
    },
  },
};
