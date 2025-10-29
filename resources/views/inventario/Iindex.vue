<script>
export default {
    name: 'indice inventario',
}
</script>

<script setup>
import { Link } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
//import AppLayout from '@/Layouts/GuestLayout.vue';
defineProps({
    project: {
        type: Object,
        required: true,
    },
})
</script>

<template>
    <GuestLayout title="indice inventario">
        <template #header>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                indice inventario
            </h1>
        </template>

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
            uashiaush
        </div>
    </AppLayout>
</template>