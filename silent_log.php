<?php
require_once('core/core.php');

open_bd();

$_SESSION['datos_'._ID_PAG_]['sl_acceder']['hayerrores']=0;
$lista_errores=array();

$idtaller=clean_post('sl_tallerid');
$token=clean_post('sl_usrtoken');


//$idtaller=4;
//$token='32596f5af6883fd87e3ec702033e4932';

if($idtaller==''||$idtaller==0||$token==''){
	exit;
}

if(num_rows('select ta_idtaller from talleres where ta_idtaller='.$idtaller.'')!=1){
	$_SESSION['datos_'._ID_PAG_]['sl_acceder']['hayerrores']=1;
	$lista_errores[]='notaller';
	//exit('notaller');
}
else{
	$matriz=dato_taller('ta_idparent',$idtaller);

	if($matriz==0){//Red / Taller independiente
		if(num_rows('select ta_idtaller from talleres where ta_idtaller='.$idtaller.' and ta_log_token="'.$token.'"')!=1){
			$_SESSION['datos_'._ID_PAG_]['sl_acceder']['hayerrores']=1;
			$lista_errores[]='notoken';
			//exit('notoken');
		}
	}
	else{//Adherido
		if(num_rows('select ta_idtaller from talleres where ta_idtaller='.$matriz.' and ta_log_token="'.$token.'"')!=1){
			$_SESSION['datos_'._ID_PAG_]['sl_acceder']['hayerrores']=1;
			$lista_errores[]='notoken';
			//exit('notoken');
		}
	}
}


$_SESSION['datos_'._ID_PAG_]['sl_acceder']['hayerrores']==1?fuera_de_aqui(''):'';

$idusuario=fetch_array('select us_idusuario from usuarios where us_idtaller='.$idtaller.' and us_estado!=3 order by us_rango desc limit 0,1','us_idusuario');

if($idusuario==NULL||$idusuario==''){
	$_SESSION['datos_'._ID_PAG_]['sl_acceder']['hayerrores']=1;
	$lista_errores[]='nouser';
	//exit('nouser');
}

$_SESSION['datos_'._ID_PAG_]['sl_acceder']['hayerrores']==1?fuera_de_aqui(''):'';

$_SESSION['datos_'._ID_PAG_]['idusuario']=$idusuario;
datos_usuario($idusuario);

if($dato_cli[0]->us_idusuario==5&&$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']==0){
	$_SESSION['datos_'._ID_PAG_]['sl_acceder']['hayerrores']=1;
	unset($_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']);
	unset($_SESSION['datos_'._ID_PAG_]['datos_user']['contrato']);
	unset($_SESSION['datos_'._ID_PAG_]['datos_user']['idred']);
	unset($_SESSION['datos_'._ID_PAG_]['datos_user']['rango']);
	$lista_errores[]='activo';
}

$_SESSION['datos_'._ID_PAG_]['sl_acceder']['lista_errores']=$lista_errores;

fuera_de_aqui('');

?>