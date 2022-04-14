<?php
$mensaje='Complete este campo';
$imagen='no';
$val='0';

$valor=clean_post('valor');

if($valor!=''){
	if(!VerificarDireccionCorreo($valor)){
		$mensaje='No es una dirección de correo válida';
		$imagen='no';
		$val='0';
	}
	else{
		$cuantos=num_rows('select us_idusuario from usuarios where us_correo="'.$valor.'"');
		if($cuantos!=0){
			$mensaje='Ese correo ya está siendo utilizado';
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