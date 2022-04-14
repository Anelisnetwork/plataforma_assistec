<?php

$_SESSION['datos_'._ID_PAG_]['edita_usuario']['hayerrores']=0;

$url_dest=clean_post('url_dest');

$idusu=clean_post('idusuario');

$estado=$_SESSION['datos_'._ID_PAG_]['edita_usuario']['estado_'.$idusu]=clean_post('estado_'.$idusu);

if($_SESSION['datos_'._ID_PAG_]['edita_usuario']['hayerrores']==0){
	if(!query("update usuarios set us_estado='{$estado}' where us_idusuario='{$idusu}'")){
		$_SESSION['datos_'._ID_PAG_]['edita_usuario']['hayerrores']=1;
	}
	else if($estado==3){//Lo estamos desactivando
        query("update usuarios set us_fecha_baja='".date('Y-m-d H:i:s')."' where us_idusuario='{$idusu}'");
    }
}

fuera_de_aqui($url_dest);

?>