<?php
date_default_timezone_set('Europe/Madrid');

include('core/core.php');

show_errors('on');

open_bd();

$hay_errores=0;
$mensaje_error='';

if(isset($_POST['Ds_Order'])&&isset($_POST['Ds_Response'])&&isset($_POST['Ds_AuthorisationCode'])&&isset($_POST['Ds_Signature'])){//Finalizamos proceso de pago TPV
//if(1==1){//Finalizamos proceso de pago
	include('core/scripts/respuesta_tpv_test.php');
}//Finalizamos proceso de pago TPV

else{//Iniciamos proceso de pago

	$data=isset($_SESSION['proceso_pago']['data'])?$_SESSION['proceso_pago']['data']:clean_get('datos');
	//echo $_SESSION['proceso_pago']['data'].'<br>';
	unset($_SESSION['proceso_pago']);
	//$data=en__('alta_nueva'.'%%1%%1%%2%%15.00%%2');
	
	//echo $data; exit;
	
	$data=en__('pago_factura%%4%%6%%477.00');
	
	$datos=explode('%%',de__($data));
	
	if(count($datos)==0||$datos[0]==''){
		exit('Error en datos.');
	}
	
	$idfactura=$datos[1];
	$idcli=$datos[2];
	$total=$importe=$datos[3];
	
	$fpago=1;
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="shortcut icon" href="<?=_RAIZ_?>imagenes/assistec_ico.png">
	<meta name="viewport" content="width=device-width, user-scalable=yes" />
	<script src="<?=_RAIZ_?>js/jquery-1.11.2.js" type="text/javascript"></script>
	<title>Assistec - Proceso de pago</title>
	<link href='https://fonts.googleapis.com/css?family=Ubuntu|Oswald:400,300' rel='stylesheet' type='text/css'>
	<link href="<?=_RAIZ_?>estilos/estilos.css" rel="stylesheet" type="text/css" />
	</head>
	
	<body>
	
	<?php
	if($hay_errores==1){
		echo $mensaje_error;
	}
	else{
		if($fpago==1){//TPV
			include('core/scripts/procesa_tpv_test.php');
		}
		
		else{//Otros
		}
	}
	?>
	
	</body>
	</html>
<?php 
}//Iniciamos proceso de pago

close_bd();
?>