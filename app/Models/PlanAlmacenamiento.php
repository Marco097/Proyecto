<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanAlmacenamiento extends Model
{
    use HasFactory;

    
    public function nube(){
        return $this->belongsTo(Archivo::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
