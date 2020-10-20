<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vacante;
use App\Models\CategoriaVacante;

class PruebasController extends Controller
{
    //
    public function index() {
        $animales = ['Perro', 'Gato', 'Tigre'];
    }

    public function testOrm() {

        $vacantes = Vacante::all();
        var_dump($vacantes);

        die();
    }
}
