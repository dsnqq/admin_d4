import axios from "axios";
import { DOMAIN_API, KEYS } from "/src/constants/constants";

export default {
  namespaced: true,
  state: {
    userHistoryList: {},
    userHistory: {},
    userHistoryTotal: 0,
  },
  getters: {
    USER_HISTORY_LIST(state) {
      return state.userHistoryList;
    },
    USER_HISTORY(state) {
      return state.userHistory;
    },
    USER_HISTORY_TOTAL(state) {
      return state.userHistoryTotal;
    },
    IS_UI_LOCKED(state) {
      return state.lockingPool > 0;
    },
  },
  actions: {
    GET_USER_HISTORY_LIST({ commit }, param) {
      this.dispatch("generalStore/LOCK_UI");
      return axios
        .post(DOMAIN_API + "/index.php?route=api/history_users/index", {
          key: KEYS,
          page: param,
        })
        .then((response) => {
          this.dispatch("generalStore/UN_LOCK_UI");
          commit("SET_USER_HISTORY_LIST", response.data.userHistoryList);
          return response.data.userHistoryList;
        })
        .catch(function (error) {
          console.log(error);
          return error;
        });
    },
    GET_USER_HISTORY({ commit }, param) {
      this.dispatch("generalStore/LOCK_UI");
      return axios
        .post(
          DOMAIN_API +
            "/index.php?route=api/history_users/index/" +
            param.user_id,
          {
            page: param.page,
            key: KEYS,
          }
        )
        .then((response) => {
          this.dispatch("generalStore/UN_LOCK_UI");
          commit("SET_USER_HISTORY", response.data.userHistory);
          return response.data.userHistory;
        })
        .catch(function (error) {
          console.log(error);
          return error;
        });
    },
    GET_USER_HISTORY_TOTAL({ commit }, user_id) {
      return axios
        .post(
          DOMAIN_API +
            "/index.php?route=api/history_users/index/" +
            user_id +
            "/total",
          {
            key: KEYS,
          }
        )
        .then((response) => {
          commit("SET_USER_HISTORY_TOTAL", response.data.userHistoryTotal);
          return response.data.userHistoryTotal;
        })
        .catch(function (error) {
          console.log(error);
          return error;
        });
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
