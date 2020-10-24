<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PruebasController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AreaEstudioController;
use App\Http\Controllers\CategoriaVacanteController;
use App\Http\Controllers\EscolaridadController;
use App\Http\Middleware\ApiAuthMiddleware;
use Facade\FlareClient\Api;

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
Route::put('/api/user/update', [UserController::class, 'update']);
Route::post('/api/user/upload', [UserController::class, 'upload'])->middleware(ApiAuthMiddleware::class);
Route::get('/api/user/avatar/{filename}', [UserController::class, 'getImage']);
Route::get('/api/user/profile/{id}', [UserController::class, 'profile']);

//Rutas de Catalogos
Route::resource('/api/catalogos/areaestudio', AreaEstudioController::class);
Route::resource('/api/catalogos/categoriavacante', CategoriaVacanteController::class);
Route::resource('/api/catalogos/escolaridad', EscolaridadController::class);

