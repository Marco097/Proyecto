<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nube extends Model
{
    use HasFactory;
    
    public function archivos(){
        return $this->hasMany(Archivo::class);
    }

    public function plan_almacenamientos(){
        return $this->hasMany(PlanAlmacenamiento::class);
    }


}
