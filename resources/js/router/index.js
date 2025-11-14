import { createRouter, createWebHistory } from 'vue-router';
import Login from '../Views/Auth/Login.vue';
import Register from '../Views/Auth/Register.vue';
import Dashboard from '../Views/Dashboard.vue';

const routes = [
  { path: '/login', name: 'login', component: Login },
  { path: '/register', name: 'register', component: Register },
  { path: '/dashboard', name: 'dashboard', component: Dashboard },
  { path: '/:catchAll(.*)', redirect: '/login' },
];

export default createRouter({
  history: createWebHistory(),
  routes,
});