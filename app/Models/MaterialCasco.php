<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialCasco extends Model
{
    use HasFactory;
    protected $table = 'materiales_casco';
    protected $primaryKey = 'id';
    protected $fillable = [
        'NombreMaterialCasco'
    ];
    public $timestamps = true;
}
