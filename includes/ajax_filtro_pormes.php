<?php
$meses=strip_tags($_POST['meses']);
$anho=strip_tags($_POST['anho']);

$mostrar='<strong>Seleccionado:</strong> Año '.$anho;
$lista_meses=explode(',',$meses);

if(count($lista_meses)==12){
	$mostrar.=' (completo)';
}
else{
	foreach($lista_meses as $key=>$mes){
		$mostrar.=($key==0?' (':', ').ucwords(nombremes($anho.'-'.$mes.'-01','ES'));
	}
	$mostrar.=')';
}


if(strlen($mostrar)>124){
	$mostrar=substr($mostrar, 0, 120).'...';
}

//$mostrar=$mostrar!=''?(strlen($mostrar)>54?(u8_(substr($mostrar, 0, 50).'...')):u8_($mostrar)):'';

echo $mostrar;
?>