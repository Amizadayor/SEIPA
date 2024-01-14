<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoMotor extends Model
{
    use HasFactory;

    protected $table = 'tipos_motor';
    protected $primaryKey = 'id';
    protected $fillable = [
        'NombreTipoMotor',
    ];
    public $timestamps = true;
}
