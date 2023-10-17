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
            return axios.post(
                DOMAIN + '/index.php?route=api/dashboard_admin/index',
                {
                    key: KEYS,
                }
            )
                .then((response) => {
                    commit('SET_DASHBOARD_INFORMATION', response.data.dashboardInformations);
                    return response.data.dashboardInformations;
                })
                .catch(function (error) {
                    console.log(error);
                    return error;
                });
        },
    },
    mutations: {
        SET_DASHBOARD_INFORMATION: (state, dashboardInformations) => {
            state.dashboardInformations = Object.freeze(dashboardInformations);
        },
    }
}