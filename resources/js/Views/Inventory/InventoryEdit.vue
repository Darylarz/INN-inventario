<template>
  <div class="p-6 max-w-3xl">
    <h2 class="text-xl font-semibold mb-4">Editar inventario</h2>

    <form @submit.prevent="save" class="space-y-4">
      <div>
        <label class="block text-sm font-medium">Marca</label>
        <input v-model="form.brand" type="text" class="w-full border rounded px-3 py-2" />
      </div>

      <div>
        <label class="block text-sm font-medium">Modelo</label>
        <input v-model="form.model" type="text" class="w-full border rounded px-3 py-2" />
      </div>

      <div>
        <label class="block text-sm font-medium">Número de serie</label>
        <input v-model="form.serial_number" type="text" class="w-full border rounded px-3 py-2" />
      </div>

      <div>
        <label class="block text-sm font-medium">Tag</label>
        <input v-model="form.national_asset_tag" type="text" class="w-full border rounded px-3 py-2" />
      </div>

      <div class="flex items-center gap-3">
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded" :disabled="saving">
          {{ saving ? 'Guardando...' : 'Guardar' }}
        </button>

        <button type="button" class="px-4 py-2 bg-red-600 text-white rounded" @click="remove" :disabled="deleting">
          {{ deleting ? 'Eliminando...' : 'Eliminar' }}
        </button>
      </div>
    </form>
  </div>
</template>

<script>
import { reactive, ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'

export default {
  name: 'InventoryEdit',
  setup() {
    const route = useRoute()
    const router = useRouter()
    const id = route.params.id

    const form = reactive({
      brand: '',
      model: '',
      serial_number: '',
      national_asset_tag: '',
    })

    const saving = ref(false)
    const deleting = ref(false)

    const load = async () => {
      if (!id) return
      try {
        const res = await window.axios.get(`/api/inventory/${id}`)
        Object.assign(form, res.data || {})
      } catch (e) {
        console.error(e)
      }
    }

    const save = async () => {
      saving.value = true
      try {
        await window.axios.put(`/api/inventory/${id}`, form)
        alert('Guardado correctamente')
        router.push({ path: '/inventory' })
      } catch (e) {
        console.error(e)
        alert('Error al guardar')
      } finally {
        saving.value = false
      }
    }

    const remove = async () => {
      if (!confirm('¿Eliminar este elemento?')) return
      deleting.value = true
      try {
        await window.axios.delete(`/api/inventory/${id}`)
        alert('Eliminado')
        router.push({ path: '/inventory' })
      } catch (e) {
        console.error(e)
        alert('Error al eliminar')
      } finally {
        deleting.value = false
      }
    }

    onMounted(load)

    return { form, save, remove, saving, deleting }
  }
}
</script>

<style scoped>
/* Opcional: estilos mínimos */
</style>