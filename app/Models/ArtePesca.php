<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArtePesca extends Model
{
    use HasFactory;
    protected $table = 'artes_pesca';
    protected $primaryKey = 'id';
    protected $fillable = [
        'NombreArtePesca'
    ];
    public $timestamps = true;
}
