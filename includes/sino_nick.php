<?php
$mensaje='';
$imagen='';
$val='1';

$valor=clean_post('valor');

if($valor!=''){
	if(strlen($valor)<5){
		$mensaje='Debe tener al menos 5 caracteres';
		$imagen='no';
		$val='0';
	}
	else{
		$cuantos=num_rows('select us_idusuario from usuarios where us_nick="'.$valor.'"');
		if($cuantos!=0){
			$mensaje='Ese nick ya está siendo utilizado';
			$imagen='no';
			$val='0';
		}
		else{
			$mensaje='Valor correcto';
			$imagen='si';
			$val='1';
		}
	}
}

?>

<div>
	<div id="valor"><?=$val?></div>
	<div id="imagen">
		<?=$mensaje==''?'':'<img class="sino" title="'.$mensaje.'" src="'._RAIZ_.'imagenes/'.$imagen.'.png" />'?>
	</div>
</div>