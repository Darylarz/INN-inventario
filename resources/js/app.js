import '../css/app.css';

import './bootstrap'; // Mantiene la configuración base de Laravel (por ejemplo, headers de Axios)
import Alpine from 'alpinejs';
import axios from 'axios';

// Haz Alpine y Axios globales
window.Alpine = Alpine;
window.axios = axios;

// **CRUCIAL para las peticiones en Laravel**
// Esto suele estar en './bootstrap.js', pero asegúrate de que el token CSRF esté configurado
let token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
    window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
} else {
    console.error('CSRF token not found: Is it included in your Blade <head>?');
}

window.Alpine = Alpine;

Alpine.start();