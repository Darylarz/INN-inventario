<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoInventario extends Model
{
    use HasFactory;

    protected $table = 'tipos_inventario';
    protected $fillable = ['name'];
}
