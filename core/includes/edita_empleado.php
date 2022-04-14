<?php

$_SESSION['datos_'._ID_PAG_]['edita_empleado']['hayerrores']=0;

$url_dest=clean_post('url_dest');

$id_empleado=clean_post('idempleado');

$id_taller=clean_post('idtaller');

$funciones=array();

$nombre=$_SESSION['datos_'._ID_PAG_]['edita_empleado']['nombre_'.$id_empleado]=clean_post('nombre_'.$id_empleado);
$jornada=$_SESSION['datos_'._ID_PAG_]['edita_empleado']['jornada_'.$id_empleado]=clean_post('jornada_'.$id_empleado);
$notas=$_SESSION['datos_'._ID_PAG_]['edita_empleado']['notas_'.$id_empleado]=clean_post('notas_'.$id_empleado);

for($n=1; $n<=4; $n++){
	${'funcion'.$n}=$_SESSION['datos_'._ID_PAG_]['edita_empleado']['funcion_'.$n.'_'.$id_empleado]=clean_post('funcion_'.$n.'_'.$id_empleado);
	${'porcent'.$n}=$_SESSION['datos_'._ID_PAG_]['edita_empleado']['porcent_'.$n.'_'.$id_empleado]=${'funcion'.$n}==''?0:clean_post('porcent_'.$n.'_'.$id_empleado);
	${'funcion'.$n}!=''&&${'porcent'.$n}!=0?$funciones[]=array('funcion'=>${'funcion'.$n}, 'porcentaje'=>${'porcent'.$n}):'';
}

$nombre==''?$_SESSION['datos_'._ID_PAG_]['edita_empleado']['hayerrores']=1:'';
$jornada==''||$jornada==0||!is_numeric($jornada)?$_SESSION['datos_'._ID_PAG_]['edita_empleado']['hayerrores']=1:'';
($porcent1+$porcent2+$porcent3+$porcent4)!=100?$_SESSION['datos_'._ID_PAG_]['edita_empleado']['hayerrores']=1:'';

if($_SESSION['datos_'._ID_PAG_]['edita_empleado']['hayerrores']==0){
	if($id_empleado=='NEW'){//Creamos nuevo
		query('insert into personal_taller (pt_idtaller, pt_nombre, pt_jornada, pt_notas) values ("'.$id_taller.'", "'.u8_($nombre).'", "'.$jornada.'", "'.u8_($notas).'")');
		$id_empleado=insertado();
	}
	else{//Editamos empleado
		query('update personal_taller set pt_nombre="'.u8_($nombre).'", pt_jornada="'.$jornada.'", pt_notas="'.u8_($notas).'" where pt_idpersonal='.$id_empleado.'');
		query('delete from personal_funciones where pf_idpersonal='.$id_empleado.'');
	}
	
	foreach($funciones as $funcion){
		//echo 'insert into personal_funciones (pf_idpersonal, pf_idcargo, pf_porcentaje) values ("'.$id_empleado.'", "'.$funcion['funcion'].'", "'.$funcion['porcentaje'].'")'.'<br>';
		query('insert into personal_funciones (pf_idpersonal, pf_idcargo, pf_porcentaje) values ("'.$id_empleado.'", "'.$funcion['funcion'].'", "'.$funcion['porcentaje'].'")');
	}
}

fuera_de_aqui($url_dest);

?>