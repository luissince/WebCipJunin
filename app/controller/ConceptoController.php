<?php

date_default_timezone_set('America/Lima');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');
require '../model/ConceptoAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if ($_GET["type"] === "alldata") {
        $opcion = $_GET['opcion'];
        $nombres = $_GET['nombres'];
        $categoria = $_GET['categoria'];
        $posicionPagina = $_GET['posicionPagina'];
        $filasPorPagina = $_GET['filasPorPagina'];
        $conceptos = ConceptoAdo::getAll(intval($opcion), $nombres, intval($categoria), intval($posicionPagina), intval($filasPorPagina));
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
        $result = ConceptoAdo::getId($_GET["idConcepto"]);
        if (is_array($result)) {
            echo json_encode(array(
                "estado" => 1,
                "object" => $result[0],
                "impuestos" => $result[1]
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $result
            ));
        }
    } else if ($_GET["type"] === "typecolegiatura") {
        if (intval($_GET["categoria"]) === 1) {
            $result = ConceptoAdo::getCuotas($_GET["dni"], intval($_GET["categoria"]), intval($_GET["mes"]), $_GET["yearv"], $_GET["monthv"]);
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
            $result = ConceptoAdo::getCuotas($_GET["dni"], intval($_GET["categoria"]), intval($_GET["mes"]), $_GET["yearv"], $_GET["monthv"]);
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
            $result = ConceptoAdo::getCuotas($_GET["dni"], intval($_GET["categoria"]), intval($_GET["mes"]), $_GET["yearv"], $_GET["monthv"]);
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
        } else if (intval($_GET["categoria"]) === 12) {
            $result = ConceptoAdo::getCuotas($_GET["dni"], intval($_GET["categoria"]), intval($_GET["mes"]), $_GET["yearv"], $_GET["monthv"]);
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
        } else if (intval($_GET["categoria"]) === 4 || intval($_GET["categoria"]) === 9 || intval($_GET["categoria"]) === 10 || intval($_GET["categoria"]) === 11) {
            $result = ConceptoAdo::getColegiatura($_GET["categoria"]);
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
    } else if ($_GET["type"] === "certHabilidad") {
        $result = ConceptoAdo::getCertHabilidad($_GET['idIngreso']);
        if (is_array($result)) {
            echo json_encode(array(
                "estado" => 1,
                "data" => $result[0],
                "especialidades" => $result[1]
            ));
        } else {
            echo json_encode(array(
                "estado" => 0,
                "message" => $result
            ));
        }
    } else if ($_GET["type"] === "certObra") {
        $result = ConceptoAdo::getCertObra($_GET['idIngreso']);
        if (is_array($result)) {
            echo json_encode(array(
                "estado" => 1,
                "data" => $result[0],
                "especialidades" => $result[1],
                "ubigeo" => $result[2]
            ));
        } else {
            echo json_encode(array(
                "estado" => 0,
                "message" => $result
            ));
        }
    } else if ($_GET["type"] === "certProyecto") {
        $result = ConceptoAdo::getCertProyecto($_GET['idIngreso']);
        if (is_array($result)) {
            echo json_encode(array(
                "estado" => 1,
                "data" => $result[0],
                "especialidades" => $result[1],
                "ubigeo" => $result[2]
            ));
        } else {
            echo json_encode(array(
                "estado" => 0,
                "message" => $result
            ));
        }
    } else if ($_GET["type"] === "allCorrelativoCert") {
        $result = ConceptoAdo::getAllCorrelativoCert();
        if (is_array($result)) {
            echo json_encode(array(
                "estado" => 1,
                "data" => $result,
            ));
        } else {
            echo json_encode(array(
                "estado" => 0,
                "message" => $result
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
        $data["Impuesto"] = $_POST["Impuesto"];
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
        $data["Impuesto"] = $_POST["Impuesto"];
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
                "message" => "Se eliminó correctamente el concepto."
            ));
        } else  if ($result == "use") {
            echo json_encode(array(
                "estado" => 2,
                "message" => "No se puede elimar el concepto porque esta ligado a un ingreso."
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $result
            ));
        }
    } else if ($_POST["type"] == "certHabilidad") {
        $data["idCertHabilidad"] = $_POST["idCertificado"];
        $data["numerico"] = $_POST["numerico"];
        $data["especialidad"] = $_POST["especialidad"];
        $data["asunto"] = $_POST["asunto"];
        $data["entidad"] = $_POST["entidad"];
        $data["lugar"] = $_POST["lugar"];
        $data["fecha"] = $_POST["fecha"];

        $result = ConceptoAdo::updateCertHabilidad($data);

        if ($result == "updated") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "El certificado ha sido actualizado correctamente."
            ));
        } else {
            echo json_encode(array(
                "estado" => 0,
                "message" => $result
            ));
        }
    } else if ($_POST["type"] == "certObra") {
        $data["idCertObra"] = $_POST["idCertificado"];
        $data["especialidad"] = $_POST["especialidad"];
        $data["modalidad"] = $_POST["modalidad"];
        $data["proyecto"] = $_POST["proyecto"];
        $data["propietario"] = $_POST["propietario"];
        $data["ubigeo"] = $_POST["ubigeo"];

        $result = ConceptoAdo::updateCertObra($data);

        if ($result == "updated") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "El certificado ha sido actualizado correctamente."
            ));
        } else {
            echo json_encode(array(
                "estado" => 0,
                "message" => $result
            ));
        }
    } else if ($_POST["type"] == "certProyecto") {
        $data["idCertProyecto"] = $_POST["idCertificado"];
        $data["especialidad"] = $_POST["especialidad"];
        $data["modalidad"] = $_POST["modalidad"];
        $data["proyecto"] = $_POST["proyecto"];
        $data["propietario"] = $_POST["propietario"];
        $data["ubigeo"] = $_POST["ubigeo"];
        $data["adicional1"] = $_POST["adicional1"];
        $data["adicional2"] = $_POST["adicional2"];

        $result = ConceptoAdo::updateCertProyecto($data);

        if ($result == "updated") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "El certificado ha sido actualizado correctamente."
            ));
        } else {
            echo json_encode(array(
                "estado" => 0,
                "message" => $result
            ));
        }
    } else if ($_POST["type"] == "correlativoCertCrud") {
        $result = ConceptoAdo::updateResetCorrelativo($_POST["tipo"], $_POST["numeracion"]);
        if ($result == "updated") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se actualizó correctamente el correlativo."
            ));
        } else {
            echo json_encode(array(
                "estado" => 0,
                "message" => $result
            ));
        }
    }
}
