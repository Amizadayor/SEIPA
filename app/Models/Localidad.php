<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Municipio;

class Localidad extends Model
{
    use HasFactory;
    protected $table = 'localidades';
    protected $primaryKey = 'id';
    protected $fillable = [
        'NombreLocalidad',
        'Munid'
    ];
    public $timestamps = true;

    public function Municipio()
    {
        return $this->belongsTo(Municipio::class, 'Munid', 'id');
    }
}
