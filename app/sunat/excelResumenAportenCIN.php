<?php

ini_set('max_execution_time', '300');
ini_set("pcre.backtrack_limit", "10000000");
ini_set('memory_limit', '-1');

require __DIR__ . "/lib/phpspreadsheet/vendor/autoload.php";
include_once('../model/IngresosAdo.php');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

$fechaIngreso = "RESUMEN DE APORTACIONES AL CIP NACIONAL DE LA FECHA: " . date("d-m-Y", strtotime($_GET["fechaInicial"])) . " al " . date("d-m-Y", strtotime($_GET["fechaFinal"]));

$totalISSCIP = 0;
$totalSOCIALCIP = 0;

$data['FechaInicial'] = $_GET['fechaInicial'];
$data['FechaFinal'] = $_GET['fechaFinal'];
$data['Colegiado'] = $_GET['colegiado'];
$data['Opcion'] = $_GET['tipo'];

$resumen = IngresosAdo::ResumenAporteCIN($data);

if (!is_array($resumen)) {
    echo $resumen;
} else {

    $arrayresumen = array();

    foreach ($resumen as $value) {
        $fechaIni = new DateTime($value["FechaIni"]);
        $fechaFin = new DateTime($value["FechaFin"]);

        while ($fechaIni <= $fechaFin) {
            array_push($arrayresumen, array(
                "CIP" => $value["CIP"],
                "idIngreso" => $value["idIngreso"],
                "idDNI" => $value["idDNI"],
                "Condicion" => $value["Condicion"],
                "Ingeniero" => $value["Ingeniero"],
                "Especialidad" => $value["Especialidad"],
                "Capitulo" => $value["Capitulo"],
                "Year" => $fechaIni->format("Y"),

                "Concepto1" => $value["Concepto1"],
                "Monto1" => floatval($value["Monto1"]),
                "EneroX" => $fechaIni->format("m") == 1 ? floatval($value["Monto1"]) : 0,
                "FebreroX" => $fechaIni->format("m") == 2 ? floatval($value["Monto1"]) : 0,
                "MarzoX" => $fechaIni->format("m") == 3 ? floatval($value["Monto1"]) : 0,
                "AbrilX" => $fechaIni->format("m") == 4 ? floatval($value["Monto1"]) : 0,
                "MayoX" => $fechaIni->format("m") == 5 ? floatval($value["Monto1"]) : 0,
                "JunioX" => $fechaIni->format("m") == 6 ? floatval($value["Monto1"]) : 0,
                "JulioX" => $fechaIni->format("m") == 7 ? floatval($value["Monto1"]) : 0,
                "AgostoX" => $fechaIni->format("m") == 8 ? floatval($value["Monto1"]) : 0,
                "SetiembreX" => $fechaIni->format("m") == 9 ? floatval($value["Monto1"]) : 0,
                "OctubreX" => $fechaIni->format("m") == 10 ? floatval($value["Monto1"]) : 0,
                "NoviembreX" => $fechaIni->format("m") == 11 ? floatval($value["Monto1"]) : 0,
                "DiciembreX" => $fechaIni->format("m") == 12 ? floatval($value["Monto1"]) : 0,
                "SumaConcepto1" => floatval($value["Monto1"]),

                "Concepto2" => $value["Concepto2"],
                "Monto2" => floatval($value["Monto2"]),
                "EneroY" => $fechaIni->format("m") == 1 ? floatval($value["Monto2"]) : 0,
                "FebreroY" => $fechaIni->format("m") == 2 ? floatval($value["Monto2"]) : 0,
                "MarzoY" => $fechaIni->format("m") == 3 ? floatval($value["Monto2"]) : 0,
                "AbrilY" => $fechaIni->format("m") == 4 ? floatval($value["Monto2"]) : 0,
                "MayoY" => $fechaIni->format("m") == 5 ? floatval($value["Monto2"]) : 0,
                "JunioY" => $fechaIni->format("m") == 6 ? floatval($value["Monto2"]) : 0,
                "JulioY" => $fechaIni->format("m") == 7 ? floatval($value["Monto2"]) : 0,
                "AgostoY" => $fechaIni->format("m") == 8 ? floatval($value["Monto2"]) : 0,
                "SetiembreY" => $fechaIni->format("m") == 9 ? floatval($value["Monto2"]) : 0,
                "OctubreY" => $fechaIni->format("m") == 10 ? floatval($value["Monto2"]) : 0,
                "NoviembreY" => $fechaIni->format("m") == 11 ? floatval($value["Monto2"]) : 0,
                "DiciembreY" => $fechaIni->format("m") == 12 ? floatval($value["Monto2"]) : 0,
                "SumaConcepto2" => floatval($value["Monto2"]),

            ));
            $fechaIni->modify('+ 1 month');
        }
    }

    $arraynuevo = array();


    foreach ($arrayresumen as $value) {
        if (IngresosAdo::isValidate($arraynuevo, $value)) {
            for ($i = 0; $i < count($arraynuevo); $i++) {
                if ($arraynuevo[$i]["idDNI"] == $value["idDNI"] && $arraynuevo[$i]["Year"] == $value["Year"]) {
                    $arraynuevo[$i] = array(
                        "CIP" => $value["CIP"],
                        "idIngreso" => $value["idIngreso"],
                        "idDNI" => $value["idDNI"],
                        "Condicion" => $value["Condicion"],
                        "Ingeniero" => $value["Ingeniero"],
                        "Especialidad" => $value["Especialidad"],
                        "Capitulo" => $value["Capitulo"],
                        "Year" => $value["Year"],

                        "Concepto1" => $value["Concepto1"],
                        "Monto1" => $value["Monto1"] == 0 ? $arraynuevo[$i]["Monto1"] : $value["Monto1"],
                        "EneroX" =>  $value["EneroX"] == 0 ? $arraynuevo[$i]["EneroX"] : $value["EneroX"],
                        "FebreroX" =>  $value["FebreroX"] == 0 ? $arraynuevo[$i]["FebreroX"] : $value["FebreroX"],
                        "MarzoX" =>  $value["MarzoX"] == 0 ? $arraynuevo[$i]["MarzoX"] : $value["MarzoX"],
                        "AbrilX" =>  $value["AbrilX"] == 0 ? $arraynuevo[$i]["AbrilX"] : $value["AbrilX"],
                        "MayoX" =>  $value["MayoX"] == 0 ? $arraynuevo[$i]["MayoX"] : $value["MayoX"],
                        "JunioX" =>  $value["JunioX"] == 0 ? $arraynuevo[$i]["JunioX"] : $value["JunioX"],
                        "JulioX" =>  $value["JulioX"] == 0 ? $arraynuevo[$i]["JulioX"] : $value["JulioX"],
                        "AgostoX" =>  $value["AgostoX"] == 0 ? $arraynuevo[$i]["AgostoX"] : $value["AgostoX"],
                        "SetiembreX" =>  $value["SetiembreX"] == 0 ? $arraynuevo[$i]["SetiembreX"] : $value["SetiembreX"],
                        "OctubreX" => $value["OctubreX"] == 0 ? $arraynuevo[$i]["OctubreX"] : $value["OctubreX"],
                        "NoviembreX" => $value["NoviembreX"] == 0 ? $arraynuevo[$i]["NoviembreX"] : $value["NoviembreX"],
                        "DiciembreX" => $value["DiciembreX"] == 0 ? $arraynuevo[$i]["DiciembreX"] : $value["DiciembreX"],
                        "SumaConcepto1" => $arraynuevo[$i]["SumaConcepto1"] + $value["SumaConcepto1"],

                        "Concepto2" => $value["Concepto2"],
                        "Monto2" => $value["Monto2"] == 0 ? $arraynuevo[$i]["Monto2"]  : $value["Monto2"],
                        "EneroY" => $value["EneroY"] == 0 ? $arraynuevo[$i]["EneroY"] : $value["EneroY"],
                        "FebreroY" => $value["FebreroY"] == 0 ? $arraynuevo[$i]["FebreroY"] : $value["FebreroY"],
                        "MarzoY" => $value["MarzoY"] == 0 ? $arraynuevo[$i]["MarzoY"] : $value["MarzoY"],
                        "AbrilY" => $value["AbrilY"] == 0 ? $arraynuevo[$i]["AbrilY"] : $value["AbrilY"],
                        "MayoY" => $value["MayoY"] == 0 ? $arraynuevo[$i]["MayoY"] : $value["MayoY"],
                        "JunioY" => $value["JunioY"] == 0 ? $arraynuevo[$i]["JunioY"] : $value["JunioY"],
                        "JulioY" => $value["JulioY"] == 0 ? $arraynuevo[$i]["JulioY"] : $value["JulioY"],
                        "AgostoY" => $value["AgostoY"] == 0 ? $arraynuevo[$i]["AgostoY"] : $value["AgostoY"],
                        "SetiembreY" => $value["SetiembreY"] == 0 ? $arraynuevo[$i]["SetiembreY"] : $value["SetiembreY"],
                        "OctubreY" => $value["OctubreY"] == 0 ? $arraynuevo[$i]["OctubreY"] : $value["OctubreY"],
                        "NoviembreY" => $value["NoviembreY"] == 0 ? $arraynuevo[$i]["NoviembreY"] : $value["NoviembreY"],
                        "DiciembreY" => $value["DiciembreY"] == 0 ? $arraynuevo[$i]["DiciembreY"] : $value["DiciembreY"],
                        "SumaConcepto2" => $arraynuevo[$i]["SumaConcepto2"] + $value["SumaConcepto2"],
                    );
                    break;
                }
            }
        } else {
            array_push($arraynuevo, $value);
        }
    }

    $documento = new Spreadsheet();
    $documento
        ->getProperties()
        ->setCreator("Creado por SysSoftIntegra")
        ->setTitle('Resumen de Aportaciones al CIP Nacional')
        ->setSubject('Reporte')
        ->setDescription('Resumen de Aportaciones al CIP Nacional')
        ->setKeywords('Reporte de Aportaciones')
        ->setCategory('Aportaciones');

    $documento->getActiveSheet()->setTitle("Aportaciones");

    $documento->getActiveSheet()->getStyle('A1:AG1')->applyFromArray(array(
        'borders' => array(
            'outline' => array(
                'borderStyle' => Border::BORDER_THIN,
                'color' => array('argb' => '000000'),
            ),
        ),
        'fill' => array(
            'fillType' => Fill::FILL_SOLID,
            'startColor' => array('argb' => '006ac1')
        ),
        'font'  => array(
            'bold'  =>  true,
            'color' => array('argb' => 'ffffff')
        ),
        'alignment' => array(
            'horizontal' => Alignment::HORIZONTAL_CENTER
        )
    ));
    $documento->setActiveSheetIndex(0)->mergeCells('A1:AG1');
    $documento->setActiveSheetIndex(0)->setCellValue("A1", $fechaIngreso);

    $documento->setActiveSheetIndex(0)->mergeCells('A2:A3');
    $documento->setActiveSheetIndex(0)->mergeCells('B2:B3');
    $documento->setActiveSheetIndex(0)->mergeCells('C2:C3');
    $documento->setActiveSheetIndex(0)->mergeCells('D2:D3');
    $documento->setActiveSheetIndex(0)->mergeCells('E2:E3');
    $documento->setActiveSheetIndex(0)->mergeCells('F2:F3');
    $documento->setActiveSheetIndex(0)->mergeCells('G2:S2');
    $documento->setActiveSheetIndex(0)->mergeCells('T2:AF2');
    $documento->setActiveSheetIndex(0)->mergeCells('AG2:AG3');

    $documento->getActiveSheet()->getStyle('A2:AG3')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

    $documento->getActiveSheet()->getStyle('A2:AG3')->applyFromArray(array(
        // 'borders' => array(
        //     'outline' => array(
        //         'borderStyle' => Border::BORDER_THIN,
        //         'color' => array('argb' => '000000'),
        //     ),
        // ),
        'fill' => array(
            'fillType' => Fill::FILL_SOLID,
            'startColor' => array('rgb' => 'D6D5D5')
        ),
        'font'  => array(
            'bold'  =>  true,
            'color' => array('argb' => '000000')
        ),
        'alignment' => array(
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical' => Alignment::VERTICAL_CENTER
        )
    ));
    $documento->setActiveSheetIndex(0)
        ->setCellValue("A2", "N°")
        ->setCellValue("B2", "CAPITULO")
        ->setCellValue("C2", "N° CIP")
        ->setCellValue("D2", "CONDICION")
        ->setCellValue("E2", "INGENIERO")
        ->setCellValue("F2", "AÑO")
        ->setCellValue("G2", "CUOTAS AL ISS CIP")
        ->setCellValue("T2", "CUOTAS SOCIALES CIP")
        ->setCellValue("G3", "E")
        ->setCellValue("H3", "F")
        ->setCellValue("I3", "M")
        ->setCellValue("J3", "A")
        ->setCellValue("K3", "M")
        ->setCellValue("L3", "J")
        ->setCellValue("M3", "J")
        ->setCellValue("N3", "A")
        ->setCellValue("O3", "S")
        ->setCellValue("P3", "O")
        ->setCellValue("Q3", "N")
        ->setCellValue("R3", "D")
        ->setCellValue("S3", "S1")
        ->setCellValue("T3", "E")
        ->setCellValue("U3", "F")
        ->setCellValue("V3", "M")
        ->setCellValue("W3", "A")
        ->setCellValue("X3", "M")
        ->setCellValue("Y3", "J")
        ->setCellValue("Z3", "J")
        ->setCellValue("AA3", "A")
        ->setCellValue("AB3", "S")
        ->setCellValue("AC3", "O")
        ->setCellValue("AD3", "N")
        ->setCellValue("AE3", "D")
        ->setCellValue("AF3", "S2")
        ->setCellValue("AG2", "T.");


    $count = 0;
    $cel = 4;
    foreach ($arraynuevo as $key => $value) {

        $documento->getActiveSheet()->getStyle('A' . $cel . ':AG' . $cel)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        $documento->getActiveSheet()->getStyle('A' . $cel . ':AG' . $cel)->applyFromArray(array(
            'fill' => array(
                'type' => Fill::FILL_SOLID,
                'color' => array('rgb' => 'E5E4E2')
            ),
            'font'  => array(
                'bold'  =>  false
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_LEFT
            )
        ));
        $count++;

        switch ($value["Condicion"]) {
            case "V":
                $condicion = "VITALICIO";
                break;
            case "R":
                $condicion = "RETIRADO";
                break;
            case "F":
                $condicion = "FALLECIDO";
                break;
            case "T":
                $condicion = "TRANSEUNTE";
                break;
            default:
                $condicion = "ORDINARIO";
                break;
        }

            $documento->setActiveSheetIndex(0)
            ->setCellValue("A" . $cel, strval($count))
            ->setCellValue("B" . $cel, strval($value["Capitulo"]))
            ->setCellValue("C" . $cel, strval($value["CIP"]))
            ->setCellValue("D" . $cel, strval($condicion))
            ->setCellValue("E" . $cel, strval($value["Ingeniero"]))
            ->setCellValue("F" . $cel, strval($value["Year"]))
            ->setCellValue("G" . $cel, strval($value["EneroX"]))
            ->setCellValue("H" . $cel, strval($value["FebreroX"]))
            ->setCellValue("I" . $cel, strval($value["MarzoX"]))
            ->setCellValue("J" . $cel, strval($value["AbrilX"]))
            ->setCellValue("K" . $cel, strval($value["MayoX"]))
            ->setCellValue("L" . $cel, strval($value["JunioX"]))
            ->setCellValue("M" . $cel, strval($value["JulioX"]))
            ->setCellValue("N" . $cel, strval($value["AgostoX"]))
            ->setCellValue("O" . $cel, strval($value["SetiembreX"]))
            ->setCellValue("P" . $cel, strval($value["OctubreX"]))
            ->setCellValue("Q" . $cel, strval($value["NoviembreX"]))
            ->setCellValue("R" . $cel, strval($value["DiciembreX"]))
            ->setCellValue("S" . $cel, strval($value["SumaConcepto1"]))
            ->setCellValue("T" . $cel, strval($value["EneroY"]))
            ->setCellValue("U" . $cel, strval($value["FebreroY"]))
            ->setCellValue("V" . $cel, strval($value["MarzoY"]))
            ->setCellValue("W" . $cel, strval($value["AbrilY"]))
            ->setCellValue("X" . $cel, strval($value["MayoY"]))
            ->setCellValue("Y" . $cel, strval($value["JunioY"]))
            ->setCellValue("Z" . $cel, strval($value["JulioY"]))
            ->setCellValue("AA" . $cel, strval($value["AgostoY"]))
            ->setCellValue("AB" . $cel, strval($value["SetiembreY"]))
            ->setCellValue("AC" . $cel, strval($value["OctubreY"]))
            ->setCellValue("AD" . $cel, strval($value["NoviembreY"]))
            ->setCellValue("AE" . $cel, strval($value["DiciembreY"]))
            ->setCellValue("AF" . $cel, strval($value["SumaConcepto2"]))
            ->setCellValue("AG" . $cel, strval(($value["SumaConcepto1"] + $value["SumaConcepto2"])));

        $cel++;
    }

    //Ancho de las columnas
    $documento->getActiveSheet()->getColumnDimension('A')->setWidth(7);
    $documento->getActiveSheet()->getColumnDimension('B')->setWidth(15);
    $documento->getActiveSheet()->getColumnDimension('C')->setWidth(10);
    $documento->getActiveSheet()->getColumnDimension('D')->setWidth(15);
    $documento->getActiveSheet()->getColumnDimension('E')->setWidth(30);
    $documento->getActiveSheet()->getColumnDimension('F')->setWidth(10);
    $documento->getActiveSheet()->getColumnDimension('G')->setWidth(5);
    $documento->getActiveSheet()->getColumnDimension('H')->setWidth(5);
    $documento->getActiveSheet()->getColumnDimension('I')->setWidth(5);
    $documento->getActiveSheet()->getColumnDimension('J')->setWidth(5);
    $documento->getActiveSheet()->getColumnDimension('K')->setWidth(5);
    $documento->getActiveSheet()->getColumnDimension('L')->setWidth(5);
    $documento->getActiveSheet()->getColumnDimension('M')->setWidth(5);
    $documento->getActiveSheet()->getColumnDimension('N')->setWidth(5);
    $documento->getActiveSheet()->getColumnDimension('O')->setWidth(5);
    $documento->getActiveSheet()->getColumnDimension('P')->setWidth(5);
    $documento->getActiveSheet()->getColumnDimension('Q')->setWidth(5);
    $documento->getActiveSheet()->getColumnDimension('R')->setWidth(5);
    $documento->getActiveSheet()->getColumnDimension('S')->setWidth(5);
    $documento->getActiveSheet()->getColumnDimension('T')->setWidth(5);
    $documento->getActiveSheet()->getColumnDimension('U')->setWidth(5);
    $documento->getActiveSheet()->getColumnDimension('V')->setWidth(5);
    $documento->getActiveSheet()->getColumnDimension('W')->setWidth(5);
    $documento->getActiveSheet()->getColumnDimension('X')->setWidth(5);
    $documento->getActiveSheet()->getColumnDimension('Y')->setWidth(5);
    $documento->getActiveSheet()->getColumnDimension('Z')->setWidth(5);
    $documento->getActiveSheet()->getColumnDimension('AA')->setWidth(5);
    $documento->getActiveSheet()->getColumnDimension('AB')->setWidth(5);
    $documento->getActiveSheet()->getColumnDimension('AC')->setWidth(5);
    $documento->getActiveSheet()->getColumnDimension('AD')->setWidth(5);
    $documento->getActiveSheet()->getColumnDimension('AE')->setWidth(5);
    $documento->getActiveSheet()->getColumnDimension('AF')->setWidth(5);
    $documento->getActiveSheet()->getColumnDimension('AG')->setWidth(5);


    // Redirect output to a client’s web browser (Xlsx)
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename=' . $fechaIngreso.'.xlsx');
    header('Cache-Control: max-age=0');
    // If you're serving to IE 9, then the following may be needed
    header('Cache-Control: max-age=1');

    // If you're serving to IE over SSL, then the following may be needed
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
    header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header('Pragma: public'); // HTTP/1.0

    ob_end_clean();
    $writer = IOFactory::createWriter($documento, 'Xlsx');
    $writer->save('php://output');
    exit;
}
