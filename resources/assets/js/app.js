
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('navbar', require('./components/Navbar.vue'));
Vue.component('articles', require('./components/Articles.vue'));
Vue.component('users', require('./components/Users.vue'));
Vue.component('pagination', require('./components/Pagination.vue'));
Vue.component('alert', require('./components/Alert.vue'));

Vue.use('alert');
Object.defineProperties(Vue.prototype, {
    $alert: {
        get () {
            let el = this
            while (el) {
                for (let i = 0; i < el.$children.length; i++) {
                    const child = el.$children[i]
                    /* istanbul ignore else */
                    if (child.$options._componentTag === 'alert') {
                        return child
                    }
                }
                el = el.$parent
            }
            if (process.env.NODE_ENV !== 'production') {
                console.warn('Alert component must be part of this component scope or any of the parents scope.')
            }
            return null
        }
    }
});

const app = new Vue({
    el: '#app'
});
