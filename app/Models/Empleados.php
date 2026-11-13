<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleados extends Model
{
    protected $table = 'empleados';

    protected $fillable = [
        'identidad',
        'nombre',
        'apellido',
        'correo',
        'cargo',
        'salario',
        'fecha_ingreso',
        'estado',
    ];
}