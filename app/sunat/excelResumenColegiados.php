<?php

set_time_limit(300); //evita el error 20 segundos de peticion
session_start();

require __DIR__ . "/lib/phpspreadsheet/vendor/autoload.php";
include_once('../model/ListarIngenierosAdo.php');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

$data['condicion'] = $_GET['condicion'];
$data['fiColegiado'] = $_GET['fiColegiado'];
$data['ffColegiado'] = $_GET['ffColegiado'];
$data['opcion'] = $_GET['opcion'];

$listarColegiados = ListarIngenierosAdo::allIngenieros($data);

if (!is_array($listarColegiados)) {
    echo $listarColegiados;
} else {

    $documento = new Spreadsheet();
    $documento
        ->getProperties()
        ->setCreator("Creado por SysSoftIntegra")
        ->setTitle('Reporte de Colegiados')
        ->setSubject('Reporte')
        ->setDescription('Reporte general de Colegiados')
        ->setKeywords('Reporte de Colegiados')
        ->setCategory('Colegiados');

    $documento->getActiveSheet()->setTitle("Colegiados");

    $documento->getActiveSheet()->getStyle('A1:I1')->applyFromArray(array(
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

    $documento->setActiveSheetIndex(0)->mergeCells('A1:I1');
    $documento->setActiveSheetIndex(0)
        ->setCellValue("A1", "REPORTE GENERAL DE COLEGIADOS DEL CIP-JUNIN");

    $documento->getActiveSheet()->getStyle('A2:I2')->applyFromArray(array(
        'borders' => array(
            'outline' => array(
                'borderStyle' => Border::BORDER_THIN,
                'color' => array('argb' => '000000'),
            ),
        ),
        'fill' => array(
            'fillType' => Fill::FILL_SOLID,
            'startColor' => array('rgb' => 'C4C4C4')
        ),
        'font'  => array(
            'bold'  =>  true,
            'color' => array('argb' => '000000')
        ),
        'alignment' => array(
            'horizontal' => Alignment::HORIZONTAL_CENTER
        )
    ));

    $documento->setActiveSheetIndex(0)
        ->setCellValue("A2", "N°")
        ->setCellValue("B2", "DNI")
        ->setCellValue("C2", "N° CIP")
        ->setCellValue("D2", "APELLIDOS")
        ->setCellValue("E2", "NOMBRES")
        ->setCellValue("F2", "CONDICION")
        ->setCellValue("G2", "FECHA COLEGIADO")
        ->setCellValue("H2", "CAPITULO")
        ->setCellValue("I2", "ESPECIALIDAD");

    $cel = 3;
    foreach ($listarColegiados as $key => $value) {
        $documento->getActiveSheet()->getStyle('A' . $cel . ':I' . $cel . '')->applyFromArray(array(
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

        // if ($value["Estado"] === "C") {
        //     $documento->getActiveSheet()->getStyle('A' . $cel . ':K' . $cel . '')->applyFromArray(array(
        //         'font'  => array(
        //             'bold'  =>  false,
        //             'color' => array('rgb' => '000000')
        //         ),
        //         'alignment' => array(
        //             'horizontal' => Alignment::HORIZONTAL_LEFT
        //         )
        //     ));
        //     $documento->getActiveSheet()->getStyle("L" . $cel)->getNumberFormat()->setFormatCode('0.00');
        //     $documento->getActiveSheet()->getStyle("M" . $cel)->getNumberFormat()->setFormatCode('0.00');

        //     $documento->setActiveSheetIndex(0)
        //         ->setCellValue("A" . $cel,  strval($value["Id"]))
        //         ->setCellValue("B" . $cel, strval($value["MotivoAnulacion"]))
        //         ->setCellValue("C" . $cel, strval($value["FechaAnulacion"]))
        //         ->setCellValue("D" . $cel, strval($value["Serie"]))
        //         ->setCellValue("E" . $cel, strval($value["NumRecibo"]))
        //         ->setCellValue("F" . $cel, strval($value["FechaPago"]))
        //         ->setCellValue("G" . $cel, strval($value["Estado"]))
        //         ->setCellValue("H" . $cel, strval($value["idDNI"]))
        //         ->setCellValue("I" . $cel, strval($value["CIP"]))
        //         ->setCellValue("J" . $cel, strval($value["Apellidos"]))
        //         ->setCellValue("K" . $cel, strval($value["Nombres"]))
        //         ->setCellValue("L" . $cel, strval($value["Total"]))
        //         ->setCellValue("M" . $cel, strval(0));
        // } else {
        $documento->getActiveSheet()->getStyle('F' . $cel . ':G' . $cel . '')->applyFromArray(array(
            'font'  => array(
                'bold'  =>  false,
                'color' => array('rgb' => '000000')
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER
            )
        ));

        $documento->setActiveSheetIndex(0)
            ->setCellValue("A" . $cel,  strval($value["Id"]))
            ->setCellValue("B" . $cel, strval($value["idDNI"]))
            ->setCellValue("C" . $cel, strval($value["CIP"]))
            ->setCellValue("D" . $cel, strval($value["Apellidos"]))
            ->setCellValue("E" . $cel, strval($value["Nombres"]))
            ->setCellValue("F" . $cel, strval($value["Condicion"]))
            ->setCellValue("G" . $cel, strval($value["FechaColegiado"]))
            ->setCellValue("H" . $cel, strval($value["Capitulo"]))
            ->setCellValue("I" . $cel, strval($value["Especialidad"]));
        // }

        $cel++;
    }

    //Ancho de las columnas
    $documento->getActiveSheet()->getColumnDimension('A')->setWidth(7);
    $documento->getActiveSheet()->getColumnDimension('B')->setWidth(15);
    $documento->getActiveSheet()->getColumnDimension('C')->setWidth(10);
    $documento->getActiveSheet()->getColumnDimension('D')->setWidth(30);
    $documento->getActiveSheet()->getColumnDimension('E')->setWidth(30);
    $documento->getActiveSheet()->getColumnDimension('F')->setWidth(17);
    $documento->getActiveSheet()->getColumnDimension('G')->setWidth(20);
    $documento->getActiveSheet()->getColumnDimension('H')->setWidth(20);
    $documento->getActiveSheet()->getColumnDimension('I')->setWidth(35);

    $condicion = $_GET['condicion'] = 'T' ? 'Transeunte' : $_GET['condicion'] = 'O' ? 'Ordinario' : $_GET['condicion'] = 'V' ? 'Vitalicio' : $_GET['condicion'] = 'R' ? 'Retirado' : 'Fallecido';

    if ($_GET["opcion"] == 1) {
        $nombreDelDocumento = "Reporte de Colegiados .xlsx";
    } else if ($_GET["opcion"] == 2){
        $nombreDelDocumento = "Reporte de Colegiados - Condicion_".$condicion.".xlsx";
    } else if($_GET["opcion"] == 3){
        $nombreDelDocumento = "Reporte de Colegiados - Condicion_".$condicion." desde la fecha ".$_GET['fiColegiado']." hasta ".$_GET['ffColegiado'].".xlsx";
    }

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
