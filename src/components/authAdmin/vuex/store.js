import axios from 'axios';
import { DOMAIN_API, KEYS } from '/src/constants/constants';

export default {
  namespaced: true,

  state: {
    user: {},
  },
  getters: {
    USER(state) {
      return state.user;
    },
  },
  actions: {
    LOGIN_FROM_API({ commit }, param) {
      return axios
        .post(DOMAIN_API + '/index.php?route=api/user/login', {
          key: KEYS,
          login: param.login,
          password: param.password,
        })
        .then((response) => {
          commit('SET_LOGIN_STATE', response.data.user);
          return response.data.user;
        })
        .catch(function (error) {
          console.log(error);
          return error;
        });
    },
  },
  mutations: {
    SET_LOGIN_STATE: (state, user) => {
      state.user = user;
      localStorage.user = JSON.stringify(user);
    },
  },
};
