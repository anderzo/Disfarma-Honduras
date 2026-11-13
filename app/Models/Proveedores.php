<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedores extends Model
{
    protected $table = 'proveedores';

    protected $fillable = [
        'rtn',
        'empresa',
        'telefono',
        'contacto',
        'categoria',
        'limite_credito',
        'dias_credito',
        'estado',
    ];
}