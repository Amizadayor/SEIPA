<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UnidadEconomicaPAFisico;

class TelefonoPaFisico extends Model
{
    use HasFactory;
    protected $table = 'telefonos_pa_fisico';
    protected $primaryKey = 'id';
    protected $fillable = [
        'Numero',
        'Principal',
        'Tipo',
        'UEPAFid'
    ];
    public $timestamps = true;

    public function unidadEconomicaPAFisico()
    {
        return $this->belongsTo(UnidadEconomicaPAFisico::class, 'UEPAFid');
    }
}
