<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaEstudio extends Model
{
    use HasFactory;

    protected $table = 'area_estudio';

    public function vacantes() {
        return $this->hasMany('App\Models\Vacantes');
    }
}
