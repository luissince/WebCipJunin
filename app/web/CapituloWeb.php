<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');

use SysSoftIntegra\Src\Route;
use SysSoftIntegra\Controller\CapituloController;

require __DIR__ . './../src/autoload.php';

Route::get('list', function ($body) {
    CapituloController::list($body);
});

Route::get('allCapitulos', function ($body) {
    CapituloController::allCapitulos($body);
});

Route::get('allEspecialidades', function ($body) {
    CapituloController::allEspecialidades($body);
});

Route::post("insertCapitulo", function ($body) {
    CapituloController::insertCapitulo($body);
});

Route::post("insertEspecialidad", function ($body) {
    CapituloController::insertEspecialidad($body);
});

Route::post("updateCapitulo", function ($body) {
    CapituloController::updateCapitulo($body);
});

Route::post("updateEspecialidad", function ($body) {
    CapituloController::updateEspecialidad($body);
});

Route::post("deleteCapitulo", function ($body) {
    CapituloController::deleteCapitulo($body);
});

Route::post("deleteEspecialidad", function ($body) {
    CapituloController::deleteEspecialidad($body);
});
