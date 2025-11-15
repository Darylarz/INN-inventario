<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consumible extends Model
{
    use HasFactory;

    protected $table = 'consumables';

    protected $fillable = [
        'categoria',  // toner o material para impresora
        'marca',
        'modelo',
        'modelo_impresora',
        'color',
        'tipo_material',
        'impresora_destino',
    ];
}
    