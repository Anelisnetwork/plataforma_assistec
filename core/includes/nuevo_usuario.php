<?php

$_SESSION['datos_'._ID_PAG_]['nuevo_usuario']['hayerrores']=0;

$url_dest=clean_post('url_dest');

$idusu=clean_post('idusuario');

$rango=$_SESSION['datos_'._ID_PAG_]['nuevo_usuario']['rango_'.$idusu]=clean_post('rango_'.$idusu);
$taller=$_SESSION['datos_'._ID_PAG_]['nuevo_usuario']['taller_'.$idusu]=clean_post('taller_'.$idusu);
$red=$_SESSION['datos_'._ID_PAG_]['nuevo_usuario']['red_'.$idusu]=clean_post('red_'.$idusu);
$estado=$_SESSION['datos_'._ID_PAG_]['nuevo_usuario']['estado_'.$idusu]=clean_post('estado_'.$idusu);
$nick=$_SESSION['datos_'._ID_PAG_]['nuevo_usuario']['nick_'.$idusu]=clean_post('nick_'.$idusu);
$correo=$_SESSION['datos_'._ID_PAG_]['nuevo_usuario']['correo_'.$idusu]=clean_post('correo_'.$idusu);
$pass=$_SESSION['datos_'._ID_PAG_]['nuevo_usuario']['pass_'.$idusu]=clean_post('pass_'.$idusu);

$haynick=$nick!=''?num_rows('select us_idusuario from usuarios where us_nick="'.$nick.'"'):0;
$haycorreo=num_rows('select us_idusuario from usuarios where us_correo="'.$correo.'"');

!formato_pass($pass)||strlen($pass)<6?$pass='':'';
$pass==''?$pass=genera_pass(6):'';
$passmod=secure_md5($pass);

if($rango==2){//Administrador
	$taller=0;
	$tipotaller=2;
	$idtaller=$red;
}
else if($rango==3){//Estandar
	$red=0;
	$tipotaller=1;
	$idtaller=$taller;
}
else{
	$tipotaller=0;
	$idtaller=0;
	$_SESSION['datos_'._ID_PAG_]['nuevo_usuario']['hayerrores']=1;
	$_SESSION['datos_'._ID_PAG_]['nuevo_usuario']['mensaje']='Los datos indicados no son correctos';
}

$haytaller=num_rows('select ta_idtaller from talleres where ta_idtaller="'.$idtaller.'" and ta_idtipo='.$tipotaller.'');



if($haytaller==0){
	$_SESSION['datos_'._ID_PAG_]['nuevo_usuario']['hayerrores']=1;
	$_SESSION['datos_'._ID_PAG_]['nuevo_usuario']['mensaje']='El taller/red seleccionado no es correcto';
}
if($haynick!=0||($nick!=''&&strlen($nick)<5)){
	$_SESSION['datos_'._ID_PAG_]['nuevo_usuario']['hayerrores']=1;
	$_SESSION['datos_'._ID_PAG_]['nuevo_usuario']['mensaje']='El nick indicado no es válido';
}
if($haycorreo!=0){
	$_SESSION['datos_'._ID_PAG_]['nuevo_usuario']['hayerrores']=1;
	$_SESSION['datos_'._ID_PAG_]['nuevo_usuario']['mensaje']='El correo indicado no es válido';
}

$token_silent=encriptar($correo.'%%'.$passmod);

if($_SESSION['datos_'._ID_PAG_]['nuevo_usuario']['hayerrores']==0){
	if(!query('insert into usuarios (us_idtaller, us_nick, us_correo, us_pass, us_fecha_alta, us_rango, us_estado, us_accesosilent) values ('.$idtaller.', "'.$nick.'", "'.$correo.'", "'.$passmod.'", "'.date('Y-m-d H:i:s').'", "'.$rango.'", "'.$estado.'", "'.$token_silent.'")')){
		$_SESSION['datos_'._ID_PAG_]['nuevo_usuario']['hayerrores']=1;
	}
}

fuera_de_aqui($url_dest);

?>