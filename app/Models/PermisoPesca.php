<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Especie;

class PermisoPesca extends Model
{
    use HasFactory;
    protected $table = 'permisos_pesca';
    protected $primaryKey = 'id';
    protected $fillable = [
        'NombrePermiso',
        'TPEspecieid'
    ];
    public $timestamps = true;

    public function Especie()
    {
        return $this->belongsTo(Especie::class, 'TPEspecieid', 'id');
    }
}
