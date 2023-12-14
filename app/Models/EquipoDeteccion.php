<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipoDeteccion extends Model
{
    use HasFactory;
    protected $table = 'equipos_deteccion';
    protected $primaryKey = 'id';
    protected $fillable = [
        'NombreEquipo'
    ];
    public $timestamps = true;
}
