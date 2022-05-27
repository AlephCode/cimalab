<?php
//Incluyo config donde se encuentra el autoload de vendor de composer
include "../../config.php";
//From Excel documents I'll use these function
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;


//Consulta mySQL
require_once "../../models/connection.php";
$id = 3;
$stmt = Conexion::connect()->prepare("SELECT *, DATE_FORMAT(time,'%h:%i') AS time FROM laboratories_users WHERE id_laboratory=:id");

$stmt->bindParam(":id",$id,PDO::PARAM_STR);

$stmt->execute();

$list =  $stmt->fetchAll(PDO::FETCH_ASSOC);

//SpreadSheet

$spreadsheet = new Spreadsheet();//Create Object spreadsheet
$spreadsheet->getProperties()->setCreator("Admin")->setTitle("Report");//Indicate the creator of this object

$spreadsheet->setActiveSheetIndex(0);
$activeSheet = $spreadsheet->getActiveSheet();

$spreadsheet->getDefaultStyle()->getFont()->setName('Tahoma');
$spreadsheet->getDefaultStyle()->getFont()->setSize(15);

$spreadsheet->getActiveSheet()->getStyle('A1:C1')->getFill()
    ->setFillType(Fill::FILL_SOLID)
    ->getStartColor()->setARGB('50ab59');



$activeSheet->getColumnDimension('A')->setWidth(5);
$activeSheet->getColumnDimension('B')->setWidth(10);


$activeSheet->setCellValue('A1','#');
$activeSheet->setCellValue('B1','Matrícula');
$activeSheet->setCellValue('C1','Hora');

$row = 2;
foreach ($list as $key => $value){
    $activeSheet->setCellValue('A'.$row,($key+1));
    $activeSheet->setCellValue('B'.$row,$value['matricula']);
    $activeSheet->setCellValue('C'.$row,$value['time']);
    $row++;
}

//Style's Header of my document
$styleArray = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['argb' => 'FFFF'],
        ],
    ],
];

$activeSheet->getStyle('A1:C'.($row-1))->applyFromArray($styleArray);
//=======================Para generar formatos Xlsx======================================
/* Here there will be some code where you create $spreadsheet */

// redirect output to client browser
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="reporte.xlsx"');
header('Cache-Control: max-age=0');

$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');
//==============================END======================================================

//=======================Para generar formatos Xls======================================
/* Here there will be some code where you create $spreadsheet */

// redirect output to client browser
//header('Content-Type: application/vnd.ms-excel');
//header('Content-Disposition: attachment;filename="reporte.xls"');
//header('Cache-Control: max-age=0');
//
//$writer = IOFactory::createWriter($spreadsheet, 'Xls');
//$writer->save('php://output');
//==============================END======================================================



//En caso de que quiera guardarlo en la carpeta del servidor
//$writer = new Xlsx($spreadsheet);
//$writer->save('Mi_Excel.xlsx');