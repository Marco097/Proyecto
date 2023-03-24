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

    public function tipo_archivo(){
        return $this->belongsTo(TipoArchivo::class);
    }

    public function tamaño(){
        return $this->belongsTo(Tamaño::class);
    }

    public function fecha_ingreso(){
        return $this->belongsTo(FechaIngreso::class);
    }
}
