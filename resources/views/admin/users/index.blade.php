@extends('layouts.app')

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Page Header --}}
            <div class="mb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Gestión de Usuarios</h1>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            Administra los usuarios del sistema y sus permisos.
                        </p>
                    </div>
                    @can('usuario crear')
                        <a href="{{ route('admin.users.create') }}" 
                           class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Crear Usuario
                        </a>
                    @endcan
                </div>
            </div>
            
            {{-- Success Messages --}}
            @if (session('status'))
                <div class="mb-6 bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-700 rounded-md p-4">
                    <div class="flex">
                        <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="ml-3 text-sm font-medium text-green-800 dark:text-green-200">
                            {{ session('status') }}
                        </p>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 bg-red-50 dark:bg-red-900 border border-red-200 dark:border-red-700 rounded-md p-4">
                    <div class="flex">
                        <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="ml-3 text-sm font-medium text-red-800 dark:text-red-200">
                            {{ session('error') }}
                        </p>
                    </div>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                {{-- Search Bar --}}
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between items-center">
                        <div class="flex-1 max-w-md relative">
                            <input 
                                id="search-input"
                                type="text" 
                                value="{{ request('search') ?? '' }}"
                                placeholder="Buscar por nombre o email..." 
                                class="p-2 pr-16 border border-gray-300 rounded-lg w-full dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            >
                            
                            @if(request('search'))
                                <button 
                                    id="clear-search"
                                    type="button"
                                    class="absolute right-8 top-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                                    title="Limpiar búsqueda"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            @endif
                            
                            <div id="loading-spinner" class="absolute right-2 top-2 hidden">
                                <svg class="animate-spin h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 714 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                        </div>
                        
                        <div class="ml-4">
                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $users->total() }} usuarios
                            </span>
                        </div>
                    </div>
                </div>
                
                {{-- Users Table --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Usuario</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Rol</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Fecha Registro</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($users as $user)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center">
                                                    <span class="text-sm font-medium text-indigo-600 dark:text-indigo-400">
                                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->name }}</div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($user->roles->count() > 0)
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                                {{ $user->hasRole('administrador') ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' }}">
                                                {{ ucfirst($user->roles->first()->name) }}
                                            </span>
                                        @else
                                            <span class="text-gray-500 dark:text-gray-400">Sin rol</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $user->created_at->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                        @can('usuario modificar')
                                            <a href="{{ route('admin.users.edit', $user) }}" 
                                               class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-200">
                                                Editar
                                            </a>
                                        @endcan
                                        
                                        @can('usuario eliminar')
                                            @if($user->id !== auth()->id())
                                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" 
                                                      onsubmit="return confirm('¿Estás seguro de que deseas eliminar este usuario?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-200 focus:outline-none">
                                                        Eliminar
                                                    </button>
                                                </form>
                                            @endif
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-8 text-gray-500 dark:text-gray-400">
                                        @if(request('search'))
                                            No se encontraron usuarios que coincidan con "{{ request('search') }}".
                                        @else
                                            No hay usuarios registrados.
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                {{-- Pagination --}}
                @if($users->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <script>
        // Simple search functionality
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search-input');
            const spinner = document.getElementById('loading-spinner');
            const clearButton = document.getElementById('clear-search');
            let searchTimeout;
            
            if (searchInput.value) {
                searchInput.focus();
                searchInput.setSelectionRange(searchInput.value.length, searchInput.value.length);
            }
            
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                const searchTerm = this.value.trim();
                
                searchTimeout = setTimeout(() => {
                    if (searchTerm === '') {
                        window.location.href = '{{ route("admin.users") }}';
                        return;
                    }
                    
                    spinner.classList.remove('hidden');
                    window.location.href = `{{ route("admin.users") }}?search=${encodeURIComponent(searchTerm)}`;
                }, 300);
            });
            
            if (clearButton) {
                clearButton.addEventListener('click', function() {
                    searchInput.value = '';
                    window.location.href = '{{ route("admin.users") }}';
                });
            }
        });
    </script>
@endsection