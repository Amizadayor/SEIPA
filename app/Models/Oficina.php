<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Oficina extends Model
{
    use HasFactory;
    use HasFactory;
    protected $table = 'oficinas';
    protected $primaryKey = 'id';
    protected $fillable = [
        'NombreOficina',
        'Ubicacion',
        'Telefono',
        'Email'];
    public $timestamps = true;
}
