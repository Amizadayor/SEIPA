<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipoSeguridad extends Model
{
    use HasFactory;
    protected $table = 'equipos_seguridad';
    protected $primaryKey = 'id';
    protected $fillable = [
        'NombreEquipoSeguridad',
    ];
    public $timestamps = true;
}
