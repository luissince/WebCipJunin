<?php
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
*/
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');

use SysSoftIntegra\Src\Route;
use SysSoftIntegra\Controller\UsuarioController;

require __DIR__ . './../src/autoload.php';

Route::get("alldata", function ($body) {
    UsuarioController::alldata($body);
});

Route::get("login", function ($body) {
    UsuarioController::login($body);
});

Route::get("usuario", function ($body) {
    UsuarioController::usuario($body);
});

Route::get("listUsuario", function ($body) {
    UsuarioController::listUsuario($body);
});

Route::post("insertUsuario", function ($body) {
    UsuarioController::insertUsuario($body);
});

Route::post("deleteUsuario", function ($body) {
    UsuarioController::deleteUsuario($body);
});

Route::post("updatePerfil", function ($body) {
    UsuarioController::updatePerfil($body);
});
