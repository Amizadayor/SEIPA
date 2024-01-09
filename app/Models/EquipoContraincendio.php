<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipoContraincendio extends Model
{
    use HasFactory;
    protected $table = 'equipos_contraincendio';
    protected $primaryKey = 'id';
    protected $fillable = [
        'NombreEquipoContraincendio'
    ];
    public $timestamps = true;
}
