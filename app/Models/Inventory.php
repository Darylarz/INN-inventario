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
        'name',
        'capacity',
        'item_type',
        'generation',
        'watt_capacity',
        'serial_number',
        'national_asset_tag',
        'toner_color',
        'printer_model',
        'material_type',
        'recycled',
        'entered_by',
        'entry_date',
        'quantity',
        'is_disabled',
        'disabled_at',
        'disabled_reason',
    ];

    protected $casts = [
        'is_disabled' => 'boolean',
        'disabled_at' => 'datetime',
        'recycled' => 'boolean',
        'entry_date' => 'date',
        'quantity' => 'integer',
    ];
}