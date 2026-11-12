<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicamentos extends Model
{
    protected $table = 'medicamentos';

    protected $fillable = [
        'codigo',
        'nombreMedicamento',
        'categoria',
        'precio',
        'costo',
        'inventario',
        'imagen',
        'laboratorio',
        'numero_lote',
        'vencimiento',
    ];
}