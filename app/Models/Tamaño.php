<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tamaño extends Model
{
    use HasFactory;

    public function archivos(){
        return $this->hasMany(Archivo::class);
    }
}
