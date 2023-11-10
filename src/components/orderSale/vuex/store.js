import axios from "axios";
import {DOMAIN_API, KEYS} from '/src/constants/constants';

export default {
    namespaced: true,

    state: {
        orders: {},
        totals: 0
    },
    getters: {
        ORDER_SALE(state) {
            return state.orders;
        },
        ORDER_TOTALS(state) {
            return state.totals;
        },
    },
    actions: {
        GET_ORDER_SALE({commit}, page) {
            return axios.post(
                DOMAIN_API + '/index.php?route=api/order_sale/index/' + page,
                {
                    key: KEYS,
                }
            )
                .then((response) => {
                    commit('SET_ORDER_SALE', response.data.orders);
                    return response.data.orders;
                })
                .catch(function (error) {
                    console.log(error);
                    return error;
                });
        },

        GET_ORDER_TOTALS({commit}) {
            return axios.post(
                DOMAIN_API + '/index.php?route=api/order_sale/index/totals',
                {
                    key: KEYS,
                }
            )
                .then((response) => {
                    commit('SET_ORDER_TOTALS', response.data.totals);
                    return response.data.totals;
                })
                .catch(function (error) {
                    console.log(error);
                    return error;
                });
        },
    },
    mutations: {
        SET_ORDER_SALE: (state, orders) => {
            state.orders = Object.freeze(orders);
        },
        SET_ORDER_TOTALS: (state, totals) => {
            state.totals = Object.freeze(totals);
        },
    }
}