<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PruebasController;
use App\Http\Controllers\UserController;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/welcome', function () {
    return view('welcome');
});


Route::get('/test', [PruebasController::class, 'testOrm']);

//Rutas API
Route::get('/usuario/pruebas', [UserController::class, 'pruebas']);

//Rutas de usuario
Route::post('/api/usuario/registro', [UserController::class, 'register']);
Route::post('/api/login', [UserController::class, 'login']);
