<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Especie extends Model
{
    use HasFactory;
    protected $table = 'especies';
    protected $primaryKey = 'id';
    protected $fillable = [
        'NombreEspecie',
    ];
    public $timestamps = true;
}
