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

export default {
  name: 'App',
  setup() {
    const router = useRouter()
    const loading = ref(false)
    
    const logout = async () => {
      loading.value = true
      try {
        await axios.post('/logout')
        window.location.href = '/login'
      } catch (error) {
        console.error('Logout error:', error)
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
  @apply inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-200;
  @apply border-transparent text-gray-500 dark:text-gray-300 hover:border-gray-300 hover:text-gray-700 dark:hover:text-gray-200;
}

.nav-link.active {
  @apply border-indigo-500 text-gray-900 dark:text-white;
}
</style>