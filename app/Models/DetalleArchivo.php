<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleArchivo extends Model
{
    use HasFactory;

    public function archivo(){
        return $this->belongsTo(Archivo::class);
    }
}
