<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticuloHardware extends Model
{
    use HasFactory;

    protected $table = 'hardware_items';

    protected $fillable = [
        'marca',
        'modelo',
        'capacidad',
        'tipo',
        'generacion',
        'capacidad_watt',
        'serial',
        'bien_nacional',
    ];
}
