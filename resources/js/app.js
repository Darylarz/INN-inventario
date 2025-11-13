import '../css/app.css';
import { createApp } from 'vue'
import { createRouter, createWebHistory } from 'vue-router'
import { createPinia } from 'pinia'
import axios from 'axios'

// Import main App component
import App from './App.vue'

// Import page components
import Dashboard from './Views/Dashboard.vue'
// Nota: crea estos componentes según sea necesario
import InventoryList from './Views/Inventory/InventoryList.vue'
import InventoryEdit from './Views/Inventory/InventoryEdit.vue'
// Si en el futuro creas InventoryCreate: import InventoryCreate from './Views/Inventory/InventoryCreate.vue'

// Ajuste: Profile apunta al archivo que existe en Views/Profile
import Profile from './Views/Profile/ProfileEdit.vue'
// import AdminDashboard from './Components/admin/Dashboard.vue'
// import UserManagement from './Components/admin/UserManagement.vue'

// Configure Axios
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
const token = document.head.querySelector('meta[name="csrf-token"]')
if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content
} else {
    console.error('CSRF token not found: Is it included in your Blade <head>?')
}

// Make axios globally available
window.axios = axios

// Router configuration
const routes = [
  { path: '/', redirect: '/dashboard' },
  { path: '/dashboard', component: Dashboard, meta: { requiresAuth: true } },
  { path: '/inventory', component: InventoryList, meta: { requiresAuth: true } },
  // { path: '/inventory/create', component: InventoryCreate, meta: { requiresAuth: true } },
  { path: '/inventory/:id/edit', component: InventoryEdit, meta: { requiresAuth: true } },
  { path: '/profile', component: Profile, meta: { requiresAuth: true } },
  // { path: '/admin', component: AdminDashboard, meta: { requiresAuth: true } },
  // { path: '/admin/users', component: UserManagement, meta: { requiresAuth: true } },
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

// Create Pinia store
const pinia = createPinia()

// Create and mount Vue app
const app = createApp(App)
app.use(router)
app.use(pinia)
app.config.globalProperties.$http = axios
app.mount('#app')