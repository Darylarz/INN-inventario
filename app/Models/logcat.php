<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class logcatModel extends Model
{
    protected $table = 'logcat';

    protected $fillable = [
        'user_id',
        'accion',
        'recurso',
        'sujeto_id',
        'descripcion',
        'ip',
        'user_agent',
        'propiedades',
    ];

    protected $casts = [
        'propiedades' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subject()
    {
        return $this->morphTo(null, 'sujeto_type', 'sujeto_id');
    }
}