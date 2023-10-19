import axios from "axios";
import {DOMAIN, KEYS} from '/src/constants/constants';

export default {
    namespaced: true,

    state: {
        notification: ''
    },

    getters: {
        NOTIFICATION(state) {
            return state.notification;
        },
    },

    actions: {
        NOTIFICATION_FROM_API({commit}) {
            return axios.post(
                DOMAIN + '/index.php?route=api/general/information/notifacation',
                {
                    key: KEYS,
                }
            )
            .then((response) => {
                commit('SET_NOTIFICATION_STATE', response.data.notification);
                if (response.data.notification !== null) {
                    setTimeout(() => {
                        this.dispatch('generalStore/NOTIFICATION_FROM_API');
                    }, 600000);
                }
                return response.data.notification;
            })
            .catch(function (error) {
                console.log(error);
                return error;
            });
        },
    },

    mutations: {
        SET_NOTIFICATION_STATE: (state, notification) => {
            state.notification = notification;
        },
    },
}