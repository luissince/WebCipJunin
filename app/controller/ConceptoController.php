<?php

date_default_timezone_set('America/Lima');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');
require '../model/ConceptoAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if ($_GET["type"] === "alldata") {
        $opcion = $_GET["opcion"];
        $categoria = $_GET["categoria"];
        $nombres = $_GET['nombres'];
        $posicionPagina = $_GET['posicionPagina'];
        $filasPorPagina = $_GET['filasPorPagina'];
        $conceptos = ConceptoAdo::getAll($opcion, $categoria, $nombres, intval($posicionPagina), intval($filasPorPagina));
        if (is_array($conceptos)) {
            echo json_encode(array(
                "estado" => 1,
                "conceptos" => $conceptos[0],
                "total" => $conceptos[1]
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $conceptos
            ));
        }
    } else if ($_GET["type"] === "data") {
        $concepto = ConceptoAdo::getId($_GET["idConcepto"]);
        if (is_object($concepto)) {
            echo json_encode(array(
                "estado" => 1,
                "object" => $concepto
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $concepto
            ));
        }
    } else if ($_GET["type"] === "typecolegiatura") {
        if (intval($_GET["categoria"]) === 1) {
            $result = ConceptoAdo::getCuotas($_GET["dni"], intval($_GET["categoria"]), intval($_GET["mes"]));
            if (is_array($result)) {
                echo json_encode(array(
                    "estado" => 1,
                    "data" => $result
                ));
            } else {
                echo json_encode(array(
                    "estado" => 0,
                    "message" => $result
                ));
            }
        } else if (intval($_GET["categoria"]) === 2) {
            $result = ConceptoAdo::getCuotas($_GET["dni"], intval($_GET["categoria"]), intval($_GET["mes"]));
            if (is_array($result)) {
                echo json_encode(array(
                    "estado" => 1,
                    "data" => $result
                ));
            } else {
                echo json_encode(array(
                    "estado" => 0,
                    "message" => $result
                ));
            }
        } else if (intval($_GET["categoria"]) === 3) {
            $result = ConceptoAdo::getCuotas($_GET["dni"], intval($_GET["categoria"]), intval($_GET["mes"]));
            if (is_array($result)) {
                echo json_encode(array(
                    "estado" => 1,
                    "data" => $result
                ));
            } else {
                echo json_encode(array(
                    "estado" => 0,
                    "message" => $result
                ));
            }
        } else if (intval($_GET["categoria"]) === 4) {
            $result = ConceptoAdo::getColegiatura();
            if (is_array($result)) {
                echo json_encode(array(
                    "estado" => 1,
                    "data" => $result
                ));
            } else {
                echo json_encode(array(
                    "estado" => 0,
                    "message" => $result
                ));
            }
        } else if (intval($_GET["categoria"]) === 5) {
            $result = ConceptoAdo::getCertificadoHabilidad($_GET['Dni']);
            if (is_array($result)) {
                echo json_encode(array(
                    "estado" => 1,
                    "data" => $result[0],
                    "especialidades" => $result[1],
                    "ultimopago" => $result[2],
                    "numeracion" => $result[3],
                ));
            } else {
                echo json_encode(array(
                    "estado" => 0,
                    "message" => $result
                ));
            }
        } else if (intval($_GET["categoria"]) === 6) {
            $result = ConceptoAdo::getCertificadoHabilidadObraPublica($_GET['Dni']);
            if (is_array($result)) {
                echo json_encode(array(
                    "estado" => 1,
                    "data" => $result[0],
                    "especialidades" => $result[1],
                    "ultimopago" => $result[2],
                    "ubigeo" => $result[3],
                    "numeracion" => $result[4],
                ));
            } else {
                echo json_encode(array(
                    "estado" => 0,
                    "message" => $result
                ));
            }
        } else if (intval($_GET["categoria"]) === 7) {
            $result = ConceptoAdo::getCertificadoHabilidadProyecto($_GET['Dni']);
            if (is_array($result)) {
                echo json_encode(array(
                    "estado" => 1,
                    "data" => $result[0],
                    "especialidades" => $result[1],
                    "ultimopago" => $result[2],
                    "ubigeo" => $result[3],
                    "numeracion" => $result[4],
                ));
            } else {
                echo json_encode(array(
                    "estado" => 0,
                    "message" => $result
                ));
            }
        } else if (intval($_GET["categoria"]) === 8) {
            $result = ConceptoAdo::getPeritaje();
            if (is_object($result)) {
                echo json_encode(array(
                    "estado" => 1,
                    "data" => $result
                ));
            } else {
                echo json_encode(array(
                    "estado" => 0,
                    "message" => $result
                ));
            }
        } else if (intval($_GET["categoria"]) === 100) {
            $result = ConceptoAdo::getOtrosConceptos();
            if (is_array($result)) {
                echo json_encode(array(
                    "estado" => 1,
                    "data" => $result
                ));
            } else {
                echo json_encode(array(
                    "estado" => 0,
                    "message" => $result
                ));
            }
        }
    } else if ($_GET["type"] === "getubigeo") {
        $arrayUbigeo = ConceptoAdo::getUbigeo();

        if (is_array($arrayUbigeo)) {
            echo json_encode(array(
                "estado" => 1,
                "ubicacion" => $arrayUbigeo,
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $arrayUbigeo
            ));
        }
    } else if ($_GET["type"] === "numCertHabilidad") {
        $validate = ConceptoAdo::validateCertNum($_GET["numero"]);
        if ($validate) {
            echo json_encode(array(
                "estado" => $validate
            ));
        } else {
            echo json_encode(array(
                "estado" => $validate
            ));
        }
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST["type"] === "create") {
        $data["Categoria"] = $_POST["Categoria"];
        $data["Concepto"] = $_POST["Concepto"];
        $data["Precio"] = $_POST["Precio"];
        $data["Propiedad"] = $_POST["Propiedad"];
        $data["Inicio"] = $_POST["Inicio"];
        $data["Fin"] = $_POST["Fin"];
        $data["Asignado"] = $_POST["Asignado"];
        $data["Observacion"] = $_POST["Observacion"];
        $data["Codigo"] = $_POST["Codigo"];
        $data["Estado"] = $_POST["Estado"];
        $result = ConceptoAdo::insert($data);
        if ($result == "inserted") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se registró correctamente el concepto."
            ));
        } else {
            echo json_encode(array(
                "estado" => 0,
                "message" => $result
            ));
        }
    } else if ($_POST["type"] === "update") {
        $data["IdConcepto"] = $_POST["IdConcepto"];
        $data["Categoria"] = $_POST["Categoria"];
        $data["Concepto"] = $_POST["Concepto"];
        $data["Precio"] = $_POST["Precio"];
        $data["Propiedad"] = $_POST["Propiedad"];
        $data["Inicio"] = $_POST["Inicio"];
        $data["Fin"] = $_POST["Fin"];
        $data["Observacion"] = $_POST["Observacion"];
        $data["Codigo"] = $_POST["Codigo"];
        $data["Estado"] = $_POST["Estado"];
        $data["Asignado"] = $_POST["Asignado"];
        $result = ConceptoAdo::update($data);
        if ($result == "updated") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se actualizó correctamente el concepto."
            ));
        } else {
            echo json_encode(array(
                "estado" => 0,
                "message" => $result,
                "result" => $data
            ));
        }
    } else if ($_POST["type"] === "deleteConcepto") {
        $concepto["idConcepto"] = $_POST["idconcepto"];
        $result = ConceptoAdo::deleteConcepto($concepto);

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
