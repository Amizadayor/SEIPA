<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UnidadEconomicaPAMoral;

class SocioDetallePAMoral extends Model
{
    use HasFactory;
    protected $table = 'socios_detalles_pa_moral';
    protected $primaryKey = 'id';

    protected $fillable = [
        'CURP',
        'ActvPesca',
        'ActvAcuacultura',
        'DocActaNacimiento',
        'DocComprobanteDomicilio',
        'DocCURP',
        'DocIdentificacionOfc',
        'DocRFC',
        'UEPAMid',
    ];
    public $timestamps = true;

    public function UnidadEconomicaPaMoral()
    {
        return $this->belongsTo(UnidadEconomicaPAMoral::class, 'UEPAMid', 'id');
    }
}
