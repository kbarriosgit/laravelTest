<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Persona extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'persona';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nombre',
        'edad',
        'fecha_actual',
        'fecha_inicio_primaria',
        'fecha_inicio_secundaria'
    ];
}
