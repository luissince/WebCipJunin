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
use SysSoftIntegra\Controller\DirectivoController;

require __DIR__ . './../src/autoload.php';

Route::get("list", function($body){
    DirectivoController::list($body);
});

Route::get("id", function($body){
    DirectivoController::id($body);
});

Route::get("delete", function($body){
    DirectivoController::delete($body);
});

Route::post("insert", function($body){
    DirectivoController::insert($body);
});

Route::post("update", function($body){
    DirectivoController::update($body);
});

Route::get("listTbDirectorio", function($body){
    DirectivoController::listTbDirectorio($body);
});
