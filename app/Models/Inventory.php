<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'inventories';

    protected $fillable = [
        'type',
        'brand',
        'model',
        'capacity',
        'item_type',
        'generation',
        'watt_capacity',
        'serial_number',
        'national_asset_tag',
        'toner_color',
        'printer_model',
        'material_type',
        'quantity',
        'is_disabled',
        'disabled_at',
        'disabled_reason',
    ];

    protected $casts = [
        'is_disabled' => 'boolean',
        'disabled_at' => 'datetime',
        'quantity' => 'integer',
    ];
}