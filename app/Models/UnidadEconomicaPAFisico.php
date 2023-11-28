<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Localidad;
use App\Models\Oficina;

class UnidadEconomicaPAFisico extends Model
{
    use HasFactory;
    protected $table = 'unidades_economicas_pa_fisico';
    protected $primaryKey = 'id';
    protected $fillable = [
        'FechaRegistro',
        'Ofcid',
        'RNPA',
        'CURP',
        'RFC',
        'Nombres',
        'ApPaterno',
        'ApMaterno',
        'FechaNacimiento',
        'Sexo',
        'GrupoSanguineo',
        'Email',
        'Calle',
        'NmExterior',
        'NmInterior',
        'CodigoPostal',
        'Locid',
        'IniOperaciones',
        'ActivoEmbMayor',
        'ActivoEmbMenor',
        'ActvAcuacultura',
        'ActvPesca',
        'DocActaNacimiento',
        'DocComprobanteDomicilio',
        'DocCURP',
        'DocIdentificacionOfc',
        'DocRFC',
    ];
    public $timestamps = true;

    public function Localidad()
    {
        return $this->belongsTo(Localidad::class, 'Locid', 'id');
    }

    public function Oficina()
    {
        return $this->belongsTo(Oficina::class, 'Ofcid', 'id');
    }
}
