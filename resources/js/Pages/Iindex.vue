<script setup>
import { ref } from 'vue'

// Un estado simple de contador
const contador = ref(0)

const incrementar = () => {
  contador.value++
}
</script>asd

<template>
  <div class="p-6 text-center">
    <h1 class="text-3xl font-bold mb-4">¡Bienvenido a Inertia + Vue 3!</h1>
    <p class="text-gray-600 mb-6">
      Esta es una vista de ejemplo renderizada con Inertia desde Laravel.
    </p>

    <div class="flex justify-center items-center space-x-4">
      <button
        @click="incrementar"
        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded"
      >
        Contar
      </button>
      <span class="text-lg font-semibold">Valor: {{ contador }}</span>
    </div>
  </div>
</template>
