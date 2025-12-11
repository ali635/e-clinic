import { createApp } from 'vue';
import './sliders.js';
import 'flowbite';

import bookService from './components/bookService.vue';

document.addEventListener("DOMContentLoaded", () => {
    // Init Vue Component
    const appElement = document.getElementById('vue-app');
    if (appElement) {
        const app = createApp({});
        app.component('book-service', bookService);
        app.mount(appElement);
    }

    // Handle Generic Forms
    const forms = document.querySelectorAll('.genericForm');
    let isLoading = false;
    forms.forEach(form => {
        form.addEventListener('submit', async e => {
            e.preventDefault();  
            if(isLoading) return;
            isLoading = true;
            const submitBtn = form.querySelector('[type="submit"]');
            if (!submitBtn) return;
            submitBtn.classList.add('btn-loading');
            form.submit();
        });
    });
});

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add("active");
        observer.unobserve(entry.target); // animate only once
      }
    });
}, { threshold: 0.5 });

document.querySelectorAll(".reveal-up").forEach((el) => {
    observer.observe(el);
});


