<template>
  <div class="p-6">
    <h1 class="text-2xl font-semibold mb-4">Editar perfil</h1>

    <form @submit.prevent="submit" class="space-y-3 max-w-md">
      <div>
        <label class="block text-sm font-medium">Nombre</label>
        <input v-model="form.name" type="text" class="w-full border rounded px-3 py-2" />
      </div>

      <div>
        <label class="block text-sm font-medium">Email</label>
        <input v-model="form.email" type="email" class="w-full border rounded px-3 py-2" />
      </div>

      <div class="flex items-center space-x-2">
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Guardar</button>
        <span v-if="saving">Guardando...</span>
      </div>
    </form>
  </div>
</template>

<script>
import { reactive, ref } from 'vue'

export default {
  name: 'ProfileEdit',
  setup() {
    const saving = ref(false)
    const form = reactive({ name: '', email: '' })

    // opcional: inicializar con datos reales si los tienes
    const load = async () => {
      try {
        const res = await window.axios.get('/api/profile') // ajusta endpoint si hace falta
        form.name = res.data.name || ''
        form.email = res.data.email || ''
      } catch (e) {
        // manejar error
      }
    }

    const submit = async () => {
      saving.value = true
      try {
        await window.axios.put('/profile', { name: form.name, email: form.email })
        alert('Perfil actualizado')
      } catch (e) {
        console.error(e)
        alert('Error al guardar')
      } finally {
        saving.value = false
      }
    }

    load()

    return { form, submit, saving }
  }
}
</script>

<style scoped>
/* estilos mínimos, opcional */
</style>