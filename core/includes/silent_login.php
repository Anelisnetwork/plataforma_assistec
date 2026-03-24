<?php

$_SESSION['datos_'._ID_PAG_]['acceder']['hayerrores']=0;
$lista_errores=array();

$datos=clean_get('login');

if($datos==''){
    $_SESSION['datos_'._ID_PAG_]['acceder']['hayerrores']=1;
    $lista_errores[]='sin_datos';
    goto end;
}

//$datos=encriptar('pruebas%%jk&y@FF6');
//echo $datos;exit;
$datos=explode('%%',desencriptar($datos));
//vd__($datos);exit;
$url_dest='';

if(count($datos)!=2){
    $_SESSION['datos_'._ID_PAG_]['acceder']['hayerrores']=1;
    $lista_errores[]='datos_erroneos';
    goto end;
}

$email=$_SESSION['datos_'._ID_PAG_]['acceder']['astc_email']=$datos[0];
$password=$_SESSION['datos_'._ID_PAG_]['acceder']['astc_pass']=$datos[1];

if($_SESSION['datos_'._ID_PAG_]['acceder']['astc_email']==''){
	$_SESSION['datos_'._ID_PAG_]['acceder']['hayerrores']=1;
	$lista_errores[]='no_email';
}
if($_SESSION['datos_'._ID_PAG_]['acceder']['astc_pass']==''){
	$_SESSION['datos_'._ID_PAG_]['acceder']['hayerrores']=1;
	$lista_errores[]='no_pass';
}

$dato_cli=list_object("select us_idusuario, us_pass, us_estado from usuarios where (us_correo='{$email}' OR us_nick='{$email}')");

if(count($dato_cli)>1){//Hay más de 1 usuario con estos datos
	$_SESSION['datos_'._ID_PAG_]['acceder']['hayerrores']=1;
	$lista_errores[]='astc_email2';
}
else if(count($dato_cli)==0){//No hay usuarios con estos datos
	$_SESSION['datos_'._ID_PAG_]['acceder']['hayerrores']=1;
	$lista_errores[]='astc_email';
}
else{//Hay un cliente con ese correo
	if($dato_cli[0]->us_pass!=secure_md5($password)){//La contraseña no coincide
		$_SESSION['datos_'._ID_PAG_]['acceder']['hayerrores']=1;
		$lista_errores[]='astc_pass';
	}
	else if($dato_cli[0]->us_estado==0){//El cliente no está activo
		$_SESSION['datos_'._ID_PAG_]['acceder']['hayerrores']=1;
		$lista_errores[]='activo';
	}
}
//vd__($lista_errores);exit;
$_SESSION['datos_'._ID_PAG_]['acceder']['lista_errores']=$lista_errores;

$_SESSION['datos_'._ID_PAG_]['acceder']['hayerrores']==1?fuera_de_aqui($url_dest):'';

$_SESSION['datos_'._ID_PAG_]['idusuario']=$dato_cli[0]->us_idusuario;

datos_usuario($dato_cli[0]->us_idusuario);

if($dato_cli[0]->us_idusuario!=5&&$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']==0){
	$_SESSION['datos_'._ID_PAG_]['acceder']['hayerrores']=1;
	unset($_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']);
	unset($_SESSION['datos_'._ID_PAG_]['datos_user']['contrato']);
	unset($_SESSION['datos_'._ID_PAG_]['datos_user']['idred']);
	unset($_SESSION['datos_'._ID_PAG_]['datos_user']['rango']);
	$lista_errores[]='activo';
}

end:
fuera_de_aqui($url_dest);