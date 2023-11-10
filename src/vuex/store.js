import axios from "axios";
import {DOMAIN_API, KEYS} from '/src/constants/constants';

export default {
    namespaced: true,

    state: {
        notification: '',
        lockingPool: 0,
    },

    getters: {
        NOTIFICATION(state) {
            return state.notification;
        },
        IS_UI_LOCKED(state) {
            return state.lockingPool > 0
        },
    },

    actions: {
        LOCK_UI({commit}){
            commit('LOCK_UI');
        },

        UN_LOCK_UI({commit}){
            commit('UN_LOCK_UI');
        },

        NOTIFICATION_FROM_API({commit}) {
            return axios.post(
                DOMAIN_API + '/index.php?route=api/general/information/notifacation',
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
        LOCK_UI: (state) => {
            state.lockingPool++;
        },
        UN_LOCK_UI: (state) => {
            state.lockingPool--;
        },
    },
}