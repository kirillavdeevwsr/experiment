
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./scripts/burger-menu');
require('./scripts/slick');
require('./scripts/slickSliderActive');
require('./scripts/jquery.validate.min');
require('./scripts/jquery.maskedinput');
require('./scripts/jqueryValidateActivate');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('schedule', require('./components/Schedule.vue'));
Vue.component('rates', require('./components/Rates.vue'));

Vue.component('assessmentCreate', require('./components/assessmentCreate'));
Vue.component('assessment-archive', require('./components/assessmentArchive'));
Vue.component('assessmentReportAccountant', require('./components/AssessmentReportAccountant'));
Vue.component('assessmentReportManager', require('./components/assessmentReportManager'));
Vue.component('assessment-report-by-teacher', require('./components/AssessmentReportByTeacher'));

import vSelect from 'vue-select';
Vue.component('v-select', vSelect);

Vue.component('login-component', require('./components/auth/Login'));
Vue.component('register-component', require('./components/auth/Register'));

Vue.component('send',require('./components/test/send'));
Vue.component('bring_out',require('./components/test/bring_out '));

new Vue({
    el: 'section#app'
});

// const app = new Vue({
//     el: '#raspisanie'
// });
// const rate = new Vue({
//     el: '#ocenki'
// });
// const assessmentCreate = new Vue({
//    el: '#assessmentCreate'
// });
//
// const assessmentReportAccountant = new Vue({
//     el: '#assessmentReportAccountant'
// });
//
// const assessmentReportManager = new Vue({
//     el: '#assessmentReportManager'
// });
