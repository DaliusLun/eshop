/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

const { isSet } = require('lodash');

require('./bootstrap');

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});


var itemblade =  document.getElementById('itemblade');
if (typeof (itemblade) != 'undefined' && itemblade != null) {
    let element = document.getElementsByClassName('photo__small');
    if (element.length > 0)
    {
        require('./itemPhotos');
    }
    require('./quantity');
}


let basket = document.getElementsByClassName('total');
if (typeof (basket) != 'undefined' && basket != null && basket.length>0) {
    require('./countTotal');
    require('./quantity');
};



require('./heart');
require('./basket');
    

