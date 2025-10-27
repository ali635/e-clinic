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
  
    forms.forEach(form => {
      form.addEventListener('submit', async e => {
        e.preventDefault();
        clearErrors(form);
  
        const submitBtn = form.querySelector('[type="submit"]');
        setButtonLoading(submitBtn, true);
  
        const action = form.getAttribute('action');
        const method = (form.getAttribute('method') || 'POST').toUpperCase();
  
        // Collect form data
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
          
          console.log("result");
          console.log(result);
          

          if (!response.ok) {
            // Handle validation or server errors
            if (result.errors) {
              showValidationErrors(form, result.errors);
            } else {
              showGlobalError(form, result.message || 'An error occurred.');
            }
          } else {
            // ✅ Success (you can replace this later)
            if(result?.data?.redirect_url){
                window.location = result.data.redirect_url;
            }
            alert(result.message || 'Form submitted successfully!');
            form.reset();
          }
        } catch (err) {
          console.error('Submission error:', err);
          showGlobalError(form, 'Something went wrong. Please try again.');
        } finally {
          setButtonLoading(submitBtn, false);
        }
      });
    });
  });
  
  function setButtonLoading(button, isLoading) {
    if (!button) return;
    if (isLoading) {
      button.classList.add('opacity-70', 'pointer-events-none');
      button.dataset.originalText = button.innerHTML;
      button.innerHTML = 'Submitting...';
    } else {
      button.classList.remove('opacity-70', 'pointer-events-none');
      if (button.dataset.originalText) {
        button.innerHTML = button.dataset.originalText;
        delete button.dataset.originalText;
      }
    }
  }
  
  function showValidationErrors(form, errors) {
    for (const [field, messages] of Object.entries(errors)) {
      const input = form.querySelector(`[name="${field}"]`);
      if (!input) continue;
  
      let errorDiv = input.nextElementSibling;
      if (!errorDiv || !errorDiv.classList.contains('error-message')) {
        errorDiv = document.createElement('div');
        errorDiv.className = 'error-message text-red-600 text-sm mt-1';
        input.insertAdjacentElement('afterend', errorDiv);
      }
  
      errorDiv.textContent = messages[0];
      input.classList.add('border-red-500', 'focus:border-red-500');
    }
  }
  
  function clearErrors(form) {
    form.querySelectorAll('.error-message').forEach(el => el.remove());
    form.querySelectorAll('.border-red-500').forEach(el => {
      el.classList.remove('border-red-500', 'focus:border-red-500');
    });
  }
  
  function showGlobalError(form, message) {
    const div = document.createElement('div');
    div.className = 'form-error bg-red-100 text-red-700 p-2 rounded mb-3 text-sm';
    div.textContent = message;
    form.prepend(div);
    setTimeout(() => div.remove(), 5000);
  }
  