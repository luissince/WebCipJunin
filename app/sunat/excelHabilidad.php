<?php

ini_set('max_execution_time', '300');
ini_set("pcre.backtrack_limit", "10000000");
ini_set('memory_limit', '-1');

require __DIR__ . "/lib/phpspreadsheet/vendor/autoload.php";
include_once('../model/PersonaAdo.php');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

$opcion = $_GET['opcion'];
$search = $_GET['txtBuscar'];
$tipoHabilidad = $_GET['cbHabilidad'];
$capitulo = $_GET['cbCapitulo'];
$especialidad = $_GET['cbEspecialidad'];
$fecha = $_GET['fecha'];
$fechaFin = $_GET['fechaFin'];

$subtitulo = "LISTA COLEGIADOS HABILITADOS/NO HABILITADOS";


$data = PersonaAdo::getHabilidadIngenieroForExcel($opcion, $search, intval($tipoHabilidad), intval($capitulo), intval($especialidad), $fecha, $fechaFin);

if (!is_array($data)) {
    echo $data;
} else {

    $documento = new Spreadsheet();
    $documento
        ->getProperties()
        ->setCreator("Creado por SysSoftIntegra")
        ->setTitle('Lista de Colegiados Habilitados/No Habilitados')
        ->setSubject('Reporte')
        ->setDescription('Lista de Colegiados Habilitados/No Habilitados')
        ->setKeywords('Reporte de Colegiados')
        ->setCategory('Reporte');

    $documento->getActiveSheet()->setTitle("Colegiados");

    $documento->getActiveSheet()->getStyle('A1:N1')->applyFromArray(array(
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
    $documento->setActiveSheetIndex(0)->mergeCells('A1:N1');
    $documento->setActiveSheetIndex(0)->setCellValue("A1", $subtitulo);

    $documento->getActiveSheet()->getStyle('A2:N2')->applyFromArray(array(
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
        ->setCellValue("B2", "N° CIP")
        ->setCellValue("C2", "N° DOCUMENTO")
        ->setCellValue("D2", "COLEGIADO")
        ->setCellValue("E2", "GENERO")
        ->setCellValue("F2", "CONDICION")
        ->setCellValue("G2", "CAPITULO")
        ->setCellValue("H2", "ESPECIALIDAD")
        ->setCellValue("I2", "FECHA COLEGIADO")
        ->setCellValue("J2", "FECHA ULT. CUOTA")
        ->setCellValue("K2", "HABILIDAD")
        ->setCellValue("L2", "HABILITADO HASTA")
        ->setCellValue("M2", "EMAIL")
        ->setCellValue("N2", "CELULAR");

    $cel = 3;
    // if ($data['Habilidad'] == "") {
    foreach ($data as $key => $value) {
        $documento->getActiveSheet()->getStyle('A' . $cel . ':N' . $cel)->applyFromArray(array(
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

        $documento->getActiveSheet()->getStyle('I' . $cel . ':J' . $cel . '', 'K' . $cel, 'L' . $cel)->applyFromArray(array(
            'font'  => array(
                'bold'  =>  false,
                'color' => array('rgb' => '000000')
            ),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER
            )
        ));

        if (strtolower($value['Habilidad']) == "habilitado") {
            $documento->getActiveSheet()->getStyle('k' . $cel)->applyFromArray(array(
                'font'  => array(
                    'bold'  =>  false,
                    'color' => array('rgb' => '1C64C0')
                ),
                'alignment' => array(
                    'horizontal' => Alignment::HORIZONTAL_LEFT
                )
            ));
        } else {
            $documento->getActiveSheet()->getStyle('l' . $cel)->applyFromArray(array(
                'font'  => array(
                    'bold'  =>  false,
                    'color' => array('rgb' => 'EE2C2C')
                ),
                'alignment' => array(
                    'horizontal' => Alignment::HORIZONTAL_LEFT
                )
            ));
        }

        $documento->setActiveSheetIndex(0)
            ->setCellValue("A" . $cel,  strval($value["Id"]))
            ->setCellValue("B" . $cel, strval($value["Cip"]))
            ->setCellValue("C" . $cel, strval($value["Dni"]))
            ->setCellValue("D" . $cel, strval($value["Apellidos"] . ", " . $value["Nombres"]))
            ->setCellValue("E" . $cel, strval($value["Genero"]))
            ->setCellValue("F" . $cel, strval($value["Condicion"]))
            ->setCellValue("G" . $cel, strval($value["Capitulo"]))
            ->setCellValue("H" . $cel, strval($value["Especialidad"]))
            ->setCellValue("I" . $cel, strval($value["FechaColegiado"]))
            ->setCellValue("J" . $cel, strval($value["FechaUltimaCuota"]))
            ->setCellValue("K" . $cel, strval($value["Habilidad"]))
            ->setCellValue("L" . $cel, strval($value["HabilitadoHasta"]))
            ->setCellValue("M" . $cel, strval($value["Email"]))
            ->setCellValue("N" . $cel, strval($value["Celular"]));
        $cel++;
    }
    // }

    //Ancho de las columnas
    $documento->getActiveSheet()->getColumnDimension('A')->setWidth(7);
    $documento->getActiveSheet()->getColumnDimension('B')->setWidth(10);
    $documento->getActiveSheet()->getColumnDimension('C')->setWidth(15);
    $documento->getActiveSheet()->getColumnDimension('D')->setWidth(60);
    $documento->getActiveSheet()->getColumnDimension('E')->setWidth(15);
    $documento->getActiveSheet()->getColumnDimension('F')->setWidth(17);
    $documento->getActiveSheet()->getColumnDimension('G')->setWidth(20);
    $documento->getActiveSheet()->getColumnDimension('H')->setWidth(35);
    $documento->getActiveSheet()->getColumnDimension('I')->setWidth(20);
    $documento->getActiveSheet()->getColumnDimension('J')->setWidth(20);
    $documento->getActiveSheet()->getColumnDimension('K')->setWidth(17);
    $documento->getActiveSheet()->getColumnDimension('L')->setWidth(20);
    $documento->getActiveSheet()->getColumnDimension('M')->setWidth(30);
    $documento->getActiveSheet()->getColumnDimension('N')->setWidth(20);


    // Redirect output to a client’s web browser (Xlsx)
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename=' . $subtitulo . '.xlsx');
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
