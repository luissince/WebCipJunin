<?php

ini_set('max_execution_time', '300');
ini_set("pcre.backtrack_limit", "10000000");
ini_set('memory_limit', '-1');

require __DIR__ . "/lib/phpspreadsheet/vendor/autoload.php";
include_once('../model/ListarIngenierosAdo.php');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

$fechaIngreso = "LISTA COLEGIADOS HABILITADOS/NO HABILITADOS";

$listarColegiados = ListarIngenierosAdo::allIngenieros($data);

if (!is_array($resumen)) {
    echo $resumen;
} else {

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
