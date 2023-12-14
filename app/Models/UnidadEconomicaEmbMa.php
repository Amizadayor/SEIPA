<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UnidadEconomicaPAFisico;
use App\Models\TipoActividad;
use App\Models\TipoCubierta;
use App\Models\MaterialCasco;

class UnidadEconomicaEmbMa extends Model
{
    use HasFactory;

    protected $table = 'unidades_economicas_emb_ma';
    protected $primaryKey = 'id';
    protected $fillable = [
        'UEDuenoid',
        'RNPA',
        'Nombre',
        'ActivoPropio',
        'NombreEmbMayor',
        'Matricula',
        'PuertoBase',
        'TPActid',
        'TPCubid',
        'CdPatrones',
        'CdMotoristas',
        'CdPescEspecializados',
        'CdPescadores',
        'AnioConstruccion',
        'MtrlCascoid',
        'Eslora',
        'Manga',
        'Puntal',
        'Calado',
        'ArqueoNeto',
        'DocAcreditacionLegalMotor',
        'DocCertificadoMatricula',
        'DocComprobanteTenenciaLegal',
        'DocCertificadoSegEmbs',
    ];
    public $timestamps = true;

    public function UnidadEconomicaPAFisico()
    {
        return $this->belongsTo(UnidadEconomicaPAFisico::class, 'UEDuenoid', 'id');
    }

    public function TipoActividad()
    {
        return $this->belongsTo(TipoActividad::class, 'TPActid', 'id');
    }

    public function TipoCubierta()
    {
        return $this->belongsTo(TipoCubierta::class, 'TPCubid', 'id');
    }

    public function MaterialCasco()
    {
        return $this->belongsTo(MaterialCasco::class, 'MtrlCascoid', 'id');
    }
}
