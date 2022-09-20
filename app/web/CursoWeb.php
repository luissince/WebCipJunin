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
use SysSoftIntegra\Controller\CursoController;

require __DIR__ . './../src/autoload.php';

Route::get("alldata", function ($body) {
    CursoController::getAll($body);
});

Route::get("id", function ($body) {
    CursoController::id($body);
});

Route::post("insert", function ($body) {
    CursoController::insert($body);
});

Route::post("update", function ($body) {
    CursoController::update($body);
});

Route::post("delete", function ($body) {
    CursoController::delete($body);
});
