import axios from 'axios';
import { KEYS, DOMAIN_API } from '/src/constants/constants';
import { ENDPOINTS } from '@/components/autoTiresArchive/constants/constants';

export default {
  namespaced: true,

  state: {
    autoTiresArchive: {},
    autoTiresArchiveIndex: {},
    autoTiresArchiveTotals: 0,
    autoTiresArchiveHistory: {},
  },
  getters: {
    AUTO_TIRES_ARCHIVE: (state) => state.autoTiresArchive,
    AUTO_TIRES_ARCHIVE_TOTALS: (state) => state.autoTiresArchiveTotals,
  },
  actions: {
    async GET_AUTO_TIRES_ARCHIVE_FROM_API({ commit }, param) {
      try {
        this.dispatch('generalStore/LOCK_UI');

        const response = await axios.post(
          DOMAIN_API + ENDPOINTS.GET_AUTO_TIRES_ARCHIVE_FROM_API,
          {
            key: KEYS,
            page: param,
          },
        );

        this.dispatch('generalStore/UN_LOCK_UI');
        commit(
          'SET_AUTO_TIRES_ARCHIVE_TO_STATE',
          response.data.autoTiresArchive,
        );
        return response.data.autoTiresArchive;
      } catch (e) {
        console.error(e);

        return e;
      }
    },
    async GET_AUTO_TIRES_ARCHIVE_TOTALS({ commit }) {
      try {
        const response = await axios.post(
          DOMAIN_API + ENDPOINTS.GET_AUTO_TIRES_ARCHIVE_TOTALS,
          {
            key: KEYS,
          },
        );

        commit(
          'SET_AUTO_TIRES_ARCHIVE_TOTALS_STATE',
          response.data.autoTiresArchiveTotals,
        );

        return response.data.autoTiresArchiveTotals;
      } catch (e) {
        console.error(e);

        return e;
      }
    },

    async RESTORE_AUTO_TIRES_ARCHIVE_BY_API({ commit }, param) {
      try {
        await axios.post(
          DOMAIN_API +
            ENDPOINTS.RESTORE_AUTO_TIRES_ARCHIVE_BY_API +
            param.autoTiresId,
          {
            key: KEYS,
          },
        );

        commit('RESTORE_THIS_AUTO_TIRES_ARCHIVE', param.autoTiresNumber);
      } catch (e) {
        console.error(e);

        return e;
      }
    },
    SET_SHOW_ALL_IMAGE({ commit }, id) {
      commit('SHOW_ALL_IMAGE_BY_ID', id);
    },
  },
  mutations: {
    SET_AUTO_TIRES_ARCHIVE_TO_STATE: (state, autoTiresArchive) => {
      state.autoTiresArchive = {};
      state.autoTiresArchive = autoTiresArchive;
    },
    SET_AUTO_TIRES_ARCHIVE_TOTALS_STATE: (state, autoTiresArchiveTotals) => {
      state.autoTiresArchiveTotals = autoTiresArchiveTotals;
    },
    SHOW_ALL_IMAGE_BY_ID: (state, id) => {
      if (!state.autoTiresArchive[id].imagesShowAllImage) {
        state.autoTiresArchive[id].imagesShowAllImage = true;

        for (let i = 0; i < state.autoTiresArchive[id].images.length; i++) {
          state.autoTiresArchive[id].images[i].imageShow = true;
        }
      }
    },
    RESTORE_THIS_AUTO_TIRES_ARCHIVE: (state, id) => {
      state.autoTiresArchiveTotals = state.autoTiresArchiveTotals - 1;
      state.autoTiresArchive.splice(id, 1);

      alert('Шина восстановлена!');
    },
  },
};
