<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Localidad;
use App\Models\Oficina;
use App\Models\UnidadEconomicaPAFisico;

class UnidadEconomicaPAMoral extends Model
{
    use HasFactory;
    protected $table = 'unidades_economicas_pa_moral';
    protected $primaryKey = 'id';
    protected $fillable = [
        'UEDuenoid',
        'Ofcid',
        'FechaRegistro',
        'RNPA',
        'RFC',
        'RazonSocial',
        'Email',
        'Calle',
        'NmExterior',
        'NmInterior',
        'CodigoPostal',
        'Locid',
        'NmPrincipal',
        'TpNmPrincipal',
        'NmSecundario',
        'TpNmSecundario',
        'IniOperaciones',
        'ActivoEmbMayor',
        'ActivoEmbMenor',
        'ActvAcuacultura',
        'ActvPesca',
        'DocRepresentanteLegal',
        'DocActaConstitutiva',
        'DocActaAsamblea',
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

    public function UnidadEconomicaPaFisico()
    {
        return $this->belongsTo(UnidadEconomicaPAFisico::class, 'UEDuenoid', 'id');
    }
}
