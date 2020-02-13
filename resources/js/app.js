/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

// VeeValidate
import VeeValidate from 'vee-validate';
Vue.use(VeeValidate);

// VueResource
var VueResource = require('vue-resource');
Vue.use(VueResource);

//SweetAlert2
import VueSweetalert2 from 'vue-sweetalert2';
Vue.use(VueSweetalert2);

import { store } from './store/store'

// VueRouter
import {router} from "./router/router";

import App from './App.vue'

Vue.http.headers.common['X-CSRF-TOKEN'] = document.head.querySelector('meta[name="csrf-token"]').content;




const app = new Vue({
  el: '#app',
  render: h => h(App),
  router,
  store,
});
