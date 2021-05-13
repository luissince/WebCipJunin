<?php

set_time_limit(300); //evita el error 20 segundos de peticion
session_start();

require __DIR__ . "/lib/phpspreadsheet/vendor/autoload.php";
include_once('../model/IngresosAdo.php');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

$ventas = IngresosAdo::ReporteGeneralIngresosPorFechas(intval($_GET["opcion"]), $_GET["txtFechaInicial"], $_GET["txtFechaFinal"], intval($_GET["comprobante"]));

if (!is_array($ventas)) {
    echo $ventas;
} else {

    $documento = new Spreadsheet();
    $documento
        ->getProperties()
        ->setCreator("Creado por SysSoftIntegra")
        ->setTitle('Reporte de Ingresos')
        ->setSubject('Reporte')
        ->setDescription('Reporte general de ingresos de la fecha ' . $_GET["txtFechaInicial"] . ' al ' . $_GET["txtFechaFinal"])
        ->setKeywords('Reporte de Ingresos')
        ->setCategory('Ingresos');

    $documento->getActiveSheet()->setTitle("Ingresos");

    $documento->getActiveSheet()->getStyle('A1:M1')->applyFromArray(array(
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

    $documento->setActiveSheetIndex(0)->mergeCells('A1:M1');
    $documento->setActiveSheetIndex(0)
        ->setCellValue("A1", "REPORTE GENERAL DE INGRESOS DE CIP-JUNIN");

    $documento->getActiveSheet()->getStyle('K2:M2')->applyFromArray(array(
        'borders' => array(
            'outline' => array(
                'borderStyle' => Border::BORDER_THIN,
                'color' => array('argb' => '000000'),
            ),
        ),
        'fill' => array(
            'fillType' => Fill::FILL_SOLID,
            'startColor' => array('rgb' => '808080')
        ),
        'font'  => array(
            'bold'  =>  true,
            'color' => array('argb' => 'ffffff')
        ),
        'alignment' => array(
            'horizontal' => Alignment::HORIZONTAL_CENTER
        )
    ));
    $documento->setActiveSheetIndex(0)
        ->setCellValue("K2", "FECHA")
        ->setCellValue("L2", $_GET["txtFechaInicial"])
        ->setCellValue("M2", $_GET["txtFechaFinal"]);

    $documento->getActiveSheet()->getStyle('A3:M3')->applyFromArray(array(
        'fill' => array(
            'type' => Fill::FILL_SOLID,
            'color' => array('rgb' => 'E5E4E2')
        ),
        'font'  => array(
            'bold'  =>  true
        ),
        'alignment' => array(
            'horizontal' => Alignment::HORIZONTAL_CENTER
        )
    ));

    $documento->setActiveSheetIndex(0)
        ->setCellValue("A3", "ID")
        ->setCellValue("B3", "MOTIVO ANULACIÓN")
        ->setCellValue("C3", "FECHA ANULACIÓN")
        ->setCellValue("D3", "SERIE")
        ->setCellValue("E3", "NUMERACIÓN")
        ->setCellValue("F3", "FECHA INGRESO")
        ->setCellValue("G3", "ESTADO")
        ->setCellValue("H3", "NUM. DNI")
        ->setCellValue("I3", "NUM. CIP")
        ->setCellValue("J3", "APELLIDOS")
        ->setCellValue("k3", "NOMBRES")
        ->setCellValue("L3", "MONTO")
        ->setCellValue("M3", "MONTO ANULADO");

    $cel = 4;
    foreach ($ventas as $key => $value) {
        $documento->getActiveSheet()->getStyle('A' . $cel . ':K' . $cel . '')->applyFromArray(array(
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

        if ($value["Estado"] === "C") {
            $documento->getActiveSheet()->getStyle('A' . $cel . ':K' . $cel . '')->applyFromArray(array(
                'font'  => array(
                    'bold'  =>  false,
                    'color' => array('rgb' => '000000')
                ),
                'alignment' => array(
                    'horizontal' => Alignment::HORIZONTAL_LEFT
                )
            ));
            $documento->getActiveSheet()->getStyle("L" . $cel)->getNumberFormat()->setFormatCode('0.00');
            $documento->getActiveSheet()->getStyle("M" . $cel)->getNumberFormat()->setFormatCode('0.00');

            $documento->setActiveSheetIndex(0)
                ->setCellValue("A" . $cel,  strval($value["Id"]))
                ->setCellValue("B" . $cel, strval($value["MotivoAnulacion"]))
                ->setCellValue("C" . $cel, strval($value["FechaAnulacion"]))
                ->setCellValue("D" . $cel, strval($value["Serie"]))
                ->setCellValue("E" . $cel, strval($value["NumRecibo"]))
                ->setCellValue("F" . $cel, strval($value["FechaPago"]))
                ->setCellValue("G" . $cel, strval($value["Estado"]))
                ->setCellValue("H" . $cel, strval($value["idDNI"]))
                ->setCellValue("I" . $cel, strval($value["CIP"]))
                ->setCellValue("J" . $cel, strval($value["Apellidos"]))
                ->setCellValue("K" . $cel, strval($value["Nombres"]))
                ->setCellValue("L" . $cel, strval($value["Total"]))
                ->setCellValue("M" . $cel, strval(0));
        } else {
            $documento->getActiveSheet()->getStyle('A' . $cel . ':K' . $cel . '')->applyFromArray(array(
                'font'  => array(
                    'bold'  =>  false,
                    'color' => array('rgb' => 'd10505')
                ),
                'alignment' => array(
                    'horizontal' => Alignment::HORIZONTAL_LEFT
                )
            ));
            $documento->getActiveSheet()->getStyle("L" . $cel)->getNumberFormat()->setFormatCode('0.00');
            $documento->getActiveSheet()->getStyle("M" . $cel)->getNumberFormat()->setFormatCode('0.00');

            $documento->setActiveSheetIndex(0)
                ->setCellValue("A" . $cel,  strval($value["Id"]))
                ->setCellValue("B" . $cel, strval($value["MotivoAnulacion"]))
                ->setCellValue("C" . $cel, strval($value["FechaAnulacion"]))
                ->setCellValue("D" . $cel, strval($value["Serie"]))
                ->setCellValue("E" . $cel, strval($value["NumRecibo"]))
                ->setCellValue("F" . $cel, strval($value["FechaPago"]))
                ->setCellValue("G" . $cel, strval($value["Estado"]))
                ->setCellValue("H" . $cel, strval($value["idDNI"]))
                ->setCellValue("I" . $cel, strval($value["CIP"]))
                ->setCellValue("J" . $cel, strval($value["Apellidos"]))
                ->setCellValue("K" . $cel, strval($value["Nombres"]))
                ->setCellValue("L" . $cel, strval(0))
                ->setCellValue("M" . $cel, strval($value["Total"]));
        }

        $cel++;
    }

    //Ancho de las columnas
    $documento->getActiveSheet()->getColumnDimension('A')->setWidth(5);
    $documento->getActiveSheet()->getColumnDimension('B')->setWidth(20);
    $documento->getActiveSheet()->getColumnDimension('C')->setWidth(20);
    $documento->getActiveSheet()->getColumnDimension('D')->setWidth(15);
    $documento->getActiveSheet()->getColumnDimension('E')->setWidth(15);
    $documento->getActiveSheet()->getColumnDimension('F')->setWidth(20);
    $documento->getActiveSheet()->getColumnDimension('G')->setWidth(15);
    $documento->getActiveSheet()->getColumnDimension('H')->setWidth(15);
    $documento->getActiveSheet()->getColumnDimension('I')->setWidth(15);
    $documento->getActiveSheet()->getColumnDimension('J')->setWidth(20);
    $documento->getActiveSheet()->getColumnDimension('K')->setWidth(20);
    $documento->getActiveSheet()->getColumnDimension('L')->setWidth(15);
    $documento->getActiveSheet()->getColumnDimension('M')->setWidth(15);

    $nombreDelDocumento = "Reporte de Ingresos del " . $_GET["txtFechaInicial"] . " al " . $_GET["txtFechaFinal"] . ".xlsx";
    // Redirect output to a client’s web browser (Xlsx)
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename=' . $nombreDelDocumento);
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
