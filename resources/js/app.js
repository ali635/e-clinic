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


document.addEventListener('DOMContentLoaded', () => {
    const forms = document.querySelectorAll('.genericForm');
    let isLoading = false;
    forms.forEach(form => {
        form.addEventListener('submit', async e => {
            e.preventDefault();  
            if(isLoading) return;
            isLoading = true;
            const submitBtn = form.querySelector('[type="submit"]');
            if (!submitBtn) return;
            button.classList.add('btn-loading');
            form.submit();
        });
    });
});
