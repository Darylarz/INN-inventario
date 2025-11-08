@extends('layouts.app')

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Page Header --}}
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Panel de Administración</h1>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    Gestiona usuarios, inventario y configuraciones del sistema.
                </p>
            </div>
            
            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Usuarios</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['total_users'] }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 dark:bg-green-900">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Inventario</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['total_inventory'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Quick Actions --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Acciones Rápidas</h3>
                    <div class="space-y-3">
                        @can('usuario crear')
                            <a href="{{ route('admin.users.create') }}" 
                               class="flex items-center p-3 rounded-lg border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                </svg>
                                <span class="text-gray-900 dark:text-white">Crear Nuevo Usuario</span>
                            </a>
                        @endcan
                        
                        <a href="{{ route('admin.users') }}" 
                           class="flex items-center p-3 rounded-lg border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                            <span class="text-gray-900 dark:text-white">Gestionar Usuarios</span>
                        </a>
                        
                        <a href="{{ route('admin.inventory') }}" 
                           class="flex items-center p-3 rounded-lg border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                            <svg class="w-5 h-5 text-purple-600 dark:text-purple-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            <span class="text-gray-900 dark:text-white">Gestionar Inventario</span>
                        </a>
                    </div>
                </div>
                
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Usuarios Recientes</h3>
                    <div class="space-y-3">
                        @forelse($stats['recent_users'] as $user)
                            <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50 dark:bg-gray-700">
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $user->name }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                                </div>
                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $user->created_at->diffForHumans() }}
                                </span>
                            </div>
                        @empty
                            <p class="text-gray-500 dark:text-gray-400 text-center py-4">No hay usuarios recientes</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection