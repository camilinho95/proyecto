
require('./bootstrap');

window.Vue = require('vue');

Vue.component('users-component', require('./components/UsersComponent.vue').default);
Vue.component('perfil-component', require('./components/PerfilComponent.vue').default);
Vue.component('sig-component', require('./components/SigComponent.vue').default);
Vue.component('gestionar-cartas-component', require('./components/GestionCartasComponent.vue').default);
Vue.component('gestionar-solicitudes-component', require('./components/GestionarSolicitudesComponent.vue').default);
Vue.component('solicitar-carta-component', require('./components/SolicitarCartaComponent.vue').default);





const app = new Vue({
    el: '#app',
});
