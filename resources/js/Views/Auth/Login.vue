<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900">
    <div class="w-full max-w-md bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
      <h2 class="text-2xl font-semibold mb-4 text-center text-gray-900 dark:text-white">Iniciar sesión</h2>
      <form @submit.prevent="submit" class="space-y-4">
        <div>
          <label class="block text-sm mb-1 text-gray-700 dark:text-gray-300">Email</label>
          <input v-model="form.email" type="email" required class="w-full px-3 py-2 border rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white" />
        </div>
        <div>
          <label class="block text-sm mb-1 text-gray-700 dark:text-gray-300">Contraseña</label>
          <input v-model="form.password" type="password" required class="w-full px-3 py-2 border rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white" />
        </div>

        <div v-if="error" class="text-sm text-red-600">{{ error }}</div>

        <div class="flex items-center justify-between">
          <button type="submit" class="w-full px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Entrar</button>
        </div>
      </form>

      <p class="mt-4 text-center text-sm text-gray-600 dark:text-gray-400">
        ¿No tienes cuenta?
        <router-link to="/register" class="text-indigo-600 hover:underline">Crear una</router-link>
      </p>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'Login',
  data() {
    return {
      form: { email: '', password: '' },
      error: null
    }
  },

  methods: {
    submit() {
      this.error = null;

      axios.post('/login', this.form)
        .then(() => {
          this.$router.push('/dashboard');
        })
        .catch(err => {

          // Errores de validación 422
          if (err.response?.data?.errors) {
            this.error = Object.values(err.response.data.errors).flat().join(" ");
            return;
          }

          // Mensaje directo desde Laravel
          if (err.response?.data?.message) {
            this.error = err.response.data.message;
            return;
          }

          // Error genérico
          this.error = "Error al iniciar sesión";
        });
    }
  }
}
</script>
<style scoped>  </style>