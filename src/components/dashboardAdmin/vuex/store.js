import axios from "axios";
import {DOMAIN, KEYS} from '/src/constants/constants';

export default {
    namespaced: true,

    state: {
        dashboardInformations: {}
    },
    getters: {
        DASHBOARD_INFORMATION(state) {
            return state.dashboardInformations;
        },
    },
    actions: {
        GET_DASHBOARD_INFORMATION({commit}) { 
            this.dispatch('generalStore/LOCK_UI');
            return axios.post(
                DOMAIN + '/index.php?route=api/dashboard_admin/index',
                {
                    key: KEYS,
                }
            )
                .then((response) => {
                    this.dispatch('generalStore/UN_LOCK_UI');
                    commit('SET_DASHBOARD_INFORMATION', response.data.dashboardInformations);
                    return response.data.dashboardInformations;
                })
                .catch(function (error) {
                    console.log(error);
                    return error;
                });
        },

        SET_CURRENCY_FROM_API({commit}, param) {
            return axios.post(
                DOMAIN + '/index.php?route=api/dashboard_admin/index/currency',
                {
                    currency: param.currency,
                    value: param.value
                }
            )
                .then(() => {
                    commit('SET_CURRENCY');
                    return param;
                })
                .catch(function (error) {
                    console.log(error);
                    return error;
                });
        },
    },
    mutations: {
        SET_CURRENCY: () => {
            alert('Курс изменен!')
        },
        SET_DASHBOARD_INFORMATION: (state, dashboardInformations) => {
            state.dashboardInformations = Object.freeze(dashboardInformations);
        },
    }
}