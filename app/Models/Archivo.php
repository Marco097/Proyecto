<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archivo extends Model
{
    use HasFactory;
    protected $table = "archivos";

    public function nube(){
        return $this->belongsTo(Nube::class);
    }

    public function detalle_archivos(){
        return $this->hasMany(DetalleArchivo::class);
    }
}
