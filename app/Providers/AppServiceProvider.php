<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use App\Http\Livewire\InventoryDashboard;
use App\Http\Livewire\InventoryCreate;
use App\Http\Livewire\InventoryEdit;

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
    }
}
