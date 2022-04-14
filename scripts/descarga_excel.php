<?php
require_once('../core/core.php');
open_bd();

if (!isset($_SESSION['datos_'._ID_PAG_]['idusuario'])) {
	fuera_de_aqui();
	exit();
}

if(isset($_POST['tipo_archivo'])&&file_exists(_ZEND_.'includes/'.$_POST['tipo_archivo'].'.php')){
	$archivo=clean_post('tipo_archivo');
}
else if(isset($_GET['tipo_archivo'])&&file_exists(_ZEND_.'includes/'.$_GET['tipo_archivo'].'.php')){
	$archivo=clean_get('tipo_archivo');
}
else{
	fuera_de_aqui();
	exit();
}
//echo $_POST['tipo_archivo'];exit;
require_once _ZEND_.'excel/Classes/PHPExcel.php';
require_once _ZEND_.'excel/fn_PHPExcel.php';

$objPHPExcel = new PHPExcel();
$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel); 

$objPHPExcel->getProperties()->setCreator("Assitec")->setLastModifiedBy("Assistec");

$titulo='Archivo_Assistec';

set_hoja(0);
	
$cell=1;

$col='A';

include(_ZEND_.'includes/'.$archivo.'.php');

close_bd();
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$titulo.'.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
?>