<?php

$conf_modulos=array(
	'login'=>array(
		'layout'=>'login',
	)
);

$modulos=array('login');

open_bd();

if(isset($_SESSION['datos_'._ID_PAG_]['datos_user']['rango'])){
	$modulos=array();
	$inactivos=array();
	$lista_pages=list_object('select modulos.* from modulos, rangos_usuario where find_in_set (mo_idmodulo, ru_acceso_mod) and ru_idrango='.$_SESSION['datos_'._ID_PAG_]['datos_user']['rango'].' order by mo_orden asc, mo_url asc');
	foreach($lista_pages as $key=>$npage){
		if($_SESSION['datos_'._ID_PAG_]['datos_user']['rango']==3&&$_SESSION['datos_'._ID_PAG_]['datos_user']['idred']!=0&&$npage->mo_url=='facturacion'){
			unset($lista_pages[$key]);
		}
		else{
			$modulos[]=$npage->mo_url;
			$conf_modulos[$npage->mo_url]=array('layout'=>$npage->mo_layout,);
		}
	}
	$mod_inact=list_object('select modulos.* from modulos, rangos_usuario where find_in_set (mo_idmodulo, ru_mod_inac) and ru_idrango='.$_SESSION['datos_'._ID_PAG_]['datos_user']['rango'].'');
	foreach($mod_inact as $inactivo){
		$inactivos[]=$inactivo->mo_url;
	}
}

$m=isset($_GET['module'])&&in_array(clean_get('module'),$modulos)&&!in_array(clean_get('module'),$inactivos)?clean_get('module'):_DEFAULT_MODULE_;

$m=_TIPO_ACCESO_=='USERS'?comprueba_acceso($m,_DEFAULT_MODULE_):$m;



$layout=array_key_exists($m,$conf_modulos)?(array_key_exists('layout',$conf_modulos[$m])?$conf_modulos[$m]['layout']:$conf_modulos[_DEFAULT_MODULE_]['layout']):$conf_modulos[_DEFAULT_MODULE_]['layout'];

if($m!='login') {
    $secciones = dame_secciones($m);


    $seccion = isset($_GET['seccion']) ? clean_get('seccion') : '';

    $seccion = comprueba_seccion($m, $seccion);

    $seccion = $seccion == '' && count($secciones) != 0 ? $secciones[0]->sc_url : $seccion;
}

$seccNoMenu=array('emitir_factura','editar_factura');
//echo '<br>';var_dump ($secciones);

close_bd();
?>