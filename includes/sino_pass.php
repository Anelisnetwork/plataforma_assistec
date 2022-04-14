<?php
$mensaje='';
$imagen='';
$val='1';

$valor=clean_post('valor');

if($valor!=''){
	if(strlen($valor)<6){
		$mensaje='Debe tener al menos 6 caracteres';
		$imagen='no';
		$val='0';
	}
	else if(!formato_pass($valor)){
		$mensaje='La contraseña puede contener letras (mayúsculas y minúsculas), números, guiones y los caracteres @, $, y &';
		$imagen='no';
		$val='0';
	}
	else{
		$mensaje='Valor correcto';
		$imagen='si';
		$val='1';
	}
}

?>

<div>
	<div id="valor"><?=$val?></div>
	<div id="imagen">
		<?=$mensaje==''?'':'<img class="sino" title="'.$mensaje.'" src="'._RAIZ_.'imagenes/'.$imagen.'.png" />'?>
	</div>
</div>