import { registerVueControllerComponents } from '@symfony/ux-vue';
import './bootstrap.js';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import './styles/app.css';
import RegisterForm from './vue/controllers/registerLoginForm.vue';
import { createApp } from 'vue';
import UserMenu from './vue/controllers/index.vue';

// Instancia para el menú de usuario
const appUserMenu = createApp({});
appUserMenu.component('user-menu', UserMenu);
appUserMenu.mount('#vue-navbar-user');

// Instancia para el formulario de registro/login
const appRegisterForm = createApp({});
appRegisterForm.component('register-form', RegisterForm);
appRegisterForm.mount('#vue-register');

registerVueControllerComponents(require.context('./vue/controllers', true, /\.vue$/));
registerVueControllerComponents();
