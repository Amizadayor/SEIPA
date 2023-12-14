<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SistemaConservacion extends Model
{
    use HasFactory;
    protected $table = 'sistemas_conservacion';
    protected $primaryKey = 'id';
    protected $fillable = [
        'NombreSistemaConservacion',
    ];
    public $timestamps = true;
}
