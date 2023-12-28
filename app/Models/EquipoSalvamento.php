<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipoSalvamento extends Model
{
    use HasFactory;
    protected $table = 'equipos_salvamento';
    protected $primaryKey = 'id';
    protected $fillable = [
        'NombreEquipoSalvamento',
    ];
    public $timestamp = true;
}
