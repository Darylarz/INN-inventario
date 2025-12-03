<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Livewire\Livewire;
use App\Http\Livewire\InventoryDashboard;
use App\Http\Livewire\InventoryCreate;
use App\Http\Livewire\InventoryEdit;
use App\Models\Inventory;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);

        // Registro explícito Livewire (evita problemas de auto-discovery)
        Livewire::component('inventory-dashboard', InventoryDashboard::class);
        Livewire::component('inventory-create', InventoryCreate::class);
        Livewire::component('inventory-edit', InventoryEdit::class);

        // Compartir el conteo de inventario con navbar y sidebar
        View::composer(['components.navbar', 'components.sidebar'], function ($view) {
            try {
                // Total de unidades (suma de quantity). Si la columna no existe aún, capturamos excepción.
                $totalUnits = Inventory::query()->sum('quantity');
            } catch (\Throwable $e) {
                $totalUnits = 0;
            }
            $view->with('inventoryCount', (int) $totalUnits);
        });
    }
}
