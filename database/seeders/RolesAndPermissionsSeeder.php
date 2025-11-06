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
        Permission::create(['name' => 'articulo agregar']);
        Permission::create(['name' => 'articulo modificar']);
        Permission::create(['name' => 'articulo consultar']);
        Permission::create(['name' => 'articulo eliminar']);
        
        // Permisos de Reportes
        Permission::create(['name' => 'generar reporte']);


        // 2. CREAR ROLES Y ASIGNAR PERMISOS

        // Definición de Permisos para Administrador
        $permisosAdmin = [
            'articulo agregar',
            'articulo modificar',
            'articulo consultar',
            'articulo eliminar',
            'generar reporte',
        ];

        // Rol Administrador: Tiene todos los permisos
        $roleAdmin = Role::create(['name' => 'administrador']);
        $roleAdmin->givePermissionTo($permisosAdmin);


        // Definición de Permisos para Almacenista
        $permisosAlmacen = [
            'articulo agregar',
            'articulo consultar',
            'generar reporte',
        ];

        // Rol Almacenista: Solo gestiona inventario (agregar, consultar) y reportes
        $roleAlmacen = Role::create(['name' => 'almacenista']);
        $roleAlmacen->givePermissionTo($permisosAlmacen);


        // Opcional: Asignar un rol al primer usuario
        $user = \App\Models\User::first();
        if ($user) {
            $user->assignRole('administrador'); 
        }
    }
}