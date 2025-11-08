<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Limpiar caché de permisos (Siempre es bueno hacerlo antes de manipular permisos)
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. CREAR PERMISOS GRANULARES
        
        // Permisos de Artículos (Inventario)
        Permission::firstOrCreate(['name' => 'articulo agregar']);
        Permission::firstOrCreate(['name' => 'articulo modificar']);
        Permission::firstOrCreate(['name' => 'articulo consultar']);
        Permission::firstOrCreate(['name' => 'articulo eliminar']);
        
        // Permisos de Reportes
        Permission::firstOrCreate(['name' => 'generar reporte']);
        
        // Permisos de Administración de Usuarios
        Permission::firstOrCreate(['name' => 'usuario crear']);
        Permission::firstOrCreate(['name' => 'usuario modificar']);
        Permission::firstOrCreate(['name' => 'usuario consultar']);
        Permission::firstOrCreate(['name' => 'usuario eliminar']);
        
        // Permisos de Administración General
        Permission::firstOrCreate(['name' => 'admin panel']);


        // 2. CREAR ROLES Y ASIGNAR PERMISOS

        // Definición de Permisos para Administrador
        $permisosAdmin = [
            'articulo modificar',
            'articulo consultar', 
            'articulo eliminar',
            'generar reporte',
            'usuario crear',
            'usuario modificar',
            'usuario consultar',
            'usuario eliminar',
            'admin panel',
        ];
        
        // NOTA: Admin NO tiene 'articulo agregar' según requerimientos

        // Rol Administrador: Tiene todos los permisos
        $roleAdmin = Role::firstOrCreate(['name' => 'administrador']);
        $roleAdmin->syncPermissions($permisosAdmin);


        // Definición de Permisos para Almacenista
        $permisosAlmacen = [
            'articulo agregar',
            'articulo consultar',
            'generar reporte',
        ];

        // Rol Almacenista: Solo gestiona inventario (agregar, consultar) y reportes
        $roleAlmacen = Role::firstOrCreate(['name' => 'almacenista']);
        $roleAlmacen->syncPermissions($permisosAlmacen);


        // Opcional: Asignar un rol al primer usuario
        $user = \App\Models\User::first();
        if ($user) {
            $user->assignRole('administrador'); 
        }
    }
}