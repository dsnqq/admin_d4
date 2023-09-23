import Vue from 'vue';
import Vuex from "vuex";
import axios from "axios";
import {KEYS} from '/src/constants/constants';

Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        cars: [],
        car: {},
        marka: [],
        model: [],
        totals: 0,
        sparePartsStatistics: {},
        sparePartsStatisticsDay: {},
        totalsSparePartsStatistics: 0,
        lockingPool: 0 // Global Preloader
    },
    mutations: {
        LOCK_UI: (state) => {
            state.lockingPool++;
        },
        UN_LOCK_UI: (state) => {
            state.lockingPool--
        },
        SET_SPARE_PARTS_STATISTICS_TO_STATE: (state, sparePartsStatistics) => {
            state.sparePartsStatistics = sparePartsStatistics;
        },
        SET_TOTALS_SPARE_PARTS_STATISTICS: (state, totalsSparePartsStatistics) => {
          state.totalsSparePartsStatistics = totalsSparePartsStatistics;
        },
        SET_DAY_SPARE_PARTS_STATISTICS: (state, sparePartsStatisticsDay) => {
          state.sparePartsStatisticsDay = sparePartsStatisticsDay;
        },
        SET_CARS_TO_STATE: (state, cars) => {
            state.car = {};
            state.cars = cars;
        },
        SET_TOTALS_TO_STATE: (state, totals) => {
            state.totals = totals;
        },
        SET_MARKA_TO_STATE: (state, marka) => {
            state.marka = marka;
        },
        SET_MODEL_TO_STATE: (state, model) => {
            state.model = model;
        },
        SET_CAR_TO_STATE: (state, car) => {
            state.car = {};
            state.car = car;
        },
        EDIT_CAR_ON_STATE: () => {
            alert("изменения сохранены!");
        },
        ADD_CAR_TO_STATE: (state) => {
            state.totals = state.totals + 1;
            state.car = {};
        },
        ADD_CAR_IMAGE: (state, file) => {
            if(!state.car.images) {state.car.images = []}
            if(!state.car.imagesServer) {state.car.imagesServer = []}

            state.car.images.push(file.dataURL);
            state.car.imagesServer.push(file.upload.filename);
        },
        SET_EDIT_COLUMN_PARAM: (state, param) => {
            state.cars[param.car][param.name] = param.edits;
            alert("Изменения сохранены!");
        },
        DELETE_THIS_CAR: (state, carId) => {
            state.totals = state.totals - 1;
            state.cars.splice(carId, 1);
            alert("Авто удалено!");
        }
    },
    actions: {
        async GET_SPARE_PARTS_STATISTICS({commit}, param) {
            commit('LOCK_UI');
            return axios.post(
                '/index.php?route=api/spare_parts_statistics/index',
                {
                    key: KEYS,
                    page: param,
                }
            )
                .then((response) => {
                    commit('UN_LOCK_UI');
                    commit('SET_SPARE_PARTS_STATISTICS_TO_STATE', response.data.sparePartsStatistics);
                    return response.data.sparePartsStatistics;
                })
                .catch(function (error) {
                    console.log(error);
                    return error;
                });
        },

        GET_SPARE_PARTS_STATISTICS_TOTALS({commit}) {
            return  axios.post(
                '/index.php?route=api/spare_parts_statistics/index/totals',
                {
                    key: KEYS,
                }
            )
                .then((response) => {
                    commit('SET_TOTALS_SPARE_PARTS_STATISTICS', response.data.totalsSparePartsStatistics);
                    return response.data.totalsSparePartsStatistics;
                })
                .catch(function (error) {
                    console.log(error);
                    return error;
                });
        },

        GET_SPARE_PARTS_STATISTICS_DAY({commit}) {
            commit('LOCK_UI');
            return  axios.post(
                '/index.php?route=api/spare_parts_statistics/index/day',
                {
                    key: KEYS,
                }
            )
                .then((response) => {
                    commit('UN_LOCK_UI');
                    commit('SET_DAY_SPARE_PARTS_STATISTICS', response.data.sparePartsStatisticsDay);
                    return response.data.sparePartsStatisticsDay;
                })
                .catch(function (error) {
                    console.log(error);
                    return error;
                });
        },

        GET_CARS_FROM_API({commit}, param) {
            return axios.post(
                '/index.php?route=api/auto/cars',
                {
                    key: KEYS,
                    page: param,
                }
            )
                .then((response) => {
                    commit('SET_CARS_TO_STATE', response.data.cars);
                    return response.data.cars;
                })
                .catch(function (error) {
                    console.log(error);
                    return error;
                });
        },

        GET_CARS_TOTALS_FROM_API({commit}) {
            return  axios.post(
                '/index.php?route=api/auto/cars/total',
                {
                    key: KEYS,
                }
            )
                .then((response) => {
                    commit('SET_TOTALS_TO_STATE', response.data.total);
                    return response.data.total;
                })
                .catch(function (error) {
                    console.log(error);
                    return error;
                });
        },

        GET_MARKA_FROM_API({commit}) {
            return axios.post(
                '/index.php?route=api/auto/cars/marka',
                {
                    key: KEYS,
                }
            )
                .then((response) => {
                    commit('SET_MARKA_TO_STATE', response.data.marka);
                    return response.data.marka;
                })
                .catch(function (error) {
                    console.log(error);
                    return error;
                });
        },

        GET_MODEL_FROM_API({commit}, marka) {
            return axios.post(
                '/index.php?route=api/auto/cars/model',
                {
                    marka: marka,
                    key: KEYS,
                }
            )
                .then((response) => {
                    commit('SET_MODEL_TO_STATE', response.data.model);
                    return response.data.model;
                })
                .catch(function (error) {
                    console.log(error);
                    return error;
                });
        },

        GET_CAR_FROM_API({commit}, car_id) {
            return axios.post(
                '/index.php?route=api/auto/cars/' + car_id,
                {
                    key: KEYS,
                }
            )
                .then((response) => {
                    commit('SET_CAR_TO_STATE', response.data.car);
                    return response.data.car;
                })
                .catch(function (error) {
                    console.log(error);
                    return error;
                });
        },

        SET_CAR_FROM_API({commit}, param) {
            return axios.post(
                '/index.php?route=api/auto/cars/create',
                param
            )
                .then(() => {
                    commit('ADD_CAR_TO_STATE', param);
                    alert('Добавлено авто в разборе!')
                    return param;
                })
                .catch(function (error) {
                    console.log(error);
                    return error;
                });
        },

        SET_CAR_IMAGE_FROM_USER({commit}, param) {
            commit('ADD_CAR_IMAGE', param);
            return param;
        },

        EDIT_CAR_FROM_API({commit}, param) {
            return axios.post(
                '/index.php?route=api/auto/cars/' + param.id + '/edit',
                param.car
            )
                .then(() => {
                    commit('EDIT_CAR_ON_STATE');
                    return param.car;
                })
                .catch(function (error) {
                    console.log(error);
                    return error;
                });
        },

        SET_EDIT_COLUMN_ON_LIST({commit}, param) {
            return axios
                .post(
                    '/index.php?route=api/auto/cars/' + param.id + '/save',
                    param.xForm
                )
                .then(() => {
                    commit('SET_EDIT_COLUMN_PARAM', param);
                })
                .catch(function (error) {
                    console.log(error);
                });
        },

        DELET_CAR_BY_API({commit}, param) {
            return axios.post(
                '/index.php?route=api/auto/cars/' + param.carId + '/delete',
                {
                    key: KEYS,
                }
            )
                .then(() => {
                    commit('DELETE_THIS_CAR', param.car);
                })
                .catch(function (error) {
                    console.log(error);
                });
        }
    },
    getters: {
        IS_UI_LOCKED(state) {
            return state.lockingPool > 0
        },
        CARS(state) {
            return state.cars;
        },
        SPARE_PARTS_STATISTICS(state) {
            return state.sparePartsStatistics;
        },
        CAR(state) {
            return state.car;
        },
        TOTALS(state) {
            return state.totals;
        },
        TOTALS_SPARE_PARTS_STATISTICS(state) {
            return state.totalsSparePartsStatistics;
        },
        SPARE_PARTS_STATISTICS_DAY(state) {
            return state.sparePartsStatisticsDay;
        },
        MARKA(state) {
            return state.marka;
        },
        MODEL(state) {
            return state.model;
        }
    }
});

export default store;