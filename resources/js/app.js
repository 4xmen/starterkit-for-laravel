/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


require('./bootstrap');

require('rvnm/dist/rvnm.min');
require('bootstrap-select/dist/js/bootstrap-select.min');
require('bootstrap-select/dist/js/i18n/defaults-fa_IR.min');
require('bootstrap-tagsinput/dist/bootstrap-tagsinput.min');
require('lightbox2/dist/js/lightbox-plus-jquery.min');
require('alertifyjs/build/alertify.min');
require('fontawesome-iconpicker/dist/js/fontawesome-iconpicker.min');
const Chart = require('chart.js');
window.chart = Chart;

import UProgress from 'uprogress';
const uProgress = new UProgress();
window.uProgress = uProgress;
uProgress.start();

var alertify = require('alertifyjs/build/alertify.min');
window.alertify = alertify;


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


require('./other/typehead');
require('./other/general');
require('./other/menu');
require('./other/slider');


class StarterKit {
    constructor() {
        this.bootingCallbacks = []
    }

    booting(callback) {
        this.bootingCallbacks.push(callback)
    }

    boot() {
        this.bootingCallbacks.forEach(callback => callback(window.$,window.axios,window.chart,window.alertify))
        this.bootingCallbacks = []
    }
}
window.StarterKit=new StarterKit();
