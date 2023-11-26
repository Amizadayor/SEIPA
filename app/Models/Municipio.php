<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Distrito;

class Municipio extends Model
{
    use HasFactory;
    protected $table = 'municipios';
    protected $primaryKey = 'id';
    protected $fillable = [
        'NombreMunicipio',
        'Disid'
    ];
    public $timestamps = true;

    public function Distrito()
    {
        return $this->belongsTo(Distrito::class, 'Disid', 'id');
    }
}
