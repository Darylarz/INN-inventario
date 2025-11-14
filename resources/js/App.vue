<template>
  <div id="app" class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Navigation -->
    <nav class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex items-center">
            <!-- Logo -->
            <router-link to="/dashboard" class="flex items-center">
              <h1 class="text-xl font-bold text-gray-900 dark:text-white">INN Inventario</h1>
            </router-link>
            
            <!-- Navigation Links -->
            <div class="hidden md:ml-10 md:flex md:space-x-8">
              <router-link 
                to="/dashboard" 
                class="nav-link"
                :class="{ 'active': $route.path === '/dashboard' }"
              >
                Dashboard
              </router-link>
              
              <router-link 
                to="/inventory/create" 
                class="nav-link"
                :class="{ 'active': $route.path === '/inventory/create' }"
              >
                Agregar Ítem
              </router-link>
              
              <router-link 
                to="/profile" 
                class="nav-link"
                :class="{ 'active': $route.path === '/profile' }"
              >
                Perfil
              </router-link>
              
              <router-link 
                to="/admin" 
                class="nav-link"
                :class="{ 'active': $route.path.startsWith('/admin') }"
              >
                Admin
              </router-link>
            </div>
          </div>
          
          <!-- User Menu -->
          <div class="flex items-center">
            <button 
              @click="logout"
              class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 transition-colors duration-200"
            >
              Cerrar Sesión
            </button>
          </div>
        </div>
      </div>
    </nav>
    
    <!-- Main Content -->
    <main class="flex-1">
      <router-view />
    </main>
    
    <!-- Loading Overlay -->
    <div v-if="loading" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white rounded-lg p-6 flex items-center space-x-4">
        <svg class="animate-spin h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <span class="text-gray-900">Cargando...</span>
      </div>
    </div>
  </div>
</template>

<script>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'

export default {
  name: 'App',
  setup() {
    const router = useRouter()
    const loading = ref(false)

    const logout = async () => {
      loading.value = true
      try {
        await axios.post('/logout')
        // usar router para mantener SPA navigation
        router.push('/login')
      } catch (error) {
        console.error('Logout error:', error)
        router.push('/login')
      } finally {
        loading.value = false
      }
    }

    return {
      loading,
      logout
    }
  }
}
</script>

<style scoped>
.nav-link {
  display: inline-flex;
  align-items: center;
  padding-left: 0.25rem;
  padding-right: 0.25rem;
  padding-top: 0.25rem;
  border-bottom-width: 2px;
  font-size: 0.875rem;
  font-weight: 500;
  transition: color 0.2s, border-color 0.2s, background-color 0.2s;
  border-color: transparent;
  color: #6B7280; /* tailwind gray-500 */
}

/* dark mode variants (assumes a .dark ancestor class on root/body) */
.dark .nav-link {
  color: #D1D5DB; /* tailwind gray-300 */
}

.nav-link:hover {
  border-color: #D1D5DB; /* tailwind gray-300 */
  color: #374151; /* tailwind gray-700 */
}

.dark .nav-link:hover {
  color: #E5E7EB; /* tailwind gray-200 */
}

.nav-link.active {
  border-color: #6366F1; /* tailwind indigo-500 */
  color: #111827; /* tailwind gray-900 */
}

.dark .nav-link.active {
  color: #FFFFFF;
  border-color: #6366F1;
}
</style>