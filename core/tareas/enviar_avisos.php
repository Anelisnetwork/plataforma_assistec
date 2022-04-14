<?php
//require_once('core/core.php');

if(!isset($_GET['token'])||$_GET['token']!=md5('laconcongrelos')){
	exit('Hola, ke ase?');
}

require_once('/var/www/vhosts/assistec.es/httpdocs/plataforma/core/core.php');

open_bd();

$estemes=date('n')==1?12:date('n')-1;
$esteanho=date('n')==1?date('Y')-1:date('Y');

$almcondatos=array_comas('select distinct da_idtaller from datos_actividad where da_idtipo=1 and da_mes='.$estemes.' and da_ano='.$esteanho);

$filtro_condatos=$almcondatos==''?'':' and ta_idtaller not in('.$almcondatos.')';
$noenviar[]=1341;// Cerdá Motors
$noenviar[]=1646;// GREGORIO RODRIGUEZ BUENDIA
$noenviar=implode(',',$noenviar);
$filtro_noenvio=$noenviar==''?'':' and ta_idtaller not in('.$noenviar.')';

$datosact=list_object('select * from talleres, usuarios where ta_idtaller=us_idtaller and us_estado!=3 and us_rango=3 and ta_avisodatos=1'.$filtro_condatos.$filtro_noenvio);

$correos_enviados=array();
$correos_fallidos=array();

foreach ($datosact as $dato){
	$mail_destino=$dato->ta_email;
	//$mail_destino='g.barrasa@grupoanelis.com';
	$nombre=u8d_($dato->ta_nombre);
	
	$asunto='No ha grabado sus datos de actividad';
	
	$nombre_com='Assistec Asesores';
	
	$cuerpo = '<html><head><title>No ha grabado sus datos de actividad</title></head><body style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#555">';
	$cuerpo .= 'Estimado cliente:<br><br>Le informamos de que a d&iacute;a '.date('d').' de '.nom_mes(date('n')).' todav&iacute;a no disponemos de datos de actividad del cierre del mes pasado.<br/>';
	$cuerpo .= 'Le invitamos a que acceda a nuestra aplicaci&oacute;n para introducir los datos de actividad necesarios para la elaboración del informe mensual.<br/><br/>';
	$cuerpo .= '<br><br>Muchas gracias por utilizar nuestros servicios.<br>Reciba un cordial saludo.<br><br>
		<span  style="color:#F00"><strong>Assistec Asesores</strong></span><br>
		<strong>Tel:</strong> (+34) 628 478 051<br>
		<strong>E-mail:</strong> '. _RECEPTOR_ .'<br>
		<strong>Web:</strong> www.assistec.es<br><br>';
		
	$cuerpo .= '<span style="color:#666; font-size:11px">AVISO LEGAL<br>
		En cumplimiento de lo establecido en la LOPD, le informamos que sus datos ser&aacute;n tratados en nuestros ficheros, con la finalidad del mantenimiento y cumplimiento de la relaci&oacute;n con nuestra entidad, incluyendo el env&iacute;o de comunicaciones en el marco de la citada relaci&oacute;n. Asimismo, sus datos ser&aacute;n cedidos en todos aquellos casos en que sea necesario para el desarrollo, cumplimiento y control de la relaci&oacute;n con nuestra entidad o en los supuestos en que lo autorice una norma con rango de ley. En cumplimiento de la LOPD puede ejercitar sus derechos ARCO ante '. strtoupper($nombre_com) .' adjuntando fotocopia de su DNI. El contenido de esta comunicaci&oacute;n, as&iacute; como el de toda la documentaci&oacute;n anexa, est&aacute; sujeta al deber de secreto y va dirigida &uacute;nicamente a su destinatario. En el supuesto de que usted no fuera el destinatario, le solicitamos que nos lo indique y no comunique su contenido a terceros, procediendo a su destrucci&oacute;n.</span>';
	$cuerpo .= "</body></html>"; 
	
	if(enviar_email($mail_destino, $nombre, '', '', $asunto, $cuerpo, $nombre_com, _RECEPTOR_, '', '', '', '', '', '', '', '')==1){
		$correos_enviados[]=array('nombre'=>u8d_($dato->ta_nombre),'correo'=>$dato->ta_email);
	}
	else{
		$correos_fallidos[]=array('nombre'=>u8d_($dato->ta_nombre),'correo'=>$dato->ta_email);
	}
	
}

$mail_destino='web@assistec.es';
$nombre='Manuel Baez';

$asunto='Envío automático de avisos';

$nombre_com='Assistec Asesores';

$cuerpo = '<html><head><title>Envío automático de avisos</title></head><body style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#555">';
$cuerpo .= 'Se ha procedido a enviar las alertas de falta de datos de actividad a los talleres correspondientes; el resultado es el siguiente:<br/><br/>';
$cuerpo .= '<strong>Alertas enviadas ('.count($correos_enviados).'):</strong><br/>';
foreach($correos_enviados as $ce){
	$cuerpo .= $ce['nombre'].' -> '.$ce['correo'].'<br/>';
}
$cuerpo .= '<br/><strong>Alertas fallidas ('.count($correos_fallidos).'):</strong><br/>';
foreach($correos_fallidos as $cf){
	$cuerpo .= $cf['nombre'].' -> '.$cf['correo'].'<br/>';
}
$cuerpo .= '<br><br>Muchas gracias por utilizar nuestros servicios.<br>Reciba un cordial saludo.<br><br>
	<span  style="color:#F00"><strong>Assistec Asesores</strong></span><br>
	<strong>Tel:</strong> (+34) 628 478 051<br>
	<strong>E-mail:</strong> '. _RECEPTOR_ .'<br>
	<strong>Web:</strong> www.assistec.es<br><br>';
	
$cuerpo .= '<span style="color:#666; font-size:11px">AVISO LEGAL<br>
	En cumplimiento de lo establecido en la LOPD, le informamos que sus datos ser&aacute;n tratados en nuestros ficheros, con la finalidad del mantenimiento y cumplimiento de la relaci&oacute;n con nuestra entidad, incluyendo el env&iacute;o de comunicaciones en el marco de la citada relaci&oacute;n. Asimismo, sus datos ser&aacute;n cedidos en todos aquellos casos en que sea necesario para el desarrollo, cumplimiento y control de la relaci&oacute;n con nuestra entidad o en los supuestos en que lo autorice una norma con rango de ley. En cumplimiento de la LOPD puede ejercitar sus derechos ARCO ante '. strtoupper($nombre_com) .' adjuntando fotocopia de su DNI. El contenido de esta comunicaci&oacute;n, as&iacute; como el de toda la documentaci&oacute;n anexa, est&aacute; sujeta al deber de secreto y va dirigida &uacute;nicamente a su destinatario. En el supuesto de que usted no fuera el destinatario, le solicitamos que nos lo indique y no comunique su contenido a terceros, procediendo a su destrucci&oacute;n.</span>';
$cuerpo .= "</body></html>"; 

enviar_email($mail_destino, $nombre, 'g.barrasa@grupoanelis.com', 'Grupo Anelis', $asunto, $cuerpo, $nombre_com, _RECEPTOR_, '', '', '', '', '', '', '', '');
	
close_bd();
?>