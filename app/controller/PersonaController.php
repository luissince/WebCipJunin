<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');

require '../model/PersonaAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if($_GET["type"] === "alldata"){
        $nombres = $_GET['nombres'];
        $posicionPagina = $_GET['posicionPagina'];
        $filasPorPagina = $_GET['filasPorPagina'];
        $personas = PersonaAdo::getAll($nombres,intval($posicionPagina),intval($filasPorPagina));
        if(is_array($personas)){
            echo json_encode(array(
                "estado" => 1,
                "personas"=>$personas[0],
                "total"=>$personas[1]
            ));
        }else{
            echo json_encode(array(
                "estado" => 2,
                "message"=>$personas
            ));
        }
    }else if($_GET["type"] === "data"){
        $persona = PersonaAdo::getId($_GET["dni"]);
        if(is_object($persona)){
            echo json_encode(array(
                "estado" => 1,
                "object"=>$persona
            ));
        }else{
            echo json_encode(array(
                "estado" => 2,
                "message"=>$persona
            ));
        }        
    }    
    
}else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if($_POST["type"] == "update"){
        $persona["dni"] = $_POST["dni"];
        $persona["nombres"] = $_POST["nombres"];
        $persona["apellidos"] = $_POST["apellidos"];
        $persona["sexo"] = $_POST["sexo"];
        $persona["nacimiento"] = $_POST["nacimiento"];
        $persona["estado_civil"] = $_POST["estado_civil"];
        $persona["ruc"] = $_POST["ruc"];
        $persona["rason_social"] = $_POST["rason_social"];
        $persona["cip"] = $_POST["cip"];
        $persona["condicion"] = $_POST["condicion"];

        $result = PersonaAdo::update($persona);
        if($result == "updated"){
            echo json_encode(array(
                "estado" => 1,
                "message"=>"Se actualizo correctamente los datos"
            ));
        }else{
            echo json_encode(array(
                "estado" => 2,
                "message"=>$result
            ));
        }
    } else if($_POST["type"] == "create"){
        $persona["dni"] = $_POST["dni"];
        $persona["nombres"] = $_POST["nombres"];
        $persona["apellidos"] = $_POST["apellidos"];
        $persona["sexo"] = $_POST["sexo"];
        $persona["nacimiento"] = $_POST["nacimiento"];
        $persona["estado_civil"] = $_POST["estado_civil"];
        $persona["ruc"] = $_POST["ruc"];
        $persona["rason_social"] = $_POST["rason_social"];
        $persona["cip"] = $_POST["cip"];
        $persona["condicion"] = $_POST["condicion"];

        $result = PersonaAdo::insert($persona);
        if($result == "create"){
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se insertarron correctamente los datos"
            ));
        }else{
            echo json_encode(array(
                "estado" => 2,
                "message" => $result
            ));
        }
    }
}

