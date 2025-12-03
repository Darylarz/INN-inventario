<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class InventoryMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'inventory_id', 'type', 'quantity', 'user_id', 'note',
    ];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
