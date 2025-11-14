<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900">
    <div class="w-full max-w-md bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
      <h2 class="text-2xl font-semibold mb-4 text-center text-gray-900 dark:text-white">Crear cuenta</h2>
      <form @submit.prevent="submit" class="space-y-4">
        <div>
          <label class="block text-sm mb-1 text-gray-700 dark:text-gray-300">Nombre</label>
          <input v-model="form.name" required class="w-full px-3 py-2 border rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white" />
        </div>
        <div>
          <label class="block text-sm mb-1 text-gray-700 dark:text-gray-300">Email</label>
          <input v-model="form.email" type="email" required class="w-full px-3 py-2 border rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white" />
        </div>
        <div>
          <label class="block text-sm mb-1 text-gray-700 dark:text-gray-300">Contraseña</label>
          <input v-model="form.password" type="password" required class="w-full px-3 py-2 border rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white" />
        </div>
        <div>
          <label class="block text-sm mb-1 text-gray-700 dark:text-gray-300">Confirmar contraseña</label>
          <input v-model="form.password_confirmation" type="password" required class="w-full px-3 py-2 border rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white" />
        </div>

        <div v-if="error" class="text-sm text-red-600">{{ error }}</div>

        <div>
          <button type="submit" class="w-full px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Registrar</button>
        </div>
      </form>

      <p class="mt-4 text-center text-sm text-gray-600 dark:text-gray-400">
        ¿Ya tienes cuenta?
        <router-link to="/login" class="text-indigo-600 hover:underline">Inicia sesión</router-link>
      </p>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
export default {
  name: 'Register',

  data() {
    return {
      form: {
        name: '',
        email: '',
        password: '',
        password_confirmation: ''
      },
      error: null
    }
  },

  methods: {
    submit() {
      this.error = null;

      axios.post('/register', this.form)
        .then(() => {
          this.$router.push('/dashboard');
        })
        .catch(err => {
          const errors = err.response?.data?.errors;

          if (errors) {
            this.error = Object.values(errors).flat().join(" ");
            return;
          }

          this.error = "Error al registrar";
        });
    }
  }
}
</script>
<style scoped>  </style>