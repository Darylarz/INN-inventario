import '../css/app.css';
import axios from 'axios';

// Activar envío de cookies (sesión, CSRF, etc.)
axios.defaults.withCredentials = true;

import { createApp } from 'vue';
import App from './App.vue';
import router from './router';

// ---- Obtener CSRF cookie antes de montar Vue ----
axios.get('/sanctum/csrf-cookie').then(() => {
    const app = createApp(App);
    app.use(router);
    app.mount('#app');
});
