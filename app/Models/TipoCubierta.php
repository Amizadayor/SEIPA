<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoCubierta extends Model
{
    use HasFactory;

    protected $table = 'tipos_cubierta';
    protected $primaryKey = 'id';
    protected $fillable = [
        'NombreCubierta',
    ];
    public $timestamps = true;
}
