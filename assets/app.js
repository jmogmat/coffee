import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import 'bootstrap/dist/css/bootstrap.min.css';
import './styles/app.scss';
import './bootstrap.js';

import { createApp } from 'vue';
import RegisterForm from './vue/controllers/registerLoginForm.vue';
import UserMenu from './vue/controllers/index.vue';
import AnimatedSections from './vue/controllers/animatedSections.vue';
import ScrollAnimate from './vue/directives/v-scroll-animate';

function mountVueComponents() {
    const registerEl = document.getElementById('vue-register');
    if (registerEl && !registerEl.__vue_app__) {
        const app = createApp(RegisterForm);
        app.mount(registerEl);
        registerEl.__vue_app__ = app;
    }

    const userMenuEl = document.getElementById('vue-navbar-user');
    if (userMenuEl && !userMenuEl.__vue_app__) {
        const app = createApp(UserMenu);
        app.mount(userMenuEl);
        userMenuEl.__vue_app__ = app;
    }

    const animatedSectionsEl = document.getElementById('vue-animated-sections');
    if (animatedSectionsEl && !animatedSectionsEl.__vue_app__) {
        const app = createApp(AnimatedSections);
        app.directive('scroll-animate', ScrollAnimate); // registra la directiva
        app.mount(animatedSectionsEl);
        animatedSectionsEl.__vue_app__ = app;
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', mountVueComponents);
} else {
    mountVueComponents();
}

document.addEventListener('turbo:load', mountVueComponents);
