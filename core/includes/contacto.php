<?php
$_SESSION['datos_'._ID_PAG_]['contacto']['hayerrores']=0;

$idtaller=clean_post('idtaller');
num_rows('select ta_idtaller from talleres where ta_idtaller='.$idtaller.'')==0?$_SESSION['datos_'._ID_PAG_]['contacto']['hayerrores']=1:'';

if($_SESSION['datos_'._ID_PAG_]['contacto']['hayerrores']==0){
	$url_dest=clean_post('url_dest');
	$perscont=u8_(clean_post('perscont'));
	$tlfcont=clean_post('tlfcont');
	$mailcont=clean_post('mailcont');
	$horacont=clean_post('horacont');
	$asuntocont=clean_post('asuntocont');
	$comentcont=u8_(clean_post('comentcont'));
	
	$perscont==''?$perscont=dato_taller('ta_contacto',$idtaller):'';
	$tlfcont==''?$tlfcont=dato_taller('ta_telefono1',$idtaller):'';
	$mailcont==''||!VerificarDireccionCorreo($mailcont)?$mailcont=dato_taller('ta_email',$idtaller):'';
	$nombretaller=dato_taller('ta_nombre',$idtaller);
	
	$horario=$horacont==''?'':'<strong>Horario de contacto</strong>: '.$horacont.'<br>';
	$horarioalt=$horacont==''?'':'Horario de contacto: '.$horacont.'
	';
	
	
	$asunto='Contacto desde cuadro de mando Assistec - Taller: '.$nombretaller;
	$contenido='<strong>Persona de contacto</strong>: '.$perscont.'<br>
	<strong>Tel&eacute;fono de contacto</strong>: '.$tlfcont.'<br>
	<strong>Correo de contacto</strong>: '.$mailcont.'<br>
	'.$horario.'
	<strong>Asunto</strong>: '.$asuntocont.'<br>
	<strong>Comentarios</strong>: '.nl2br(stripslashes($comentcont)).'';
	ob_start(); # apertura de bufer
	include( _ZEND_.'templates/mail_template_def.php' );
	$cuerpo = ob_get_clean();
	$altbody='Persona de contacto: '.$perscont.'
	Tel&eacute;fono de contacto: '.$tlfcont.'
	Correo de contacto: '.$mailcont.'
	'.$horario.'Asunto: '.$asuntocont.'
	Comentarios: '.$comentcont.'';
		
	!enviar_email('web@assistec.es', 'Cuadro de mando Assitec', '', '', $asunto, $cuerpo, $nombretaller, $mailcont, '', '', '', '', '', $altbody)?$_SESSION['datos_'._ID_PAG_]['contacto']['hayerrores']=1:'';
}

fuera_de_aqui($url_dest);

?>