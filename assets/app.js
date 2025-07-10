import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import 'bootstrap/dist/css/bootstrap.min.css';
import './styles/app.scss';
import './bootstrap.js';

import { createApp } from 'vue';
import RegisterForm from './vue/controllers/registerLoginForm.vue';
import UserMenu from './vue/controllers/index.vue';


document.addEventListener('DOMContentLoaded', () => {
    const registerEl = document.getElementById('vue-register');
    if (registerEl) {
        createApp(RegisterForm).mount(registerEl);
    }

    const userMenuEl = document.getElementById('vue-navbar-user');
    if (userMenuEl) {
        createApp(UserMenu).mount(userMenuEl);
    }
});
