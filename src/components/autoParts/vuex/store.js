import axios from "axios";
import {DOMAIN, KEYS} from '/src/constants/constants';

export default {
    namespaced: true,

    state: {
        autoParts: {},
        autoPartsIndex: {},
        autoPartsTotals: 0,
        lockingPool: 0,
        autoPartsHistory: {},
        typesOfAutoParts: [],
        brandAndModelCar: []
    },
    getters: {
        BREND_MODEL_CAR_AUTO_PARTS(state) {
            return state.brandAndModelCar;
        },
        TYPES_OF_AUTO_PARTS(state) {
            return state.typesOfAutoParts;
        },
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
                DOMAIN + '/index.php?route=api/auto_parts/auto',
                {
                    key: KEYS,
                    page: param.pageNum,
                    filter_sparePartNumber: param.filters.sparePartNumber,
                    filter_model: param.filters.model,
                    filter_status: param.filters.status,
                    filter_fuel: param.filters.fuel,
                    filter_value: param.filters.value,
                    filter_year_start: param.filters.yearStart,
                    filter_year_last: param.filters.yearLast,
                    filter_types: param.filters.types.code,
                    filter_category: param.filters.car.code
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

        GET_AUTO_PARTS_TOTALS({commit}, param) {
            return  axios.post(
                DOMAIN + '/index.php?route=api/auto_parts/auto/totals',
                {
                    key: KEYS,
                    filter_sparePartNumber: param.filters.sparePartNumber,
                    filter_model: param.filters.model,
                    filter_status: param.filters.status,
                    filter_fuel: param.filters.fuel,
                    filter_value: param.filters.value,
                    filter_year_start: param.filters.yearStart,
                    filter_year_last: param.filters.yearLast,
                    filter_types: param.filters.types.code,
                    filter_category: param.filters.car.code
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
                DOMAIN + '/index.php?route=api/auto_parts/auto/history/' + id,
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
                DOMAIN + '/index.php?route=api/auto_parts/auto/index/' + param.id,
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

        async GET_TYPES_OF_AUTO_PARTS({commit}) {
            return await axios.post(
                DOMAIN + '/index.php?route=api/auto_parts/auto/types',
                {
                    key: KEYS,
                }
            )
                .then((response) => {
                    commit('SET_TYPES_OF_AUTO_PARTS_STATE', response.data.typesOfAutoParts);
                    return response.data.typesOfAutoParts;
                })
                .catch(function (error) {
                    console.log(error);
                    return error;
                });
        },

        async GET_BREND_MODEL_CAR_AUTO_PARTS({commit}) {
            return await axios.post(
                DOMAIN + '/index.php?route=api/auto_parts/auto/category',
                {
                    key: KEYS,
                }
            )
            .then((response) => {
                commit('SET_BREND_MODEL_CAR_AUTO_PARTS', response.data.brandAndModelCar);
                return response.data.brandAndModelCar;
            })
            .catch(function (error) {
                console.log(error);
                return error;
            });
        },

        DELET_AUTO_PARTS_BY_API({commit}, param) {
            return axios.post(
                DOMAIN + '/index.php?route=api/auto_parts/auto/delete/' + param.autoPartsId,
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

        EDIT_AUTO_PARTS_FROM_API({commit}, param) {
            return axios.post(
                DOMAIN + '/index.php?route=api/auto_parts/auto/' + param.id + '/edit',
                param.autoParts
            )
                .then(() => {
                    commit('EDIT_AUTO_PARTS_ON_STATE');
                    return param.autoParts;
                })
                .catch(function (error) {
                    console.log(error);
                    return error;
                });
        },

        SET_AUTO_PARTS_IMAGE_FROM_USER({commit}, param) {
            commit('ADD_AUTO_PARTS_IMAGE', param);
            return param;
        },

        CHANGE_AUTO_PARTS_PRICE({commit}, param) {
            return axios.post(
                DOMAIN + '/index.php?route=api/auto_parts/auto/change_price/' + param.id,
                {
                    key: KEYS,
                    price: param.priceUSD
                }
            )
            .then((response) => {
                let data = {
                    priceBYN: response.data.autoPartsPriceChange.priceBYN,
                    priceUSD: response.data.autoPartsPriceChange.priceUSD,
                    index: param.index,
                }

                commit('SET_CHANGE_AUTO_PARTS_PRICE', data);
                return data;
            })
            .catch(function (error) {
                console.log(error);
            });
        },

        SET_AUTO_PARTS_FROM_API({commit}, param) {
            return axios.post(
                DOMAIN + '/index.php?route=api/auto_parts/auto/create',
                {
                    key: KEYS,
                    param: param.autoPartsNew
                }
            )
                .then(() => {
                    commit('ADD_AUTO_PARTS_TO_STATE', param.autoPartsObject);
                    alert('Добавлено новая Запчасть!')
                    return param;
                })
                .catch(function (error) {
                    console.log(error);
                    return error;
                });
        },

        CHANGE_AUTO_PARTS_STATUS({commit}, param) {
            return axios.post(
                DOMAIN + '/index.php?route=api/auto_parts/auto/change_status/' + param.id,
                {
                    key: KEYS,
                    status: param.status
                }
            )
                .then(() => {
                    commit('SET_CHANGE_AUTO_PARTS_STATUS', param);
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
        ADD_AUTO_PARTS_TO_STATE: (state, autoPartsIndex) => {
            state.autoPartsIndex = autoPartsIndex;
            console.log('Добавлена запчасть!');
        },
        SET_CHANGE_AUTO_PARTS_STATUS: (state, param) => {
            state.autoParts[param.index].status = !parseInt(param.status);
        },
        ADD_AUTO_PARTS_IMAGE: (state, file) => {
            if(!state.autoPartsIndex.images) {state.autoPartsIndex.images = []}
            if(!state.autoPartsIndex.imagesServer) {state.autoPartsIndex.imagesServer = []}

            state.autoPartsIndex.images.push(file.dataURL);
            state.autoPartsIndex.imagesServer.push(file.upload.filename);
        },
        SET_CHANGE_AUTO_PARTS_PRICE: (state, param) => {
            state.autoParts[param.index].priceUSD = param.priceUSD;
            state.autoParts[param.index].priceBYN = param.priceBYN;
        },
        SET_AUTO_PARTS_TOTALS_STATE: (state, autoPartsTotals) => {
            state.autoPartsTotals = autoPartsTotals;
        },
        SET_AUTO_PARTS_INDEX_STATE: (state, autoPartsIndex) => {
            state.autoPartsIndex = autoPartsIndex;
        },
        EDIT_AUTO_PARTS_ON_STATE: () => {
            alert("изменения сохранены!");
        },
        SHOW_ALL_IMAGE_BY_ID: (state, id) => {
            if(!state.autoParts[id].imagesShowAllImage) {
                state.autoParts[id].imagesShowAllImage = true;

                for (let i = 0; i < state.autoParts[id].images.length; i++) {
                    state.autoParts[id].images[i].imageShow = true;
                }
            }
        },
        SET_AUTO_PARTS_HISTORY_STATE: (state, autoPartsHistory) => {
            state.autoPartsHistory = autoPartsHistory;
        },
        SET_TYPES_OF_AUTO_PARTS_STATE: (state, typesOfAutoParts) => {
            state.typesOfAutoParts = typesOfAutoParts;
        },
        DELETE_THIS_AUTO_PARTS: (state, id) => {
            state.autoPartsTotals = state.autoPartsTotals - 1;
            state.autoParts.splice(id, 1);
            alert("Запчасть удалена удалено!");
        },
        SET_BREND_MODEL_CAR_AUTO_PARTS: (state, brandAndModelCar) => {
            state.brandAndModelCar = brandAndModelCar;
        },
        LOCK_UI: (state) => {
            state.lockingPool++;
        },
        UN_LOCK_UI: (state) => {
            state.lockingPool--;
        },
    }
}