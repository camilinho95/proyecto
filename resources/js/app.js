
require('./bootstrap');

window.Vue = require('vue');

Vue.component('users-component', require('./components/UsersComponent.vue').default);
Vue.component('perfil-component', require('./components/PerfilComponent.vue').default);
Vue.component('sig-component', require('./components/SigComponent.vue').default);

const app = new Vue({
    el: '#app',
});
