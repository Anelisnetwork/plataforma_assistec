<?php

$_SESSION['datos_'._ID_PAG_]['edita_equipamiento']['hayerrores']=0;

$url_dest=clean_post('url_dest');

$id_equip=clean_post('idequipo');

$id_taller=clean_post('idtaller');

$tipo=$_SESSION['datos_'._ID_PAG_]['edita_equipamiento']['tipo_'.$id_equip]=clean_post('tipo_'.$id_equip);
$cantidad=$_SESSION['datos_'._ID_PAG_]['edita_equipamiento']['cantidad_'.$id_equip]=intval(clean_post('cantidad_'.$id_equip));
$notas=$_SESSION['datos_'._ID_PAG_]['edita_equipamiento']['notas_'.$id_equip]=clean_post('notas_'.$id_equip);

!is_numeric($cantidad)||!is_int($cantidad)||$cantidad<=0||$cantidad>100||$cantidad==''?$_SESSION['datos_'._ID_PAG_]['edita_equipamiento']['hayerrores']=1:'';

if($_SESSION['datos_'._ID_PAG_]['edita_equipamiento']['hayerrores']==0){
	if($id_equip=='NEW'){//Creamos nuevo
		query('insert into equipamiento_taller (et_idtaller, et_idtipo, et_cantidad, et_notas) values ("'.$id_taller.'", "'.$tipo.'", "'.$cantidad.'", "'.u8_($notas).'")');
	}
	else{//Editamos equipamiento
		query('update equipamiento_taller set et_idtipo="'.$tipo.'", et_cantidad="'.$cantidad.'", et_notas="'.u8_($notas).'" where et_idequip='.$id_equip.'');
	}
}

fuera_de_aqui($url_dest);

?>