<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoActivo extends Model
{
    use HasFactory;
    protected $table = 'tipos_activo';
    protected $primaryKey = 'id';
    protected $fillable = [
        'NombreActivo',
        'Clave',
    ];
    public $timestamps = true;
}
