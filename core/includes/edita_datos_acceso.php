<?php

$_SESSION['datos_'._ID_PAG_]['datos_acceso']['hayerrores']=0;

$url_dest=clean_post('url_dest');

$idusu=clean_post('idusuario');
$pass1=clean_post('accpass_'.$idusu);
$pass2=clean_post('accpass2_'.$idusu);
$pass3=clean_post('accpass3_'.$idusu);

if($idusu!=1&&$idusu!=720){//No es usuario de pruebas
	if($pass1!=''){
		$_SESSION['datos_'._ID_PAG_]['datos_acceso']['hayerrorespass']=0;
		
		!formato_pass($pass1)||strlen($pass1)<6||$pass1!=$pass2?$_SESSION['datos_'._ID_PAG_]['datos_acceso']['hayerrorespass']=1:'';
		
		secure_md5($pass3)!=dame_dato_usuario('us_pass', $idusu)?$_SESSION['datos_'._ID_PAG_]['datos_acceso']['hayerrorespass']=1:'';
		$correo=dame_dato_usuario('us_correo', $idusu);
		if($_SESSION['datos_'._ID_PAG_]['datos_acceso']['hayerrorespass']==0){
            $token_silent=encriptar($correo.'%%'.$pass1);
			query('update usuarios set us_pass="'.secure_md5($pass1).'", us_accesosilent="'.$token_silent.'" where us_idusuario='.$idusu.'');
		}
	}
	
	$alias=$_SESSION['datos_'._ID_PAG_]['datos_acceso']['alias_'.$idusu]=clean_post('alias_'.$idusu);
	$aliasrepe=num_rows('select us_nick from usuarios where us_nick="'.$alias.'" and us_idusuario!='.$idusuario.'');
	$acccorreo=$_SESSION['datos_'._ID_PAG_]['datos_acceso']['acccorreo_'.$idusu]=clean_post('acccorreo_'.$idusu);
	$correorepe=num_rows('select us_correo from usuarios where us_correo="'.$acccorreo.'" and us_idusuario!='.$idusuario.'');
	
	if($aliasrepe>0||$correorepe>0){
		$_SESSION['datos_'._ID_PAG_]['datos_acceso']['hayerrores']=1;
		$_SESSION['datos_'._ID_PAG_]['datos_acceso']['mensaje']='El Alias y/o correo ya existen';
	}
	
	strlen($alias)<5||!VerificarDireccionCorreo($acccorreo)||$idusu!=$_SESSION['datos_'._ID_PAG_]['idusuario']?$_SESSION['datos_'._ID_PAG_]['datos_acceso']['hayerrores']=1:'';

    $passw=dame_dato_usuario('us_pass', $idusu);
	if($_SESSION['datos_'._ID_PAG_]['datos_acceso']['hayerrores']==0){
        $token_silent=encriptar($acccorreo.'%%'.$passw);
		query('update usuarios set us_nick="'.u8_($alias).'", us_correo="'.$acccorreo.'", us_accesosilent="'.$token_silent.'" where us_idusuario='.$idusu.'');
	}
}
else{
	$_SESSION['datos_'._ID_PAG_]['datos_acceso']['hayerrores']=1;
	$_SESSION['datos_'._ID_PAG_]['datos_acceso']['mensaje']='Este es un usuario de pruebas, no se pueden modificar los datos de acceso.';
}
fuera_de_aqui($url_dest);

?>