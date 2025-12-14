<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inventario extends Model
{
    use HasFactory;

    protected $table = 'inventario';

    protected $fillable = [
        'tipo',
        'marca',
        'modelo',
        'nombre',
        'capacidad',
        'tipo_item',
        'generacion',
        'capacidad_watt',
        'numero_serial',
        'bien_nacional',
        'toner_color',
        'modelo_impresora',
        'tipo_material',
        'reciclado',
        'ingresado_por',
        'fecha_ingreso',
        'cantidad',
        'esta_desactivado',
        'fecha_desactivado',
        'razon_desactivado',
    ];

    protected $casts = [
        'esta_desactivado' => 'boolean',
        'fecha_desactivado' => 'datetime',
        'reciclar' => 'boolean',
        'fecha_ingresado' => 'date',
        'cantidad' => 'integer',
    ];
}