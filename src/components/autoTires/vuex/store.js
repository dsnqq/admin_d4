import axios from 'axios';
import { DOMAIN_API, KEYS } from '/src/constants/constants';
import { ENDPOINTS } from '@/components/autoTires/constants/constants';

export default {
  namespaced: true,

  state: {
    autoTires: {},
    autoTiresIndex: {},
    autoTiresTotals: 0,
  },
  getters: {
    AUTO_TIRES: (state) => state.autoTires,
    AUTO_TIRES_TOTALS: (state) => state.autoTiresTotals,
    AUTO_TIRES_INDEX: (state) => state.autoTiresIndex,
  },
  actions: {
    async GET_AUTO_TIRES_FROM_API({ commit }, param) {
      try {
        this.dispatch('generalStore/LOCK_UI');

        const response = await axios.post(
          DOMAIN_API + ENDPOINTS.GET_AUTO_TIRES_FROM_API,
          {
            key: KEYS,
            page: param,
          },
        );

        this.dispatch('generalStore/UN_LOCK_UI');
        commit('SET_AUTO_TIRES_TO_STATE', response.data.autoTires);

        return response.data.autoTires;
      } catch (e) {
        console.error(e);

        return e;
      }
    },
    async GET_AUTO_TIRES_TOTALS({ commit }) {
      try {
        const response = await axios.post(
          DOMAIN_API + ENDPOINTS.GET_AUTO_TIRES_TOTALS,
          {
            key: KEYS,
          },
        );

        commit('SET_AUTO_TIRES_TOTALS_STATE', response.data.autoTiresTotals);

        return response.data.autoTiresTotals;
      } catch (e) {
        console.error(e);

        return e;
      }
    },
    async CHANGE_AUTO_TIRES_STATUS({ commit }, param) {
      try {
        this.dispatch('generalStore/LOCK_UI');

        await axios.post(
          DOMAIN_API + ENDPOINTS.CHANGE_AUTO_TIRES_STATUS + param.id,
          {
            key: KEYS,
            status: param.status,
          },
        );

        this.dispatch('generalStore/UN_LOCK_UI');

        commit('SET_CHANGE_AUTO_TIRES_STATUS', param);
      } catch (e) {
        console.error(e);

        return e;
      }
    },
    async GET_AUTO_TIRES_INDEX({ commit }, param) {
      try {
        const response = axios.post(
          DOMAIN_API + ENDPOINTS.GET_AUTO_TIRES_INDEX + param.id,
          {
            key: KEYS,
            param: param,
          },
        );

        commit('SET_AUTO_TIRES_INDEX_STATE', response.data.autoTiresIndex);
        return response.data.autoTiresIndex;
      } catch (e) {
        console.error(e);

        return e;
      }
    },
    async SET_AUTO_TIRES_IMAGE_FROM_LIST({ commit }, param) {
      try {
        this.dispatch('generalStore/LOCK_UI');

        await axios.post(
          DOMAIN_API +
            ENDPOINTS.SET_AUTO_TIRES_IMAGE_FROM_LIST +
            param.autoPartsId,
          {
            key: KEYS,
            images: param.images.toString(),
          },
        );
        this.dispatch('generalStore/UN_LOCK_UI');

        commit('ADD_AUTO_TIRES_IMAGE_FROM_LIST');
      } catch (e) {
        console.error(e);

        return e;
      }
    },
    async CHANGE_AUTO_TIRES_PRICE({ commit }, param) {
      try {
        this.dispatch('generalStore/LOCK_UI');

        const response = await axios.post(
          DOMAIN_API + ENDPOINTS.CHANGE_AUTO_TIRES_PRICE + param.id,
          {
            key: KEYS,
            price: param.priceUSD,
          },
        );

        this.dispatch('generalStore/UN_LOCK_UI');

        commit('SET_CHANGE_AUTO_TIRES_PRICE', {
          priceBYN: response.data.autoTiresPriceChange.priceBYN,
          priceUSD: response.data.autoTiresPriceChange.priceUSD,
          index: param.index,
        });
      } catch (e) {
        console.error(e);

        return e;
      }
    },

    async DELET_AUTO_TIRES_BY_API({ commit }, param) {
      try {
        await axios.post(
          DOMAIN_API + ENDPOINTS.DELET_AUTO_TIRES_BY_API + param.autoTiresId,
          {
            key: KEYS,
          },
        );

        commit('DELETE_THIS_AUTO_TIRES', param.autoTiresNumber);
      } catch (e) {
        console.error(e);

        return e;
      }
    },

    SET_SHOW_ALL_IMAGE({ commit }, id) {
      commit('SHOW_ALL_IMAGE_BY_ID', id);
    },

    async EDIT_AUTO_TIRES_FROM_API({ commit }, param) {
      try {
        if (!param.redirect) {
          this.dispatch('generalStore/LOCK_UI');
        }

        await axios.post(
          DOMAIN_API + ENDPOINTS.EDIT_AUTO_TIRES_FROM_API + param.id + '/edit',
          param.autoTires,
        );

        if (param.redirect) {
          window.location.href = '/auto-tires';
          return false;
        }

        this.dispatch('generalStore/UN_LOCK_UI');
        commit('EDIT_AUTO_TIRES_ON_STATE');

        return param.autoTires;
      } catch (e) {
        console.error(e);

        return e;
      }
    },
    async SET_AUTO_TIRES_FROM_API({ commit }, param) {
      try {
        this.dispatch('generalStore/LOCK_UI');

        const response = await axios.post(
          DOMAIN_API + ENDPOINTS.SET_AUTO_TIRES_FROM_API,
          param.fields,
        );

        if (typeof response.data.autoTiresCreate === 'string') {
          alert(response.data.autoTiresCreate);

          return false;
        }

        if (param.redirect) {
          window.location.href = '/auto-tires';
          return false;
        }

        this.dispatch('generalStore/UN_LOCK_UI');

        commit('ADD_AUTO_TIRES_TO_STATE');
        return param;
      } catch (e) {
        console.error(e);

        return e;
      }
    },
    RESET_AUTO_TIRES_FOR_CREATE_PAGE({ commit }) {
      commit('RESET_AUTO_TIRES');
    },
    SET_AUTO_TIRES_IMAGE_FROM_USER({ commit }, param) {
      commit('ADD_AUTO_TIRES_IMAGE', param);
      return param;
    },
  },
  mutations: {
    ADD_AUTO_TIRES_IMAGE_FROM_LIST: () => {
      alert('Изображения добавлены!');
    },
    ADD_AUTO_TIRES_TO_STATE: () => {
      alert('Добавлено объявление!');
    },
    ADD_AUTO_TIRES_IMAGE: (state, file) => {
      if (!state.autoTiresIndex.images) {
        state.autoTiresIndex.images = [];
      }
      if (!state.autoTiresIndex.imagesServer) {
        state.autoTiresIndex.imagesServer = [];
      }

      state.autoTiresIndex.images.push(file.dataURL);
      state.autoTiresIndex.imagesServer.push(file.upload.filename);
    },
    EDIT_AUTO_TIRES_ON_STATE: () => {
      alert('изменения сохранены!');
    },
    RESET_AUTO_TIRES: (state) => {
      state.autoTiresIndex = {};
    },
    SET_AUTO_TIRES_TO_STATE: (state, autoTires) => {
      state.autoTires = {};
      state.autoTires = autoTires;
    },
    SET_AUTO_TIRES_TOTALS_STATE: (state, autoTiresTotals) => {
      state.autoTiresTotals = autoTiresTotals;
    },
    SET_AUTO_TIRES_INDEX_STATE: (state, autoTiresIndex) => {
      state.autoTiresIndex = autoTiresIndex;
    },
    SET_CHANGE_AUTO_TIRES_PRICE: (state, param) => {
      state.autoTires[param.index].priceUSD = param.priceUSD;
      state.autoTires[param.index].priceBYN = param.priceBYN;
    },
    SET_CHANGE_AUTO_TIRES_STATUS: (state, param) => {
      state.autoTires[param.index].status = !parseInt(param.status);
    },
    SHOW_ALL_IMAGE_BY_ID: (state, id) => {
      if (!state.autoTires[id].imagesShowAllImage) {
        state.autoTires[id].imagesShowAllImage = true;

        for (let i = 0; i < state.autoTires[id].images.length; i++) {
          state.autoTires[id].images[i].imageShow = true;
        }
      }
    },
    DELETE_THIS_AUTO_TIRES: (state, id) => {
      state.autoTiresTotals = state.autoTiresTotals - 1;
      state.autoTires.splice(id, 1);

      alert('Объявление удалено!');
    },
  },
};
