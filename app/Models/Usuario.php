<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'usuarios';
    protected $fillable = ['uid', 'nombre', 'activo'];

    // Relación: Un usuario tiene muchos registros
    public function registros()
    {
        return $this->hasMany(\App\Models\Registro::class, 'uid', 'uid');
    }
}