import axios from "axios";
import {KEYS} from '/src/constants/constants';

export default {
    namespaced: true,

    state: {
        autoParts: {},
        autoPartsTotals: 0
    },
    getters: {
        AUTO_PARTS(state) {
            return state.autoParts;
        },
        AUTO_PARTS_TOTALS(state) {
            return state.autoPartsTotals;
        },
    },
    actions: {
        GET_AUTO_PARTS_FROM_API({commit}, param) {
            return axios.post(
                '/index.php?route=api/auto_parts/auto',
                {
                    key: KEYS,
                    page: param,
                }
            )
                .then((response) => {
                    commit('SET_AUTO_PARTS_TO_STATE', response.data.autoParts);
                    return response.data.autoParts;
                })
                .catch(function (error) {
                    console.log(error);
                    return error;
                });
        },

        GET_AUTO_PARTS_TOTALS({commit}) {
            return  axios.post(
                '/index.php?route=api/auto_parts/auto/totals',
                {
                    key: KEYS,
                }
            )
                .then((response) => {
                    commit('SET_AUTO_PARTS_TOTALS_STATE', response.data.autoPartsTotals);
                    return response.data.autoPartsTotals;
                })
                .catch(function (error) {
                    console.log(error);
                    return error;
                });
        },
    },
    mutations: {
        SET_AUTO_PARTS_TO_STATE: (state, autoParts) => {
            state.autoParts = {};
            state.autoParts = autoParts;
        },
        SET_AUTO_PARTS_TOTALS_STATE: (state, autoPartsTotals) => {
            state.autoPartsTotals = autoPartsTotals;
        },
    }
}