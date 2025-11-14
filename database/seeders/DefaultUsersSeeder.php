<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role; // Importar el modelo Role de Spatie

class DefaultUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Verificar si los roles existen (necesario si este seeder se ejecuta después de RolesAndPermissionsSeeder)
        $adminRole = Role::where('name', 'administrador')->first();
        $almacenistaRole = Role::where('name', 'almacenista')->first();

        // Si los roles no existen, no podemos asignar nada.
        if (!$adminRole || !$almacenistaRole) {
            $this->command->warn('Los roles "administrador" o "almacenista" no existen. Ejecuta primero RolesAndPermissionsSeeder.');
            return;
        }


        // 2. Crear USUARIO ADMINISTRADOR
        $admin = User::firstOrCreate(
            ['email' => 'admin@inn.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('12345678'),
            ]
        );
        
        // Asignar el rol de Administrador
        if (!$admin->hasRole('administrador')) {
            $admin->assignRole($adminRole);
            $this->command->info('nombre: Admin, clave: 12345678, correo: admin@inn.com, Administrador');
        }


        // 3. Crear USUARIO ALMACENISTA (Operador)
        $almacenista = User::firstOrCreate(
            ['email' => 'operador@inn.com'],
            [
                'name' => 'Operador',
                'password' => Hash::make('12345678'),
            ]
        );

        // Asignar el rol de Almacenista
        if (!$almacenista->hasRole('almacenista')) {
            $almacenista->assignRole($almacenistaRole);
            $this->command->info('nombre: Operador, clave: 12345678, correo: operador@inn.com, almacenista');
        }
    }
}
