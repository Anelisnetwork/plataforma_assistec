<?php
$provincias=strip_tags($_POST['provincias']);

//echo 'SELECT prov_nombre from provincias where prov_idcp in ('.$provincias.')';exit;

$mostrar='';
if($provincias=='ALL'){
	$mostrar='TODAS';
}
else if($provincias!=''){
	$nombres=list_object('SELECT prov_nombre from provincias where prov_idcp in ('.$provincias.')');
	foreach($nombres as $key=>$nombre){
		$mostrar.=($key==0?'':', ').$nombre->prov_nombre;
	}
}

if($mostrar!=''){
	if(strlen($mostrar)>54){
		$mostrar='('.count(explode(',',$mostrar)).' seleccionadas) - '.u8_(substr($mostrar, 0, 50).'...');
	}
	else{
		$mostrar=u8_($mostrar);
	}
}
//$mostrar=$mostrar!=''?(strlen($mostrar)>54?(u8_(substr($mostrar, 0, 50).'...')):u8_($mostrar)):'';

echo $mostrar;
?>