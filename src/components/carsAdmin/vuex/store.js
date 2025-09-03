import axios from "axios";
import { DOMAIN_API, KEYS } from "/src/constants/constants";

export default {
  namespaced: true,
  state: {
    cars: [],
    car: {},
    marka: [],
    model: [],
    totals: 0,
  },
  getters: {
    CARS(state) {
      return state.cars;
    },
    CAR(state) {
      return state.car;
    },
    TOTALS(state) {
      return state.totals;
    },
    MARKA(state) {
      return state.marka;
    },
    MODEL(state) {
      return state.model;
    },
  },
  actions: {
    GET_CARS_FROM_API({ commit }, param) {
      return axios
        .post(DOMAIN_API + "/index.php?route=api/auto/cars", {
          key: KEYS,
          page: param,
        })
        .then((response) => {
          commit("SET_CARS_TO_STATE", response.data.cars);
          return response.data.cars;
        })
        .catch(function (error) {
          console.log(error);
          return error;
        });
    },

    GET_CARS_TOTALS_FROM_API({ commit }) {
      return axios
        .post(DOMAIN_API + "/index.php?route=api/auto/cars/total", {
          key: KEYS,
        })
        .then((response) => {
          commit("SET_TOTALS_TO_STATE", response.data.total);
          return response.data.total;
        })
        .catch(function (error) {
          console.log(error);
          return error;
        });
    },

    GET_MARKA_FROM_API({ commit }) {
      return axios
        .post(DOMAIN_API + "/index.php?route=api/auto/cars/marka", {
          key: KEYS,
        })
        .then((response) => {
          commit("SET_MARKA_TO_STATE", response.data.marka);
          return response.data.marka;
        })
        .catch(function (error) {
          console.log(error);
          return error;
        });
    },

    GET_MODEL_FROM_API({ commit }, marka) {
      return axios
        .post(DOMAIN_API + "/index.php?route=api/auto/cars/model", {
          marka: marka,
          key: KEYS,
        })
        .then((response) => {
          commit("SET_MODEL_TO_STATE", response.data.model);
          return response.data.model;
        })
        .catch(function (error) {
          console.log(error);
          return error;
        });
    },

    GET_CAR_FROM_API({ commit }, car_id) {
      return axios
        .post(DOMAIN_API + "/index.php?route=api/auto/cars/" + car_id, {
          key: KEYS,
        })
        .then((response) => {
          commit("SET_CAR_TO_STATE", response.data.car);
          return response.data.car;
        })
        .catch(function (error) {
          console.log(error);
          return error;
        });
    },

    SET_CAR_FROM_API({ commit }, param) {
      return axios
        .post(DOMAIN_API + "/index.php?route=api/auto/cars/create", param)
        .then(() => {
          commit("ADD_CAR_TO_STATE", param);
          alert("Добавлено авто в разборе!");
          return param;
        })
        .catch(function (error) {
          console.log(error);
          return error;
        });
    },

    SET_CAR_IMAGE_FROM_USER({ commit }, param) {
      commit("ADD_CAR_IMAGE", param);
      return param;
    },

    EDIT_CAR_FROM_API({ commit }, param) {
      return axios
        .post(
          DOMAIN_API + "/index.php?route=api/auto/cars/" + param.id + "/edit",
          param.car
        )
        .then(() => {
          commit("EDIT_CAR_ON_STATE");
          return param.car;
        })
        .catch(function (error) {
          console.log(error);
          return error;
        });
    },

    SET_EDIT_COLUMN_ON_LIST({ commit }, param) {
      return axios
        .post(
          DOMAIN_API + "/index.php?route=api/auto/cars/" + param.id + "/save",
          param.xForm
        )
        .then(() => {
          commit("SET_EDIT_COLUMN_PARAM", param);
        })
        .catch(function (error) {
          console.log(error);
        });
    },

    DELET_CAR_BY_API({ commit }, param) {
      return axios
        .post(
          DOMAIN_API +
            "/index.php?route=api/auto/cars/" +
            param.carId +
            "/delete",
          {
            key: KEYS,
          }
        )
        .then(() => {
          commit("DELETE_THIS_CAR", param.car);
        })
        .catch(function (error) {
          console.log(error);
        });
    },
  },
  mutations: {
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
      if (!state.car.images) {
        state.car.images = [];
      }
      if (!state.car.imagesServer) {
        state.car.imagesServer = [];
      }

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
    },
  },
};
