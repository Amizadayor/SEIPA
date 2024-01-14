<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipoComunicacion extends Model
{
    use HasFactory;
    protected $table = 'equipos_comunicacion';
    protected $primaryKey = 'id';
    protected $fillable = [
        'NombreEquipoComunicacion'
    ];
    public $timestamps = true;
}
