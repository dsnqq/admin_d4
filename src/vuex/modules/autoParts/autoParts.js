import axios from "axios";
import {KEYS} from '/src/constants/constants';

export default {
    namespaced: true,

    state: {
        autoParts: {},
        autoPartsIndex: {},
        autoPartsTotals: 0,
        lockingPool: 0,
        autoPartsHistory: {}
    },
    getters: {
        AUTO_PARTS(state) {
            return state.autoParts;
        },
        AUTO_PARTS_TOTALS(state) {
            return state.autoPartsTotals;
        },
        AUTO_PARTS_INDEX(state) {
            return state.autoPartsIndex;
        },
        AUTO_PARTS_HISTORY(state) {
            return state.autoPartsHistory;
        },
        IS_UI_LOCKED(state) {
            return state.lockingPool > 0
        },
    },
    actions: {
        GET_AUTO_PARTS_FROM_API({commit}, param) {
            commit('LOCK_UI');
            return axios.post(
                '/index.php?route=api/auto_parts/auto',
                {
                    key: KEYS,
                    page: param,
                }
            )
                .then((response) => {
                    commit('UN_LOCK_UI');
                    commit('SET_AUTO_PARTS_TO_STATE', response.data.autoParts);
                    return response.data.autoParts;
                })
                .catch(function (error) {
                    console.log(error);
                    return error;
                });
        },

        GET_AUTO_PARTS_TOTALS({commit}) {
            return  axios.post(
                '/index.php?route=api/auto_parts/auto/totals',
                {
                    key: KEYS,
                }
            )
                .then((response) => {
                    commit('SET_AUTO_PARTS_TOTALS_STATE', response.data.autoPartsTotals);
                    return response.data.autoPartsTotals;
                })
                .catch(function (error) {
                    console.log(error);
                    return error;
                });
        },

        GET_AUTO_PARTS_HISTORY({commit}, id) {
            commit('LOCK_UI');
            return  axios.post(
                '/index.php?route=api/auto_parts/auto/history/' + id,
                {
                    key: KEYS,
                }
            )
                .then((response) => {
                    commit('UN_LOCK_UI');
                    commit('SET_AUTO_PARTS_HISTORY_STATE', response.data.autoPartsHistory);
                    return response.data.autoPartsHistory;
                })
                .catch(function (error) {
                    console.log(error);
                    return error;
                });
        },

        GET_AUTO_PARTS_INDEX({commit}, param) {
            return  axios.post(
                '/index.php?route=api/auto_parts/auto/index/' + param.id,
                {
                    key: KEYS,
                    param: param
                }
            )
                .then((response) => {
                    commit('SET_AUTO_PARTS_INDEX_STATE', response.data.autoPartsIndex);
                    return response.data.autoPartsIndex;
                })
                .catch(function (error) {
                    console.log(error);
                    return error;
                });
        },

        DELET_AUTO_PARTS_BY_API({commit}, param) {
            return axios.post(
                '/index.php?route=api/auto_parts/auto/delete/' + param.autoPartsId,
                {
                    key: KEYS,
                }
            )
                .then(() => {
                    commit('DELETE_THIS_AUTO_PARTS', param.autoPartsNumber);
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
        SET_AUTO_PARTS_TO_STATE: (state, autoParts) => {
            state.autoParts = {};
            state.autoParts = autoParts;
        },
        SET_AUTO_PARTS_TOTALS_STATE: (state, autoPartsTotals) => {
            state.autoPartsTotals = autoPartsTotals;
        },
        SET_AUTO_PARTS_INDEX_STATE: (state, autoPartsIndex) => {
            state.autoPartsIndex = autoPartsIndex;
        },
        SHOW_ALL_IMAGE_BY_ID: (state, id) => {
            state.autoParts[id].imagesShowAllImage = true;

            for(let i = 0; i < state.autoParts[id].images.length; i++){
                state.autoParts[id].images[i].imageShow = true;
            }
        },
        SET_AUTO_PARTS_HISTORY_STATE: (state, autoPartsHistory) => {
            state.autoPartsHistory = autoPartsHistory;
        },
        DELETE_THIS_AUTO_PARTS: (state, id) => {
            state.autoPartsTotals = state.autoPartsTotals - 1;
            state.autoParts.splice(id, 1);
            alert("Запчасть удалена удалено!");
        },
        LOCK_UI: (state) => {
            state.lockingPool++;
        },
        UN_LOCK_UI: (state) => {
            state.lockingPool--;
        },
    }
}