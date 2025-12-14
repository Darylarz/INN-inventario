<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoInventario extends Model
{
    use HasFactory;

    protected $table = 'tipo_inventario';
    protected $fillable = ['nombre', 'created_at'];
}
