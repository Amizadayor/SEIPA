<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Region;

class Distrito extends Model
{
    use HasFactory;
    protected $table = 'distritos';
    protected $primaryKey = 'id';
    protected $fillable = [
        'NombreDistrito',
        'Regid'
    ];
    public $timestamps = true;

    public function Region()
    {
        return $this->belongsTo(Region::class, 'Regid', 'id');
    }
}
