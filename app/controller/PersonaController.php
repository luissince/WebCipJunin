<?php

date_default_timezone_set('America/Lima');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');
require '../model/PersonaAdo.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if ($_GET["type"] === "alldata") {
        $nombres = $_GET['nombres'];
        $posicionPagina = $_GET['posicionPagina'];
        $filasPorPagina = $_GET['filasPorPagina'];
        $personas = PersonaAdo::getAll($nombres, intval($posicionPagina), intval($filasPorPagina));
        if (is_array($personas)) {
            echo json_encode(array(
                "estado" => 1,
                "personas" => $personas[0],
                "total" => $personas[1]
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $personas
            ));
        }
    } else if ($_GET["type"] === "data") {
        $persona = PersonaAdo::getId($_GET["dni"]);
        if (is_array($persona)) {
            echo json_encode(array(
                "estado" => 1,
                "persona" => $persona[0],
                "imagen" => $persona[1]
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $persona
            ));
        }
    } else if ($_GET["type"] === "datacobro") {
        $persona = PersonaAdo::getIdCobros($_GET["dni"]);
        if (is_array($persona)) {
            echo json_encode(array(
                "estado" => 1,
                "persona" => $persona[0],
                "colegiatura" => $persona[1],
                "years" => $persona[2],
                "date" => $persona[3],
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $persona
            ));
        }
    } else if ($_GET["type"] === "historialpago") {
        $posicionPagina = $_GET['posicionPagina'];
        $filasPorPagina = $_GET['filasPorPagina'];
        $historial = PersonaAdo::getHistorialPagos($_GET["dni"], intval($posicionPagina), intval($filasPorPagina));
        if (is_array($historial)) {
            echo json_encode(array(
                "estado" => 1,
                "historial" => $historial[0],
                "total" => $historial[1]
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $historial
            ));
        }
    } else if ($_GET["type"] === "listdata") {
        $search = $_GET["search"];
        $posicionPagina = $_GET['posicionPagina'];
        $filasPorPagina = $_GET['filasPorPagina'];
        $personas = PersonaAdo::getAllModal($search, intval($posicionPagina), intval($filasPorPagina));
        if (is_array($personas)) {
            echo json_encode(array(
                "estado" => 1,
                "personas" => $personas[0],
                "total" => $personas[1]
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $personas
            ));
        }
    } else if ($_GET["type"] === "getcolegiatura") {
        $arrayColegiaturas =  PersonaAdo::getColegiatura($_GET['idDni']);

        if (is_array($arrayColegiaturas)) {
            echo json_encode(array(
                "estado" => 1,
                "data" => $arrayColegiaturas,
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $arrayColegiaturas
            ));
        }
    } else if ($_GET["type"] === "getdomicilio") {
        $arrayDomicilio = PersonaAdo::getDomicilio($_GET['idDni']);

        if (is_array($arrayDomicilio)) {
            echo json_encode(array(
                "estado" => 1,
                "data" =>  $arrayDomicilio,
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $arrayDomicilio
            ));
        }
    } else if ($_GET["type"] === 'gettelefono') {
        $arrayTelefono = PersonaAdo::getTelefono($_GET['idDni']);

        if (is_array($arrayTelefono)) {
            echo json_encode(array(
                "estado" => 1,
                "data" =>  $arrayTelefono,
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $arrayTelefono
            ));
        }
    } else if ($_GET["type"] === 'getconyuge') {
        $arrayConyuge = PersonaAdo::getConyuge($_GET['idDni']);

        if (is_array($arrayConyuge)) {
            echo json_encode(array(
                "estado" => 1,
                "data" =>  $arrayConyuge
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $arrayConyuge
            ));
        }
    } else if ($_GET["type"] === 'getexperiencia') {
        $arrayExperiencia = PersonaAdo::getExperiencia($_GET['idDni']);

        if (is_array($arrayExperiencia)) {
            echo json_encode(array(
                "estado" => 1,
                "data" => $arrayExperiencia,
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $arrayExperiencia
            ));
        }
    } else if ($_GET["type"] === 'getgradosyestudios') {
        $arraygradosyestudios = PersonaAdo::getGradosyEstudios($_GET['idDni']);

        if (is_array($arraygradosyestudios)) {
            echo json_encode(array(
                "estado" => 1,
                "data" => $arraygradosyestudios,
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $arraygradosyestudios
            ));
        }
    } else if ($_GET["type"] === 'getcorreoyweb') {
        $arrayCorreoyWeb = PersonaAdo::getCorreoyWeb($_GET['idDni']);

        if (is_array($arrayCorreoyWeb)) {
            echo json_encode(array(
                "estado" => 1,
                "data" => $arrayCorreoyWeb,
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $arrayCorreoyWeb
            ));
        }
    } else if ($_GET["type"] === 'getaddcolegiatura') {
        $arrayAddColegiatura = PersonaAdo::getaddcolegiatura();

        if (is_array($arrayAddColegiatura)) {
            echo json_encode(array(
                "estado" => 1,
                "sedes" => $arrayAddColegiatura[0],
                "espacialidades" => $arrayAddColegiatura[1],
                "universidades" => $arrayAddColegiatura[2],
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $arrayAddColegiatura
            ));
        }
    } else if ($_GET["type"] === 'getadddomicilio') {
        $arrayAddDomicilio = PersonaAdo::getAddDomicilio();

        if (is_array($arrayAddDomicilio)) {
            echo json_encode(array(
                "estado" => 1,
                "tipodomicilio" => $arrayAddDomicilio[0],
                "ubicacion" => $arrayAddDomicilio[1],
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $arrayAddDomicilio
            ));
        }
    } else if ($_GET["type"] === 'getaddcelular') {
        $arrayaddcelular = PersonaAdo::getAddCelular();

        if (is_array($arrayaddcelular)) {
            echo json_encode(array(
                "estado" => 1,
                "tipo" => $arrayaddcelular,
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $arrayaddcelular
            ));
        }
    } else if ($_GET["type"] === 'getaddestudios') {
        $arrayEstudios = PersonaAdo::getAddEstudios();

        if (is_array($arrayEstudios)) {
            echo json_encode(array(
                "estado" => 1,
                "grados" => $arrayEstudios[0],
                "universidades" => $arrayEstudios[1],
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $arrayEstudios
            ));
        }
    } else if ($_GET["type"] === 'getaddcorreo') {
        $arrayCorreos = PersonaAdo::getCorreo();

        if (is_array($arrayCorreos)) {
            echo json_encode(array(
                "estado" => 1,
                "correos" => $arrayCorreos,
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $arrayCorreos
            ));
        }
    } else if ($_GET["type"] === 'getpicture') {
        $arrayPicture = PersonaAdo::getPicture($_GET['idDni']);

        if (is_array($arrayPicture)) {
            echo json_encode(array(
                "estado" => 1,
                "foto" => $arrayPicture,
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $arrayPicture
            ));
        }
    } else if ($_GET["type"] === 'habilidadIngeniero') {
        $search = $_GET['search'];
        $opcion = $_GET['opcion'];
        $tipoHabilidad = $_GET['tipoHabilidad'];
        $capitulo = $_GET['capitulo'];
        $especialidad = $_GET['especialidad'];
        $posicionPagina = $_GET['posicionPagina'];
        $filasPorPagina = $_GET['filasPorPagina'];
        $habilidad = PersonaAdo::getHabilidadIngeniero($opcion, $search, intval($tipoHabilidad), intval($capitulo), intval($especialidad), intval($posicionPagina), intval($filasPorPagina));
        if (is_array($habilidad)) {
            echo json_encode(array(
                "estado" => 1,
                "habilidad" => $habilidad[0],
                "total" => $habilidad[1]
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $habilidad
            ));
        }
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST["type"] == "create") {
        $persona["dni"] = $_POST["dni"];
        $persona["num_duc"] = $_POST["num_duc"];
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
        if ($result == "create") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se insertarron correctamente los datos"
            ));
        } else if ($result == "num_duc") {
            echo json_encode(array(
                "estado" => 2,
                "message" => "El número de dni ya se encuentra registrado."
            ));
        } else if ($result == "cip") {
            echo json_encode(array(
                "estado" => 3,
                "message" => "El número de cip ya se encuentra registrado."
            ));
        } else {
            echo json_encode(array(
                "estado" => 0,
                "message" => $result
            ));
        }
    } else if ($_POST["type"] == "insertColegiatura") {
        $colegiatura["dni"] = $_POST["dni"];
        $colegiatura["sede"] = $_POST["sede"];
        $colegiatura["especialidad"] = $_POST["especialidad"];
        $colegiatura["fechacolegiacion"] = $_POST["fechacolegiacion"];
        $colegiatura["universidadegreso"] = $_POST["universidadegreso"];
        $colegiatura["fechaegreso"] = $_POST["fechaegreso"];
        $colegiatura["universidadtitulacion"] = $_POST["universidadtitulacion"];
        $colegiatura["fechatitulo"] = $_POST["fechatitulo"];
        $colegiatura["resolucion"] = $_POST["resolucion"];

        $result = PersonaAdo::insertColegiatura($colegiatura);

        if ($result == "Insertado") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se insertaron correctamente los datos"
            ));
        } else if ($result == "Duplicado") {
            echo json_encode(array(
                "estado" => 3,
                "message" => "La colegiatura con resolución " . $colegiatura["resolucion"] . " ya se encuentra registrada"
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $result
            ));
        }
    } else if ($_POST["type"] == "insertDomicilio") {
        $domicilio["dni"] = $_POST["dni"];
        $domicilio["tipo"] = $_POST["tipo"];
        $domicilio["departamento"] = $_POST["departamento"];
        $domicilio["direccion"] = $_POST["direccion"];

        $result = PersonaAdo::insertDomicilio($domicilio);

        if ($result == "Insertado") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se insertaron correctamente los datos"
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $result
            ));
        }
    } else if ($_POST["type"] == "insertCelular") {
        $celular["dni"] = $_POST["dni"];
        $celular["tipo"] = $_POST["tipo"];
        $celular["numero"] = $_POST["numero"];

        $result = PersonaAdo::insertCelular($celular);

        if ($result == "Insertado") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se insertaron correctamente los datos"
            ));
        } else if ($result == "Duplicado") {
            echo json_encode(array(
                "estado" => 3,
                "message" => "el telefono/celular " . $celular["numero"] . " ya se encuentra registrado."
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $result
            ));
        }
    } else if ($_POST["type"] == "insertConyuge") {
        $conyuge["dni"] = $_POST["dni"];
        $conyuge["conyuge"] = $_POST["conyuge"];
        $conyuge["hijos"] = $_POST["hijos"];

        $result = PersonaAdo::insertConyuge($conyuge);

        if ($result == "Insertado") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se insertaron correctamente los datos"
            ));
        } else if ($result == "Duplicado") {
            echo json_encode(array(
                "estado" => 3,
                "message" => "el conyuge " . $conyuge["conyuge"] . " ya se encuentra registrado."
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $result
            ));
        }
    } else if ($_POST["type"] == "insertExperiencia") {
        $experiencia["dni"] = $_POST["dni"];
        $experiencia["entidad"] = $_POST["entidad"];
        $experiencia["experiencia"] = $_POST["experiencia"];
        $experiencia["fechaInicio"] = $_POST["fechaInicio"];
        $experiencia["fechaFin"] = $_POST["fechaFin"];

        $result = PersonaAdo::insertExperiencia($experiencia);

        if ($result == "Insertado") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se insertaron correctamente los datos"
            ));
        } else if ($result == "Duplicado") {
            echo json_encode(array(
                "estado" => 3,
                "message" => "experiencia " . $experiencia["experiencia"] . " ya se encuentra registrado."
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $result
            ));
        }
    } else if ($_POST["type"] == "insertEstudios") {
        $estudios["dni"] = $_POST["dni"];
        $estudios["grado"] = $_POST["grado"];
        $estudios["materia"] = $_POST["materia"];
        $estudios["universidad"] = $_POST["universidad"];
        $estudios["fechaEstudios"] = $_POST["fechaEstudios"];

        $result = PersonaAdo::insertEstudios($estudios);

        if ($result == "Insertado") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se insertaron correctamente los datos"
            ));
        } else if ($result == "Duplicado") {
            echo json_encode(array(
                "estado" => 3,
                "message" => "Ya existe una materia " . $estudios["materia"] . " en una misma universidad y con el mismo grado"
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $result
            ));
        }
    } else if ($_POST["type"] == "insertCorreo") {
        $correo["dni"] = $_POST["dni"];
        $correo["tipo"] = $_POST["tipo"];
        $correo["correo"] = $_POST["correo"];

        $result = PersonaAdo::insertCorreo($correo);

        if ($result == "Insertado") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se insertaron correctamente los datos"
            ));
        } else if ($result == "Duplicado") {
            echo json_encode(array(
                "estado" => 3,
                "message" =>  " La dirección: " . $correo["correo"] . " ya se encuentra registrado(a)"
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $result
            ));
        }
    } else if ($_POST["type"] == "update") {
        $persona["dni"] = $_POST["dni"];
        $persona["num_duc"] = $_POST["num_duc"];
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
        if ($result == "updated") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se actualizo correctamente los datos."
            ));
        } else if ($result == "noexists") {
            echo json_encode(array(
                "estado" => 2,
                "message" => "El dni no existe o fue modificado para poder actualizar los datos."
            ));
        } else if ($result == "num_duc") {
            echo json_encode(array(
                "estado" => 3,
                "message" => "El número de dni ya se encuentra registrado."
            ));
        } else if ($result == "cip") {
            echo json_encode(array(
                "estado" => 4,
                "message" => "El n° cip ya se encuentra registrado a un ingeniero."
            ));
        } else {
            echo json_encode(array(
                "estado" => 0,
                "message" => $result,
                "value" => $persona["nacimiento"]
            ));
        }
    } else if ($_POST["type"] == "updateColegiatura") {
        $colegiatura["idcolegiatura"] = $_POST["idColegiatura"];
        $colegiatura["sede"] = $_POST["sede"];
        $colegiatura["especialidad"] = $_POST["especialidad"];
        $colegiatura["fechacolegiacion"] = $_POST["fechacolegiacion"];
        $colegiatura["universidadegreso"] = $_POST["universidadegreso"];
        $colegiatura["fechaegreso"] = $_POST["fechaegreso"];
        $colegiatura["universidadtitulacion"] = $_POST["universidadtitulacion"];
        $colegiatura["fechatitulo"] = $_POST["fechatitulo"];
        $colegiatura["resolucion"] = $_POST["resolucion"];

        $result = PersonaAdo::updateColegiatura($colegiatura);

        if ($result == "Actualizado") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se actualizaron correctamente los datos"
            ));
        } else if ($result == "Duplicado") {
            echo json_encode(array(
                "estado" => 2,
                "message" => "La Colegiatura con resolucion " . $colegiatura["resolucion"] . " ya se encuentra registrado."
            ));
        } else {
            echo json_encode(array(
                "estado" => 3,
                "message" => $result
            ));
        }
    } else if ($_POST["type"] == "deleteColegiatura") {
        $colegiatura["idcolegiatura"] = $_POST["idcolegiatura"];

        $result = PersonaAdo::deleteColegiatura($colegiatura);

        if ($result == "eliminado") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se eliminaron correctamente los datos"
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $result
            ));
        }
    } else if ($_POST["type"] == "updateDomicilio") {
        $domicilio["idDireccion"] = $_POST["idDomicilio"];
        $domicilio["tipo"] = $_POST["tipo"];
        $domicilio["departamento"] = $_POST["departamento"];
        $domicilio["direccion"] = $_POST["direccion"];

        $result = PersonaAdo::updateDomicilio($domicilio);

        if ($result == "Actualizado") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se actualizaron correctamente los datos"
            ));
        } else if ($result == "Duplicado") {
            echo json_encode(array(
                "estado" => 2,
                "message" => "el domicilio " . $domicilio["direccion"] . " ya se encuentra registrado."
            ));
        } else {
            echo json_encode(array(
                "estado" => 3,
                "message" => $result
            ));
        }
    } else if ($_POST["type"] == "deleteDomicilio") {
        $domicilio["iddomicilio"] = $_POST["iddomicilio"];

        $result = PersonaAdo::deleteDomicilio($domicilio);

        if ($result == "eliminado") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se eliminaron correctamente los datos"
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $result
            ));
        }
    } else if ($_POST["type"] == "updateTelefono") {
        $telefono["idTelefono"] = $_POST["idTelefono"];
        $telefono["tipo"] = $_POST["tipo"];
        $telefono["numero"] = $_POST["numero"];

        $result = PersonaAdo::updateTelefono($telefono);

        if ($result == "Actualizado") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se actualizaron correctamente los datos"
            ));
        } else if ($result == "Duplicado") {
            echo json_encode(array(
                "estado" => 2,
                "message" => "el telefono/celular " . $telefono["numero"] . " ya se encuentra registrado."
            ));
        } else {
            echo json_encode(array(
                "estado" => 3,
                "message" => $result
            ));
        }
    } else if ($_POST["type"] == "deleteTelefono") {
        $telefono["idtelefono"] = $_POST["idtelefono"];

        $result = PersonaAdo::deleteTelefono($telefono);

        if ($result == "eliminado") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se eliminaron correctamente los datos"
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $result
            ));
        }
    } else if ($_POST["type"] == "updateConyuge") {
        $conyuge["idConyuge"] = $_POST["idConyuge"];
        $conyuge["Conyuge"] = $_POST["Conyuge"];
        $conyuge["hijos"] = $_POST["Hijos"];

        $result = PersonaAdo::updateConyuge($conyuge);

        if ($result == "Actualizado") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se actualizaron correctamente los datos"
            ));
        } else if ($result == "Duplicado") {
            echo json_encode(array(
                "estado" => 2,
                "message" => "el(la) conyuge " . $conyuge["Conyuge"] . " ya se encuentra registrado."
            ));
        } else {
            echo json_encode(array(
                "estado" => 3,
                "message" => $result
            ));
        }
    } else if ($_POST["type"] == "deleteConyuge") {
        $conyuge["idconyuge"] = $_POST["idconyuge"];

        $result = PersonaAdo::deleteConyuge($conyuge);

        if ($result == "eliminado") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se eliminaron correctamente los datos"
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $result
            ));
        }
    } else if ($_POST["type"] == "updateExperiencia") {
        $experiencia["idexperiencia"] = $_POST["idExperiencia"];
        $experiencia["entidad"] = $_POST["Entidad"];
        $experiencia["experiencia"] = $_POST["Experiencia"];
        $experiencia["inicio"] = $_POST["Inicio"];
        $experiencia["fin"] = $_POST["Fin"];

        $result = PersonaAdo::updateExperiencia($experiencia);

        if ($result == "Actualizado") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se actualizaron correctamente los datos"
            ));
        } else if ($result == "Duplicado") {
            echo json_encode(array(
                "estado" => 2,
                "message" => "La experiencia " . $experiencia["experiencia"] . " en" . $experiencia["entidad"] . " ya se encuentra registrado."
            ));
        } else {
            echo json_encode(array(
                "estado" => 3,
                "message" => $result
            ));
        }
    } else if ($_POST["type"] == "deleteleIngeniero") {
        $result = PersonaAdo::deleteIngeniero($_POST["IdDni"]);
        if ($result == "eliminado") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se eliminaron correctamente los datos"
            ));
        } else if ($result == "Ingresos") {
            echo json_encode(array(
                "estado" => 2,
                "message" => "No se puede eliminar el ingeniero, porque tiene asociados ingresos."
            ));
        } else {
            echo json_encode(array(
                "estado" => 0,
                "message" => $result
            ));
        }
    } else if ($_POST["type"] == "deleteExperiencia") {
        $result = PersonaAdo::deleteExperiencia($_POST["idExperiencia"]);
        if ($result == "eliminado") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se eliminaron correctamente los datos"
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $result
            ));
        }
    } else if ($_POST["type"] == "updateEstudios") {
        $estudios["IdEstudio"] = $_POST["idEstudios"];
        $estudios["Grado"] = $_POST["grado"];
        $estudios["Materia"] = $_POST["materia"];
        $estudios["Universidad"] = $_POST["universidad"];
        $estudios["Fecha"] = $_POST["fecha"];

        $result = PersonaAdo::updateEstudios($estudios);

        if ($result == "Actualizado") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se actualizaron correctamente los datos"
            ));
        } else if ($result == "Duplicado") {
            echo json_encode(array(
                "estado" => 2,
                "message" => "Ya existe una materia " . $estudios["Materia"] . " en una misma universidad y con el mismo grado"
            ));
        } else {
            echo json_encode(array(
                "estado" => 3,
                "message" => $result
            ));
        }
    } else if ($_POST["type"] == "deleteEstudio") {
        $estudio["idestudio"] = $_POST["idestudio"];

        $result = PersonaAdo::deleteEstudio($estudio);

        if ($result == "eliminado") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se eliminaron correctamente los datos"
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $result
            ));
        }
    } else if ($_POST["type"] == "updateCorreo") {
        $correo["IdCorreo"] = $_POST["idCorreo"];
        $correo["Tipo"] = $_POST["tipo"];
        $correo["Direccion"] = $_POST["direccion"];

        $result = PersonaAdo::updateCorreo($correo);

        if ($result == "Actualizado") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se actualizaron correctamente los datos"
            ));
        } else if ($result == "Duplicado") {
            echo json_encode(array(
                "estado" => 2,
                "message" => "La direccion: " .  $correo["Direccion"] . " ya se encuentra registrada"
            ));
        } else {
            echo json_encode(array(
                "estado" => 3,
                "message" => $result
            ));
        }
    } else if ($_POST["type"] == "deleteCorreo") {
        $correo["IdCorreo"] = $_POST["idCorreo"];

        $result = PersonaAdo::deleteCorreo($correo);

        if ($result == "eliminado") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se eliminaron correctamente los datos"
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $result
            ));
        }
    }
}
