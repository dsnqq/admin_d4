import Vue from 'vue'
import App from './App.vue'
import store from './vuex/index';
import VueRouter from "vue-router";
import router from './router/index';
import Multiselect from 'vue-multiselect';


Vue.config.productionTip = false
Vue.use(VueRouter);
Vue.component('v-multiselect', Multiselect);

new Vue({
  router,
  render: h => h(App),
  store
}).$mount('#admin-panel')