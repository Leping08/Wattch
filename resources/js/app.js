/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';

import VueCarousel from 'vue-carousel';
import VueApexCharts from 'vue-apexcharts';
import ToggleButton from 'vue-js-toggle-button';

Vue.use(ToggleButton);
Vue.use(VueCarousel);
Vue.use(VueApexCharts);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('dropdown', require('./components/Dropdown.vue').default);
Vue.component('modal', require('./components/Modal.vue').default);
Vue.component('page-chat', require('./components/PageChart').default);
Vue.component('dashboard-chart', require('./components/DashboardChart').default);
Vue.component('add-assertion', require('./components/AddAssertion').default);
Vue.component('count-up', require('./components/CountUp').default);
Vue.component('assertion-chart', require('./components/AssertionChart').default);
Vue.component('assertion-sparkline-chart', require('./components/AssertionSparkline').default);
Vue.component('product-selector', require('./components/ProductSelector').default);
Vue.component('update-payment-method', require('./components/Stripe/UpdatePaymentMethod').default);
Vue.component('sign-up', require('./components/Stripe/SignUp').default);
Vue.component('sign-up-product-selector', require('./components/SignUpProductSelector').default);
Vue.component('apexchart', VueApexCharts);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
