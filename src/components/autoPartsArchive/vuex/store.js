import axios from 'axios';
import { DOMAIN_API, KEYS } from '/src/constants/constants';

export default {
  namespaced: true,

  state: {
    autoPartsArchive: {},
    autoPartsArchiveIndex: {},
    autoPartsArchiveTotals: 0,
    autoPartsArchiveHistory: {},
    typesOfAutoPartsArchive: [],
    brandAndModelCar: [],
  },
  getters: {
    BREND_MODEL_CAR_AUTO_PARTS(state) {
      return state.brandAndModelCar;
    },
    TYPES_OF_AUTO_PARTS_ARCHIVE(state) {
      return state.typesOfAutoPartsArchive;
    },
    AUTO_PARTS_ARCHIVE(state) {
      return state.autoPartsArchive;
    },
    AUTO_PARTS_ARCHIVE_TOTALS(state) {
      return state.autoPartsArchiveTotals;
    },
    AUTO_PARTS_ARCHIVE_HISTORY(state) {
      return state.autoPartsArchiveHistory;
    },
  },
  actions: {
    async GET_BREND_MODEL_CAR_AUTO_PARTS({ commit }) {
      return await axios
        .post(DOMAIN_API + '/index.php?route=api/auto_parts/auto/category', {
          key: KEYS,
        })
        .then((response) => {
          commit(
            'SET_BREND_MODEL_CAR_AUTO_PARTS',
            response.data.brandAndModelCar,
          );
          return response.data.brandAndModelCar;
        })
        .catch(function (error) {
          console.log(error);
          return error;
        });
    },

    GET_AUTO_PARTS_ARCHIVE_FROM_API({ commit }, param) {
      this.dispatch('generalStore/LOCK_UI');
      return axios
        .post(DOMAIN_API + '/index.php?route=api/auto_parts_archive/auto', {
          key: KEYS,
          page: param.pageNum,
          filter_sparePartNumber: param.filters.sparePartNumber,
          filter_model: param.filters.model,
          filter_fuel: param.filters.fuel,
          filter_value: param.filters.value,
          filter_year_start: param.filters.yearStart,
          filter_year_last: param.filters.yearLast,
          filter_types: param.filters.types.code,
          filter_category: param.filters.car.code,
        })
        .then((response) => {
          this.dispatch('generalStore/UN_LOCK_UI');
          commit(
            'SET_AUTO_PARTS_ARCHIVE_TO_STATE',
            response.data.autoPartsArchive,
          );
          return response.data.autoPartsArchive;
        })
        .catch(function (error) {
          console.log(error);
          return error;
        });
    },

    GET_AUTO_PARTS_ARCHIVE_TOTALS({ commit }, param) {
      return axios
        .post(
          DOMAIN_API + '/index.php?route=api/auto_parts_archive/auto/totals',
          {
            key: KEYS,
            filter_sparePartNumber: param.filters.sparePartNumber,
            filter_model: param.filters.model,
            filter_fuel: param.filters.fuel,
            filter_value: param.filters.value,
            filter_year_start: param.filters.yearStart,
            filter_year_last: param.filters.yearLast,
            filter_types: param.filters.types.code,
            filter_category: param.filters.car.code,
          },
        )
        .then((response) => {
          commit(
            'SET_AUTO_PARTS_ARCHIVE_TOTALS_STATE',
            response.data.autoPartsArchiveTotals,
          );
          return response.data.autoPartsArchiveTotals;
        })
        .catch(function (error) {
          console.log(error);
          return error;
        });
    },

    GET_AUTO_PARTS_ARCHIVE_HISTORY({ commit }, id) {
      this.dispatch('generalStore/LOCK_UI');
      return axios
        .post(
          DOMAIN_API +
            '/index.php?route=api/auto_parts_archive/auto/history/' +
            id,
          {
            key: KEYS,
          },
        )
        .then((response) => {
          this.dispatch('generalStore/UN_LOCK_UI');
          commit(
            'SET_AUTO_PARTS_ARCHIVE_HISTORY_STATE',
            response.data.autoPartsArchiveHistory,
          );
          return response.data.autoPartsArchiveHistory;
        })
        .catch(function (error) {
          console.log(error);
          return error;
        });
    },

    async GET_TYPES_OF_AUTO_PARTS_ARCHIVE({ commit }) {
      return await axios
        .post(DOMAIN_API + '/index.php?route=api/auto_parts/auto/types', {
          key: KEYS,
        })
        .then((response) => {
          commit(
            'SET_TYPES_OF_AUTO_PARTS_STATE',
            response.data.typesOfAutoParts,
          );
          return response.data.typesOfAutoParts;
        })
        .catch(function (error) {
          console.log(error);
          return error;
        });
    },

    RESTORE_AUTO_PARTS_ARCHIVE_BY_API({ commit }, param) {
      this.dispatch('generalStore/LOCK_UI');
      return axios
        .post(
          DOMAIN_API +
            '/index.php?route=api/auto_parts_archive/auto/restore/' +
            param.autoPartsId,
          {
            key: KEYS,
            user_id: JSON.parse(localStorage.user).user_id,
          },
        )
        .then(() => {
          this.dispatch('generalStore/UN_LOCK_UI');
          commit('RESTORE_THIS_AUTO_PARTS_ARCHIVE', param.autoPartsNumber);
        })
        .catch(function (error) {
          console.log(error);
        });
    },

    SET_SHOW_ALL_IMAGE({ commit }, id) {
      commit('SHOW_ALL_IMAGE_BY_ID', id);
    },
  },
  mutations: {
    SET_AUTO_PARTS_ARCHIVE_TO_STATE: (state, autoPartsArchive) => {
      state.autoPartsArchive = {};
      state.autoPartsArchive = autoPartsArchive;
    },
    SET_AUTO_PARTS_ARCHIVE_TOTALS_STATE: (state, autoPartsArchiveTotals) => {
      state.autoPartsArchiveTotals = autoPartsArchiveTotals;
    },
    SET_TYPES_OF_AUTO_PARTS_STATE: (state, typesOfAutoPartsArchive) => {
      state.typesOfAutoPartsArchive = typesOfAutoPartsArchive;
    },
    SHOW_ALL_IMAGE_BY_ID: (state, id) => {
      if (!state.autoPartsArchive[id].imagesShowAllImage) {
        state.autoPartsArchive[id].imagesShowAllImage = true;

        for (let i = 0; i < state.autoPartsArchive[id].images.length; i++) {
          state.autoPartsArchive[id].images[i].imageShow = true;
        }
      }
    },
    SET_AUTO_PARTS_ARCHIVE_HISTORY_STATE: (state, autoPartsArchiveHistory) => {
      state.autoPartsArchiveHistory = autoPartsArchiveHistory;
    },
    RESTORE_THIS_AUTO_PARTS_ARCHIVE: (state, id) => {
      state.autoPartsArchiveTotals = state.autoPartsArchiveTotals - 1;
      state.autoPartsArchive.splice(id, 1);
      alert('Запчасть восстановлена!');
    },
    SET_BREND_MODEL_CAR_AUTO_PARTS: (state, brandAndModelCar) => {
      state.brandAndModelCar = brandAndModelCar;
    },
  },
};
