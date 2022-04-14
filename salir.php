<?php

require_once('core/core.php');

if(isset($_GET['error'])&&clean_get('error')=='noscript'){
	//echo 'hola';
	$_SESSION['datos_'._ID_PAG_]['acceder']['hayerrores']=1;
	$_SESSION['datos_'._ID_PAG_]['acceder']['lista_errores'][]='noscript';
}

unset($_SESSION['datos_'._ID_PAG_]['idusuario']);
$_SESSION['datos_'._ID_PAG_]['n_errores']=0;
fuera_de_aqui();

?>