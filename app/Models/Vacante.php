<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacante extends Model
{
    use HasFactory;

    protected $table = 'vacante';

    public function user() {
        return $this->belongsTo('App\Models\User', 'user');
    }

    public function categoriasVacantes() {
        return $this->belongsTo('App\Models\CategoriaVacante', 'categoria');
    }

    public function clientes() {
        return $this->belongsTo('App\Models\Cliente', 'cliente');
    }

    public function escolaridad() {
        return $this->belongsTo('App\Models\Escolaridad');
    }

    public function areaEstudio() {
        return $this->belongsTo('App\Models\AreaEstudio');
    }
}
