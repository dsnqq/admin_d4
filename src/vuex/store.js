import axios from 'axios';
import { DOMAIN_API, KEYS } from '/src/constants/constants';
import { ENDPOINTS } from '@/constants/constants';

export default {
  namespaced: true,

  state: {
    notification: '',
    lockingPool: 0,
  },

  getters: {
    NOTIFICATION: (state) => state.notification,
    IS_UI_LOCKED: (state) => state.lockingPool > 0,
  },

  actions: {
    LOCK_UI({ commit }) {
      commit('LOCK_UI');
    },

    UN_LOCK_UI({ commit }) {
      commit('UN_LOCK_UI');
    },

    async NOTIFICATION_FROM_API({ commit }) {
      try {
        const response = await axios.post(
          DOMAIN_API + ENDPOINTS.NOTIFICATION_FROM_API,
          {
            key: KEYS,
          },
        );

        commit('SET_NOTIFICATION_STATE', response.data.notification);
        if (response.data.notification !== null) {
          setTimeout(() => {
            this.dispatch('generalStore/NOTIFICATION_FROM_API');
          }, 600000);
        }

        return response.data.notification;
      } catch (e) {
        console.error(e);

        return e;
      }
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
};
