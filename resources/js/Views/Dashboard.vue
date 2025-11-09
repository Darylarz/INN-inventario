<template>
  <div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <!-- Page Header -->
      <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Dashboard</h1>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
          Gestión de inventario del Instituto Nacional de Nutrición
        </p>
      </div>

      <!-- Search Bar -->
      <div class="mb-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Buscar Inventario</h2>
        </div>
        
        <div class="flex space-x-4">
          <div class="flex-1 relative">
            <input 
              v-model="searchTerm"
              @input="handleSearch"
              type="text" 
              placeholder="Buscar culo sucio por marca, modelo, serie o bien nacional..." 
              class="w-full p-3 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
            >
            
            <button 
              v-if="searchTerm"
              @click="clearSearch"
              class="absolute right-3 top-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
            >
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
            </button>
          </div>
        </div>
      </div>

      <!-- Inventory Table -->
      <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
          <div class="flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Inventario</h3>
            <span class="text-sm text-gray-500 dark:text-gray-400">
              {{ inventories.length }} elementos
            </span>
          </div>
        </div>
        
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tipo</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Marca/Modelo</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Serie</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Bien Nacional</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Acciones</th>
              </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
              <tr v-for="item in inventories" :key="item.id">
                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                    {{ item.type }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm font-medium text-gray-900 dark:text-white">{{ item.brand }}</div>
                  <div class="text-sm text-gray-500 dark:text-gray-400">{{ item.model }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                  {{ item.serial_number || 'N/A' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                  {{ item.national_asset_tag || 'N/A' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                  <router-link 
                    :to="`/inventory/${item.id}/edit`"
                    class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-200 mr-4"
                  >
                    Editar
                  </router-link>
                  <button 
                    @click="deleteItem(item)"
                    class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-200"
                  >
                    Eliminar
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
          
          <div v-if="inventories.length === 0" class="text-center py-8 text-gray-500 dark:text-gray-400">
            <p v-if="searchTerm">No se encontraron elementos que coincidan con "{{ searchTerm }}".</p>
            <p v-else>No hay elementos en el inventario.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue'

export default {
  name: 'Dashboard',
  setup() {
    const inventories = ref([])
    const searchTerm = ref('')
    const loading = ref(false)
    
    const fetchInventories = async (search = '') => {
      loading.value = true
      try {
        const response = await axios.get('/api/inventory', {
          params: { search }
        })
        inventories.value = response.data.data || response.data
      } catch (error) {
        console.error('Error fetching inventories:', error)
      } finally {
        loading.value = false
      }
    }
    
    const handleSearch = () => {
      fetchInventories(searchTerm.value)
    }
    
    const clearSearch = () => {
      searchTerm.value = ''
      fetchInventories()
    }
    
    const deleteItem = async (item) => {
      if (confirm(`¿Estás seguro de que deseas eliminar ${item.brand} ${item.model}?`)) {
        try {
          await axios.delete(`/inventory/${item.id}`)
          await fetchInventories(searchTerm.value)
        } catch (error) {
          console.error('Error deleting item:', error)
          alert('Error al eliminar el elemento')
        }
      }
    }
    
    onMounted(() => {
      fetchInventories()
    })
    
    return {
      inventories,
      searchTerm,
      loading,
      handleSearch,
      clearSearch,
      deleteItem
    }
  }
}
</script>