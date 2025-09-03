import axios from "axios";
import { DOMAIN_API, KEYS } from "/src/constants/constants";

export default {
  namespaced: true,

  state: {
    autoTires: {},
    autoTiresIndex: {},
    autoTiresTotals: 0,
    autoTiresHistory: {},
  },
  getters: {
    AUTO_TIRES(state) {
      return state.autoTires;
    },
    AUTO_TIRES_TOTALS(state) {
      return state.autoTiresTotals;
    },
    AUTO_TIRES_INDEX(state) {
      return state.autoTiresIndex;
    },
    AUTO_TIRES_HISTORY(state) {
      return state.autoTiresHistory;
    },
  },
  actions: {
    GET_AUTO_TIRES_FROM_API({ commit }, param) {
      this.dispatch("generalStore/LOCK_UI");
      return axios
        .post(DOMAIN_API + "/index.php?route=api/auto_tires/tires", {
          key: KEYS,
          page: param,
        })
        .then((response) => {
          this.dispatch("generalStore/UN_LOCK_UI");
          commit("SET_AUTO_TIRES_TO_STATE", response.data.autoTires);
          return response.data.autoTires;
        })
        .catch(function (error) {
          console.log(error);
          return error;
        });
    },

    GET_AUTO_TIRES_TOTALS({ commit }) {
      return axios
        .post(DOMAIN_API + "/index.php?route=api/auto_tires/tires/totals", {
          key: KEYS,
        })
        .then((response) => {
          commit("SET_AUTO_TIRES_TOTALS_STATE", response.data.autoTiresTotals);
          return response.data.autoTiresTotals;
        })
        .catch(function (error) {
          console.log(error);
          return error;
        });
    },

    CHANGE_AUTO_TIRES_STATUS({ commit }, param) {
      this.dispatch("generalStore/LOCK_UI");
      return axios
        .post(
          DOMAIN_API +
            "/index.php?route=api/auto_tires/tires/change_status/" +
            param.id,
          {
            key: KEYS,
            status: param.status,
          }
        )
        .then(() => {
          this.dispatch("generalStore/UN_LOCK_UI");
          commit("SET_CHANGE_AUTO_TIRES_STATUS", param);
        })
        .catch(function (error) {
          console.log(error);
        });
    },

    GET_AUTO_TIRES_INDEX({ commit }, param) {
      return axios
        .post(
          DOMAIN_API +
            "/index.php?route=api/auto_tires/tires/index/" +
            param.id,
          {
            key: KEYS,
            param: param,
          }
        )
        .then((response) => {
          commit("SET_AUTO_TIRES_INDEX_STATE", response.data.autoTiresIndex);
          return response.data.autoTiresIndex;
        })
        .catch(function (error) {
          console.log(error);
          return error;
        });
    },

    SET_AUTO_TIRES_IMAGE_FROM_LIST({ commit }, param) {
      this.dispatch("generalStore/LOCK_UI");
      return axios
        .post(
          DOMAIN_API +
            "/index.php?route=api/auto_tires/tires/add_images/" +
            param.autoPartsId,
          {
            key: KEYS,
            images: param.images.toString(),
          }
        )
        .then(() => {
          this.dispatch("generalStore/UN_LOCK_UI");
          commit("ADD_AUTO_TIRES_IMAGE_FROM_LIST");
        })
        .catch(function (error) {
          console.log(error);
        });
    },

    CHANGE_AUTO_TIRES_PRICE({ commit }, param) {
      this.dispatch("generalStore/LOCK_UI");
      return axios
        .post(
          DOMAIN_API +
            "/index.php?route=api/auto_tires/tires/change_price/" +
            param.id,
          {
            key: KEYS,
            price: param.priceUSD,
          }
        )
        .then((response) => {
          this.dispatch("generalStore/UN_LOCK_UI");
          let data = {
            priceBYN: response.data.autoTiresPriceChange.priceBYN,
            priceUSD: response.data.autoTiresPriceChange.priceUSD,
            index: param.index,
          };

          commit("SET_CHANGE_AUTO_TIRES_PRICE", data);
          return data;
        })
        .catch(function (error) {
          console.log(error);
        });
    },

    DELET_AUTO_TIRES_BY_API({ commit }, param) {
      return axios
        .post(
          DOMAIN_API +
            "/index.php?route=api/auto_tires/tires/delete/" +
            param.autoTiresId,
          {
            key: KEYS,
          }
        )
        .then(() => {
          commit("DELETE_THIS_AUTO_TIRES", param.autoTiresNumber);
        })
        .catch(function (error) {
          console.log(error);
        });
    },

    SET_SHOW_ALL_IMAGE({ commit }, id) {
      commit("SHOW_ALL_IMAGE_BY_ID", id);
    },

    EDIT_AUTO_TIRES_FROM_API({ commit }, param) {
      if (!param.redirect) {
        this.dispatch("generalStore/LOCK_UI");
      }
      return axios
        .post(
          DOMAIN_API +
            "/index.php?route=api/auto_tires/tires/" +
            param.id +
            "/edit",
          param.autoTires
        )
        .then(() => {
          if (param.redirect) {
            window.location.href = "/auto-tires";
            return false;
          }
          this.dispatch("generalStore/UN_LOCK_UI");
          commit("EDIT_AUTO_TIRES_ON_STATE");
          return param.autoTires;
        })
        .catch(function (error) {
          console.log(error);
          return error;
        });
    },

    RESET_AUTO_TIRES_FOR_CREATE_PAGE({ commit }) {
      commit("RESET_AUTO_TIRES");
    },

    SET_AUTO_TIRES_IMAGE_FROM_USER({ commit }, param) {
      commit("ADD_AUTO_TIRES_IMAGE", param);
      return param;
    },

    SET_AUTO_TIRES_FROM_API({ commit }, param) {
      this.dispatch("generalStore/LOCK_UI");
      return axios
        .post(
          DOMAIN_API + "/index.php?route=api/auto_tires/tires/create",
          param.fields
        )
        .then((response) => {
          if (typeof response.data.autoTiresCreate === "string") {
            alert(response.data.autoTiresCreate);
            return false;
          }
          if (param.redirect) {
            window.location.href = "/auto-tires";
            return false;
          }
          this.dispatch("generalStore/UN_LOCK_UI");
          commit("ADD_AUTO_TIRES_TO_STATE");
          return param;
        })
        .catch(function (error) {
          console.log(error);
          return error;
        });
    },
  },
  mutations: {
    ADD_AUTO_TIRES_IMAGE_FROM_LIST: () => {
      alert("Изображения добавлены!");
    },
    ADD_AUTO_TIRES_TO_STATE: () => {
      alert("Добавлено объявление!");
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
      alert("изменения сохранены!");
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
      alert("Объявление удалено!");
    },
  },
};
