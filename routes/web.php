<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/',[App\Http\Controllers\HomeController::class, 'showLogin']);
Route::get('/Login',[App\Http\Controllers\HomeController::class, 'doLogin']);
Route::get('/Deslogarse',[App\Http\Controllers\HomeController::class, 'showLogin']);
Route::get('/PicadosAdmin',[App\Http\Controllers\HomeController::class, 'cambioURL']);
Route::get('/personalBusqueda',[App\Http\Controllers\EmpleadoController::class, 'verEmpleados']);
Route::get('/picados',[App\Http\Controllers\EmpleadoController::class, 'verPicados']);
Route::get('/Empresas',[App\Http\Controllers\EmpleadoController::class,'verEmpresas']);
Route::get('/EmpleadoEspecifico',[App\Http\Controllers\EmpleadoController::class,'verEmpleado']);
Route::get('/DumpBaseDatos',[App\Http\Controllers\HomeController::class, 'paginaDump']);
Route::get('/DumpOficial/Confirmado',[App\Http\Controllers\HomeController::class, 'dumpBaseDatos']);
Route::get('/Pruebas',[App\Http\Controllers\EmpleadoController::class, 'verJornadaEspecifica']);
Route::get('/GenerarDocumento',[App\Http\Controllers\EmpleadoController::class, 'generarInformeSimplificado']);
Route::post('/InsertarTrabajador',[App\Http\Controllers\EmpleadoController::class, 'inserteEmpleado']);

