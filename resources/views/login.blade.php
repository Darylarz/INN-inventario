<form 
    method="POST" 
    action="{{ route('login') }}" 
    x-data="{ 
        form: { email: '', password: '', remember: false },
        errors: {},
        isProcessing: false,
        
        async submit() {
            this.isProcessing = true;
            this.errors = {};

            try {
                // 1. Petición POST a la ruta de login de Laravel
                const response = await axios.post('{{ route('login') }}', this.form);

                // 2. Si el login es exitoso, Laravel devuelve un código 200/204
                // Redirigir al dashboard (o donde quieras)
                window.location.href = response.request.responseURL;
                
            } catch (error) {
                // 3. Manejo de errores de validación de Laravel (código 422)
                if (error.response && error.response.status === 422) {
                    this.errors = error.response.data.errors;
                } else {
                    // Manejar otros errores (servidor, conexión, etc.)
                    alert('Ocurrió un error inesperado al intentar iniciar sesión.');
                    console.error('Error de Login:', error);
                }
            } finally {
                this.isProcessing = false;
            }
        }
    }" 
    @submit.prevent="submit" {{-- Previene el envío de formulario estándar y llama a la función submit de Alpine --}}
>
    @csrf

    <div>
        <label for="email">Email</label>
        <input 
            id="email" 
            type="email" 
            x-model="form.email" 
            required 
            autofocus
            class="block mt-1 w-full"
        >
        {{-- Muestra el error de validación para el campo 'email' --}}
        <p x-show="errors.email" x-text="errors.email ? errors.email[0] : ''" class="text-sm text-red-600 mt-2"></p>
    </div>

    <div class="mt-4">
        <label for="password">Contraseña</label>
        <input 
            id="password" 
            type="password" 
            x-model="form.password" 
            required 
            autocomplete="current-password"
            class="block mt-1 w-full"
        >
        {{-- Muestra el error de validación para el campo 'password' --}}
        <p x-show="errors.password" x-text="errors.password ? errors.password[0] : ''" class="text-sm text-red-600 mt-2"></p>
    </div>
    
    <div class="flex items-center justify-end mt-4">
        <button type="submit" :disabled="isProcessing" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 disabled:opacity-50">
            <span x-show="!isProcessing">Iniciar Sesión</span>
            <span x-show="isProcessing">Cargando...</span>
        </button>
    </div>
</form>