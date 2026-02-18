<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_active', // Nuevo campo para gestionar el estado de activación
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
   protected function casts(): array
{
    return [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean', // Cast para el nuevo campo
    ];
}

public static function forInventario()
{
    if (auth()->user()->hasRole('administrador')) {
        return self::role(['administrador', 'almacenista'])
            ->where('is_active', 1)
            ->select('id', 'name')
            ->orderBy('name')
            ->get();
    }

    return self::role('almacenista')
        ->where('is_active', 1)
        ->select('id', 'name')
        ->orderBy('name')
        ->get();

}


//Fin del código del modelo User
}