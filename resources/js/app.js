
/**
* First we will load all of this project's JavaScript dependencies which
* includes Vue and other libraries. It is a great starting point when
* building robust, powerful web applications using Vue and Laravel.
*/

require('./bootstrap');
window.Vue = require('vue');

window.events = new Vue();
window.flash = function (message) {
	window.events.$emit('flash', message);
};

/**
* The following block of code may be used to automatically register your
* Vue components. It will recursively scan this directory for the Vue
* components and automatically register them with their "basename".
*
* Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
*/
/*Components from Meta*/
Vue.prototype.$hostname = document.head.querySelector('meta[name="hostname"]').content;
Vue.prototype.authorize = function(handler){
	//Additional admin privileges
	let user = window.App.user;

	return user ? handler(user) : false;
}

/*Vue components*/
Vue.component('flash', require('./components/Flash.vue'));

/*Vue pages*/
Vue.component('thread-view', require('./pages/Thread.vue'));

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key)))

/**
* Next, we will create a fresh Vue application instance and attach it to
* the page. Then, you may begin adding components to this application
* or customize the JavaScript scaffolding to fit your unique needs.
*/

const app = new Vue({
	el: '#app'
});