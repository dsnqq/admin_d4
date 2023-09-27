import axios from "axios";
import {KEYS} from '/src/constants/constants';

export default {
    namespaced: true,
    state: {
        userHistoryList: {},
        userHistory: {}
    },
    getters: {
        USER_HISTORY_LIST(state) {
            return state.userHistoryList;
        },
        USER_HISTORY(state) {
            return state.userHistory;
        },
    },
    actions: {
        GET_USER_HISTORY_LIST({commit}, param) {
            return axios.post(
                '/index.php?route=api/history_users/index',
                {
                    key: KEYS,
                    page: param,
                }
            )
                .then((response) => {
                    commit('SET_USER_HISTORY_LIST', response.data.userHistoryList);
                    return response.data.userHistoryList;
                })
                .catch(function (error) {
                    console.log(error);
                    return error;
                });
        },
        GET_USER_HISTORY({commit}, user_id) {
            return axios.post(
                '/index.php?route=api/history_users/index/' + user_id,
                {
                    key: KEYS,
                }
            )
                .then((response) => {
                    commit('SET_USER_HISTORY', response.data.userHistory);
                    return response.data.userHistory;
                })
                .catch(function (error) {
                    console.log(error);
                    return error;
                });
        },
    },
    mutations: {
        SET_USER_HISTORY_LIST: (state, userHistoryList) => {
            state.userHistoryList = userHistoryList;
        },
        SET_USER_HISTORY: (state, userHistory) => {
            state.userHistory = userHistory;
        },
    },
}