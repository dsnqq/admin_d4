import axios from "axios";
import {KEYS} from '/src/constants/constants';

export default {
    namespaced: true,

    state: {
        autoPartsArchive: {},
        autoPartsArchiveIndex: {},
        autoPartsArchiveTotals: 0,
        lockingPool: 0,
        autoPartsArchiveHistory: {}
    },
    getters: {
        AUTO_PARTS_ARCHIVE(state) {
            return state.autoPartsArchive;
        },
        AUTO_PARTS_ARCHIVE_TOTALS(state) {
            return state.autoPartsArchiveTotals;
        },
        AUTO_PARTS_ARCHIVE_INDEX(state) {
            return state.autoPartsArchiveIndex;
        },
        AUTO_PARTS_ARCHIVE_HISTORY(state) {
            return state.autoPartsArchiveHistory;
        },
        IS_UI_LOCKED(state) {
            return state.lockingPool > 0
        },
    },
    actions: {
        GET_AUTO_PARTS_ARCHIVE_FROM_API({commit}, param) {
            commit('LOCK_UI');
            return axios.post(
                '/index.php?route=api/auto_parts_archive/auto',
                {
                    key: KEYS,
                    page: param,
                }
            )
                .then((response) => {
                    commit('UN_LOCK_UI');
                    commit('SET_AUTO_PARTS_ARCHIVE_TO_STATE', response.data.autoPartsArchive);
                    return response.data.autoPartsArchive;
                })
                .catch(function (error) {
                    console.log(error);
                    return error;
                });
        },

        GET_AUTO_PARTS_ARCHIVE_TOTALS({commit}) {
            return  axios.post(
                '/index.php?route=api/auto_parts_archive/auto/totals',
                {
                    key: KEYS,
                }
            )
                .then((response) => {
                    commit('SET_AUTO_PARTS_ARCHIVE_TOTALS_STATE', response.data.autoPartsArchiveTotals);
                    return response.data.autoPartsArchiveTotals;
                })
                .catch(function (error) {
                    console.log(error);
                    return error;
                });
        },

        GET_AUTO_PARTS_ARCHIVE_HISTORY({commit}, id) {
            commit('LOCK_UI');
            return  axios.post(
                '/index.php?route=api/auto_parts_archive/auto/history/' + id,
                {
                    key: KEYS,
                }
            )
                .then((response) => {
                    commit('UN_LOCK_UI');
                    commit('SET_AUTO_PARTS_ARCHIVE_HISTORY_STATE', response.data.autoPartsArchiveHistory);
                    return response.data.autoPartsArchiveHistory;
                })
                .catch(function (error) {
                    console.log(error);
                    return error;
                });
        },

        GET_AUTO_PARTS_ARCHIVE_INDEX({commit}, param) {
            return  axios.post(
                '/index.php?route=api/auto_parts_archive/auto/index/' + param.id,
                {
                    key: KEYS,
                    param: param
                }
            )
                .then((response) => {
                    commit('SET_AUTO_PARTS_ARCHIVE_INDEX_STATE', response.data.autoPartsArchiveIndex);
                    return response.data.autoPartsArchiveIndex;
                })
                .catch(function (error) {
                    console.log(error);
                    return error;
                });
        },

        RESTORE_AUTO_PARTS_ARCHIVE_BY_API({commit}, param) {
            return axios.post(
                '/index.php?route=api/auto_parts_archive/auto/restore/' + param.autoPartsId,
                {
                    key: KEYS,
                }
            )
                .then(() => {
                    commit('RESTORE_THIS_AUTO_PARTS_ARCHIVE', param.autoPartsNumber);
                })
                .catch(function (error) {
                    console.log(error);
                });
        },

        SET_SHOW_ALL_IMAGE({commit}, id){
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
        SET_AUTO_PARTS_ARCHIVE_INDEX_STATE: (state, autoPartsArchiveIndex) => {
            state.autoPartsArchiveIndex = autoPartsArchiveIndex;
        },
        SHOW_ALL_IMAGE_BY_ID: (state, id) => {
            if(!state.autoPartsArchive[id].imagesShowAllImage) {
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
            alert("Запчасть восстановлена удалено!");
        },
        LOCK_UI: (state) => {
            state.lockingPool++;
        },
        UN_LOCK_UI: (state) => {
            state.lockingPool--;
        },
    }
}