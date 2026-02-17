<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoArticulo extends Model
{
    use HasFactory;

    protected $table = 'tipo_articulos';
    protected $fillable = ['nombre', 'is_active']; // Agregado is_active

    protected $casts = [
        'is_active' => 'boolean', // Cast para el nuevo campo
    ];

    public function articulos()
    {
        return $this->hasMany(Articulo::class, 'tipo_articulo_id');
    }
}
