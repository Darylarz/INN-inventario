<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Inventario extends Model
{
    use HasFactory;

    protected $table = 'inventario';

    public function getRouteKeyName()
{
    return 'uuid';
}


protected static function boot()
{
    parent::boot();

    static::creating(function ($model) {
        $model->uuid = (string) Str::uuid();
    });
}

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