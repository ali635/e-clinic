import { createApp } from 'vue';
import './sliders.js';
import 'flowbite';

import bookService from './components/bookService.vue';

document.addEventListener("DOMContentLoaded", () => {
    const appElement = document.getElementById('vue-app');
    if (appElement) {
        const app = createApp({});
        app.component('book-service', bookService);
        app.mount(appElement);
    }
});
