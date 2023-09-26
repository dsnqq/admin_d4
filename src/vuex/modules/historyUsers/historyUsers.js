import axios from "axios";
import {KEYS} from '/src/constants/constants';

export default {
    namespaced: true,
    state: {
        userHistoryList: {},
    },
    getters: {
        USER_HISTORY_LIST(state) {
            return state.userHistoryList;
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
    },
    mutations: {
        SET_USER_HISTORY_LIST: (state, userHistoryList) => {
            state.userHistoryList = userHistoryList;
        },
    },
}