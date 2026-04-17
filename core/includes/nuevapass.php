<?php

$_SESSION['datos_'._ID_PAG_]['nuevapass']['hayerrores']=0;
$lista_errores=array();

$url_dest=clean_post('url_dest');

$email=$_SESSION['datos_'._ID_PAG_]['nuevapass']['np_correo']=clean_post('np_correo');

if($email==''){
	$_SESSION['datos_'._ID_PAG_]['nuevapass']['hayerrores']=1;
	$lista_errores[]='no_email';
}

$dato_cli=list_object('select * from usuarios where (us_correo="'.$email.'" OR us_nick="'.$email.'")');

if(count($dato_cli)>1){//Hay más de 1 usuario con estos datos
	$_SESSION['datos_'._ID_PAG_]['nuevapass']['hayerrores']=1;
	$lista_errores[]='np_correo2';
}
else if(count($dato_cli)==0){//No hay usuarios con estos datos
	$_SESSION['datos_'._ID_PAG_]['nuevapass']['hayerrores']=1;
	$lista_errores[]='np_correo';
}
else if($dato_cli[0]->us_estado==0){//El cliente no está activo
	$_SESSION['datos_'._ID_PAG_]['nuevapass']['hayerrores']=1;
	$lista_errores[]='activo';
}
else if($dato_cli[0]->us_idusuario==1||$dato_cli[0]->us_idusuario==720){//Es un usuario de pruebas
	$_SESSION['datos_'._ID_PAG_]['nuevapass']['hayerrores']=1;
	$lista_errores[]='pruebas';
}

$_SESSION['datos_'._ID_PAG_]['nuevapass']['lista_errores']=$lista_errores;

$_SESSION['datos_'._ID_PAG_]['nuevapass']['hayerrores']==1?fuera_de_aqui($url_dest):'';

$nuevapass=genera_pass(6);

$cod_pass=secure_md5($nuevapass);
$token_silent=encriptar($dato_cli[0]->us_correo.'%%'.$cod_pass);
query('update usuarios set us_pass="'.$cod_pass.'", us_accesosilent="'.$token_silent.'" where us_idusuario='.$dato_cli[0]->us_idusuario.'');

$asunto=u8_('Assistec - Nuevos datos de acceso');
$contenido='Estimado cliente, ha solicitado una nueva contrase&ntilde;a de acceso a nuestro cuadro de mando. Su nueva contrase&ntilde;a es: <strong>'.$nuevapass.'</strong><br>Recuerde respetar may&uacute;sculas; una vez haya accedido a la plataforma le recomendamos que cambie la contrase&ntilde;a por una que le resulte f&aacute;cil de recordar.<br><br>Gracias por confiar en nosotros.<br>El equipo de <strong>Assistec</strong>.';
ob_start(); # apertura de bufer
include( _ZEND_.'templates/mail_template_def.php' );
$cuerpo = ob_get_clean();
$altbody=u8_('Estimado cliente, ha solicitado una nueva contraseña de acceso a nuestro cuadro de mando. Su nueva contraseña es: '.$nuevapass.'
Recuerde respetar mayúsculas; una vez haya accedido al cuadro de mando le recomendamos que cambie la contraseña por una que le resulte fácil de recordar.

Gracias por confiar en nosotros.
El equipo de Assistec.');
	
enviar_email($dato_cli[0]->us_correo, $dato_cli[0]->us_correo, '', '', $asunto, $cuerpo, 'Cuadro de mando Assitec Online', 'web@assistec.es', '', '', '', '', '', '', '', $altbody);

fuera_de_aqui($url_dest);

?>