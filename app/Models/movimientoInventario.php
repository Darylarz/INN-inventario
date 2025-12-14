<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Inventario;
use App\Models\Ubicacion;


class movimientoInventario extends Model
{
    use HasFactory;

    protected $table = 'movimiento_inventario';

    protected $fillable = [
        'inventario_id', 'tipo', 'cantidad', 'user_id', 'nota', 'ubicacion_id',
    ];

    public function inventario()
    {
        return $this->belongsTo(Inventario::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ubicacion()
    {
        return $this->belongsTo(Ubicacion::class);
    }
}
