import axios from "axios";
import {KEYS} from '/src/constants/constants';

export default {
    namespaced: true,

    state: {
        autoParts: {}
    },
    getters: {
        AUTO_PARTS(state) {
            return state.autoParts;
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
    },
    mutations: {
        SET_AUTO_PARTS_TO_STATE: (state, autoParts) => {
            state.autoParts = {};
            state.autoParts = autoParts;
        },
    }
}