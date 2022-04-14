<?php
date_default_timezone_set('Europe/Madrid');

include('core/core.php');
open_bd();

$hay_errores=0;
$mensaje_error='';

if(isset($_POST['Ds_Order'])&&isset($_POST['Ds_Response'])&&isset($_POST['Ds_AuthorisationCode'])&&isset($_POST['Ds_Signature'])){//Finalizamos proceso de pago TPV
//if(1==1){//Finalizamos proceso de pago
	include('core/scripts/respuesta_tpv.php');
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
    <style>
	a{
		color:#555;
		text-decoration:none;
	}
	a:hover{
		text-decoration:none;
	}
	.link {
		cursor:pointer;
	}
	.indent{
		padding:5px 8px;
	}
	.redondo{
		-moz-border-radius: 3px;
		-webkit-border-radius: 3px;
		border-radius: 3px;
	}
	</style>
	
	<?php
	if($hay_errores==1){
	?>
    <div style="width:600px; text-align:center; margin:5% auto 0% auto; line-height:140%; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#555">
        <img src="<?=_RAIZ_?>imagenes/assistec.png" /><br /><br />
        No ha sido posible realizar el pago; por favor contacte con nosotros desde el siguiente enlace: <a href="http://www.assistec.es/contactar_con_assistec.php"><strong style="color:#E2001A">Contactar con Assistec</strong></a>
        <br /><br /><br />
        <?=$mensaje_error?>
        <br /><br /><br /><br />
        <a target="_blank" href="<?=_RAIZ_?>pdf/<?=en__('pdf_factura%%imprimir%%'.$idfactura.'%%'.$idtaller.'')?>/" class="indent redondo link" style="width:300px; background-color:#E2001A; color:#FFF">Descargar factura</a>
        <br /><br />
        <a href="http://www.assistec.es/">Volver a la web</a>
    </div>
	<?php
    }
	else{
	?>
	<div style="width:600px; text-align:center; margin:5% auto 0% auto; line-height:140%; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#555">
        <img src="<?=_RAIZ_?>imagenes/assistec.png" /><br /><br />
        El pago ha sido realizado correctamente; ya puede acceder a su panel de control desde el siguiente enlace: <a href="http://www.assistec.es/plataforma/"><strong style="color:#E2001A">Acceder a Assistec Online</strong></a>
        <br /><br />
        Muchas gracias por su confianza.
        <br /><br /><br /><br />
        <a target="_blank" href="<?=_RAIZ_?>pdf/<?=en__('pdf_factura%%imprimir%%'.$idfactura.'%%'.$idtaller.'')?>/" class="indent redondo link" style="width:300px; background-color:#E2001A; color:#FFF">Descargar factura</a>
    </div>
    <?php
	}
	?>
	
	</body>
	</html>
<?php
}//Finalizamos proceso de pago TPV

else{//Iniciamos proceso de pago

	$data=isset($_SESSION['proceso_pago']['data'])?$_SESSION['proceso_pago']['data']:clean_get('datos');
	//echo $_SESSION['proceso_pago']['data'].'<br>';
	unset($_SESSION['proceso_pago']);
	//$data=en__('alta_nueva'.'%%1%%1%%2%%15.00%%2');
	
	//echo $data; exit;
	
	$datos=explode('%%',de__($data));
	
	if(count($datos)==0||$datos[0]==''){
		exit('Error en datos.');
	}
	
	if($datos[0]=='alta_nueva'){//NUEVO REGISTRO
		unset($_SESSION['proceso_pago']);
		include('core/includes/alta_nueva.php');
	}//NUEVO REGISTRO
	
	else if($datos[0]=='pago_factura'){//PAGO DE FACTURA
		$fpago=2;
		include('core/includes/pagar_factura.php');
	}//PAGO DE FACTURA
	else{
		exit('Faltan datos');
	}
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
			include('core/scripts/procesa_tpv.php');
		}
		else if($fpago==2){//Transferencia
		?>
        <div style="width:600px; text-align:center; margin:5% auto 0% auto; line-height:140%; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#555">
            <img src="<?=_RAIZ_?>imagenes/assistec.png" /><br /><br />
            Se ha generado la factura correspondiente al servicio seleccionado; puede descargarla pulsando el siguiente bot&oacute;n:
            <br /><br />
            <a target="_blank" href="<?=_RAIZ_?>pdf/<?=en__('pdf_factura%%imprimir%%'.$idfactura.'%%'.$idtaller.'')?>/" class="indent redondo link" style="width:300px; background-color:#E2001A; color:#FFF">Descargar factura</a>
            <br /><br />
            En la misma encontrar&aacute; los datos de la cuenta a la que debe hacer la transferencia por el importe total de la factura, una vez realizado el ingreso puede agilizar el proceso de activaci&oacute;n enviando el justificante de la operaci&oacute;n por correo electr&oacute;nico a <strong style="color:#E2001A">web@assistec.es</strong>.
            <br /><br />
            Muchas gracias por su confianza.
        </div>
        <?php
		}
		else if($fpago==0){//Suscripción
		?>
        <div style="width:600px; text-align:center; margin:5% auto 0% auto; line-height:140%; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#555">
            <img src="<?=_RAIZ_?>imagenes/assistec.png" /><br /><br />
            Se ha dado de alta en nuestros panel de gesti&oacute;n con la promoci&oacute;n correctamente aplicada.
            <br /><br />
            Muchas gracias por su confianza.
        </div>
        <?php

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