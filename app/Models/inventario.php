<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class inventario extends Model
{
    //
    protected $table = 'inventario';
    protected $fillable = 'nombre, bien_nacional, tipo, descripcion';
}
