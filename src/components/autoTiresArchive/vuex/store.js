import axios from "axios";
import { KEYS, DOMAIN_API } from "/src/constants/constants";

export default {
  namespaced: true,

  state: {
    autoTiresArchive: {},
    autoTiresArchiveIndex: {},
    autoTiresArchiveTotals: 0,
    autoTiresArchiveHistory: {},
  },
  getters: {
    AUTO_TIRES_ARCHIVE(state) {
      return state.autoTiresArchive;
    },
    AUTO_TIRES_ARCHIVE_TOTALS(state) {
      return state.autoTiresArchiveTotals;
    },
    AUTO_TIRES_ARCHIVE_INDEX(state) {
      return state.autoTiresArchiveIndex;
    },
    AUTO_TIRES_ARCHIVE_HISTORY(state) {
      return state.autoTiresArchiveHistory;
    },
  },
  actions: {
    GET_AUTO_TIRES_ARCHIVE_FROM_API({ commit }, param) {
      this.dispatch("generalStore/LOCK_UI");
      return axios
        .post(DOMAIN_API + "/index.php?route=api/auto_tires_archive/tires", {
          key: KEYS,
          page: param,
        })
        .then((response) => {
          this.dispatch("generalStore/UN_LOCK_UI");
          commit(
            "SET_AUTO_TIRES_ARCHIVE_TO_STATE",
            response.data.autoTiresArchive
          );
          return response.data.autoTiresArchive;
        })
        .catch(function (error) {
          console.log(error);
          return error;
        });
    },

    GET_AUTO_TIRES_ARCHIVE_TOTALS({ commit }) {
      return axios
        .post(
          DOMAIN_API + "/index.php?route=api/auto_tires_archive/tires/totals",
          {
            key: KEYS,
          }
        )
        .then((response) => {
          commit(
            "SET_AUTO_TIRES_ARCHIVE_TOTALS_STATE",
            response.data.autoTiresArchiveTotals
          );
          return response.data.autoTiresArchiveTotals;
        })
        .catch(function (error) {
          console.log(error);
          return error;
        });
    },

    GET_AUTO_TIRES_ARCHIVE_HISTORY({ commit }, id) {
      this.dispatch("generalStore/LOCK_UI");
      return axios
        .post(
          DOMAIN_API +
            "/index.php?route=api/auto_tires_archive/tires/history/" +
            id,
          {
            key: KEYS,
          }
        )
        .then((response) => {
          this.dispatch("generalStore/UN_LOCK_UI");
          commit(
            "SET_AUTO_TIRES_ARCHIVE_HISTORY_STATE",
            response.data.autoTiresArchiveHistory
          );
          return response.data.autoTiresArchiveHistory;
        })
        .catch(function (error) {
          console.log(error);
          return error;
        });
    },

    GET_AUTO_TIRES_ARCHIVE_INDEX({ commit }, param) {
      return axios
        .post(
          DOMAIN_API +
            "/index.php?route=api/auto_tires_archive/tires/index/" +
            param.id,
          {
            key: KEYS,
            param: param,
          }
        )
        .then((response) => {
          commit(
            "SET_AUTO_TIRES_ARCHIVE_INDEX_STATE",
            response.data.autoTiresArchiveIndex
          );
          return response.data.autoTiresArchiveIndex;
        })
        .catch(function (error) {
          console.log(error);
          return error;
        });
    },

    RESTORE_AUTO_TIRES_ARCHIVE_BY_API({ commit }, param) {
      return axios
        .post(
          DOMAIN_API +
            "/index.php?route=api/auto_tires_archive/tires/restore/" +
            param.autoTiresId,
          {
            key: KEYS,
          }
        )
        .then(() => {
          commit("RESTORE_THIS_AUTO_TIRES_ARCHIVE", param.autoTiresNumber);
        })
        .catch(function (error) {
          console.log(error);
        });
    },

    SET_SHOW_ALL_IMAGE({ commit }, id) {
      commit("SHOW_ALL_IMAGE_BY_ID", id);
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
    SET_AUTO_TIRES_ARCHIVE_INDEX_STATE: (state, autoTiresArchiveIndex) => {
      state.autoTiresArchiveIndex = autoTiresArchiveIndex;
    },
    SHOW_ALL_IMAGE_BY_ID: (state, id) => {
      if (!state.autoTiresArchive[id].imagesShowAllImage) {
        state.autoTiresArchive[id].imagesShowAllImage = true;

        for (let i = 0; i < state.autoTiresArchive[id].images.length; i++) {
          state.autoTiresArchive[id].images[i].imageShow = true;
        }
      }
    },
    SET_AUTO_TIRES_ARCHIVE_HISTORY_STATE: (state, autoTiresArchiveHistory) => {
      state.autoTiresArchiveHistory = autoTiresArchiveHistory;
    },
    RESTORE_THIS_AUTO_TIRES_ARCHIVE: (state, id) => {
      state.autoTiresArchiveTotals = state.autoTiresArchiveTotals - 1;
      state.autoTiresArchive.splice(id, 1);
      alert("Шина восстановлена!");
    },
  },
};
