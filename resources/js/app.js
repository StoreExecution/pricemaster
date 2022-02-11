/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import 'es6-promise/auto'
import axios from 'axios'
import VueAxios from 'vue-axios'
import {ValidationProvider,ValidationObserver, extend} from 'vee-validate';
import {required} from 'vee-validate/dist/rules';
import HighchartsVue from 'highcharts-vue'
import Vue from 'vue'
import VueAuth from '@websanova/vue-auth'

import VueRouter from 'vue-router'
import VModal from 'vue-js-modal'
import auth from './auth';
import router from './router'
import moment from 'moment'

import { LMap, LTileLayer, LMarker,LPopup } from 'vue2-leaflet';
import 'leaflet/dist/leaflet.css';

Vue.component('l-map', LMap);
Vue.component('l-tile-layer', LTileLayer);
Vue.component('l-marker', LMarker);
Vue.component('l-popup', LPopup);

Vue.prototype.moment = moment


window.Vue = require('vue');
Vue.router = router;
Vue.use(VueRouter);
Vue.use(HighchartsVue);
Vue.component('ValidationProvider', ValidationProvider);
Vue.component('ValidationObserver', ValidationObserver);
extend('required', {
    validate(value) {
        return {
            required: true,
            valid: ['', null, undefined].indexOf(value) === -1
        };
    },
    computesRequired: true
});

Vue.use(VModal, {dynamic: true, dialog: true, injectModalsContainer: true, dynamicDefaults: {clickToClose: true, adaptive: true, height: 'auto',}});
//Vue.use(VModal, {dynamic: true, injectModalsContainer: true})
Vue.use(VModal, {
    DefaultProps: {
        height: 'auto',
        draggable: true,
        resizable: true,
        adaptive: true,
        scrollable: true
    }
});
Vue.use(VueAxios, axios)
axios.defaults.baseURL = '/api/';
Vue.use(VueAuth, auth);
Vue.component('pagination', require('laravel-vue-pagination'));

//Vue.use(VueRouter);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))


Vue.component('dashboard', require('./components/pages/dashboard/Dashboard.vue').default);
Vue.component('product', require('./components/pages/product/ProductIndex.vue').default);

Vue.component('app', require('./components/App.vue').default);
//Vue.component('index', Index);
Vue.axios.interceptors.response.use(function (response) {
    return response;
}, function (error) {
    if (400 === error.response.status) {
        swal({
            title: "Session Expired",
            text: "Your session has expired. Would you like to be redirected to the login page?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes",
            closeOnConfirm: false
        }, function () {
            window.location = '/login';
        });
    } else {
        return Promise.reject(error);
    }
});


export const bus = new Vue();

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router
});
