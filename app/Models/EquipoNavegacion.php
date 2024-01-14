<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipoNavegacion extends Model
{
    use HasFactory;
    protected $table = 'equipos_navegacion';
    protected $primaryKey = 'id';
    protected $fillable = [
        'NombreEquipoNavegacion',
    ];
    public $timestamps = true;
}
