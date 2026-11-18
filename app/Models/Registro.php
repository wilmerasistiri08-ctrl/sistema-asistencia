<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{
    protected $table = 'registros';
    public $timestamps = false;
    protected $fillable = ['uid', 'tipo', 'fecha_hora'];

    public function usuario()
    {
        return $this->belongsTo(\App\Models\Usuario::class, 'uid', 'uid');
    }
}