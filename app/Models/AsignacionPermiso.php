<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Rol;
use App\Models\Permiso;

class AsignacionPermiso extends Model
{
    use HasFactory;
    protected $table = 'asignacion_permisos';
    protected $primaryKey = 'id';
    protected $fillable = [
        'Rolid',
        'Permid',
        'Permitido'];
    public $timestamps = true;

    public function Rol()
    {
        return $this->belongsTo(Rol::class, 'Rolid', 'id');
    }

    public function Permiso()
    {
        return $this->belongsTo(Permiso::class, 'Permid', 'id');
    }
}
