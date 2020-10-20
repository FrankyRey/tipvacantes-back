<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaVacante extends Model
{
    use HasFactory;

    protected $table = 'categoria_vacante';

    public function vacantes() {
        return $this->hasMany('App\Models\Vacantes');
    }
}
