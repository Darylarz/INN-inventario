<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ubicacion extends Model
{
    use HasFactory;

    protected $table = 'ubicaciones';

    protected $fillable = ['nombre', 'codigo', 'descripcion', 'is_active']; // Agregado is_active

    protected $casts = [
        'is_active' => 'boolean', // Cast para el nuevo campo
    ];
}
