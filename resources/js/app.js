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


// document.addEventListener('DOMContentLoaded', () => {
//     const forms = document.querySelectorAll('.genericForm');
//     let isLoading = false;
//     forms.forEach(form => {
//         form.addEventListener('submit', async e => {
//             e.preventDefault();  
//             if(isLoading) return;
//             isLoading = true;
//             const submitBtn = form.querySelector('[type="submit"]');
//             if (!submitBtn) return;
//             button.classList.add('btn-loading');
//             form.submit();
//         });
//     });
// });

document.addEventListener('DOMContentLoaded', () => {
    const forms = document.querySelectorAll('.genericForm');
  
    forms.forEach(form => {
      form.addEventListener('submit', async e => {
        e.preventDefault();
  
        // Prevent double submit
        if (form.dataset.loading === 'true') return;
        form.dataset.loading = 'true';
  
        const submitBtn = form.querySelector('[type="submit"]');
        if (submitBtn) submitBtn.classList.add('btn-loading');
  
        // If it’s NOT an AJAX form → normal submit (reload)
        if (!form.classList.contains('ajaxForm')) {
          form.submit();
          return;
        }
  
        // Otherwise, handle it via AJAX (no reload)
        const action = form.getAttribute('action');
        const method = (form.getAttribute('method') || 'POST').toUpperCase();
  
        const formData = new FormData(form);
        const data = {};
        formData.forEach((value, key) => (data[key] = value));
  
        try {
          const options = { method, headers: { Accept: 'application/json' } };
          let response;
  
          if (method === 'GET') {
            const params = new URLSearchParams(data).toString();
            response = await fetch(`${action}?${params}`, options);
          } else {
            options.headers['Content-Type'] = 'application/json';
            options.body = JSON.stringify(data);
            response = await fetch(action, options);
          }
  
          const result = await response.json();
  
          if (response.ok) {
            // ✅ Success
            form.classList.add('hidden');
            const successDiv = form.parentElement.querySelector('.success');
            if (successDiv) successDiv.classList.remove('hidden');
          } else {
            // ❌ Error
            console.error('Server error:', result);
            alert(result.message || 'Something went wrong.');
          }
        } catch (error) {
          console.error('Request failed:', error);
          alert('Network error. Please try again.');
        } finally {
          form.dataset.loading = 'false';
          if (submitBtn) submitBtn.classList.remove('btn-loading');
        }
      });
    });
});
  