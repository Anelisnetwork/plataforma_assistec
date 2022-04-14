<?php
/*
$tags2 = array_keys($_POST);
foreach($tags2 as $tag){
	echo $tag.'<br>';
}
exit;
*/



$_SESSION['datos_'._ID_PAG_]['edita_promocion']['hayerrores']=0;
$_SESSION['datos_'._ID_PAG_]['edita_promocion']['mensaje']='Promoción guardada correctamente';

$url_dest=clean_post('url_dest');

$idpromo=clean_post('idpromocion');
$tipo=$idpromo=='NEW'?clean_post('tipo_'.$idpromo):fetch_array('select pr_tipo from promociones where pr_idpromocion='.$idpromo.'','pr_tipo');
$orden=$tipo==3?0:1;
$meses=$tipo==1?clean_post('meses_'.$idpromo):1;
$activa=$idpromo=='NEW'?1:clean_post('activa_'.$idpromo);
$desde=clean_post('desde_'.$idpromo);
$hasta=clean_post('hasta_'.$idpromo);
$titulo=clean_post('titulo_'.$idpromo);
$imagen=$_FILES['imagen_'.$idpromo];
$archivo=$tipo==3?$_FILES['archivo_'.$idpromo]:'';
//var_dump($imagen);
//echo '<br>';
$descripcion=addslashes(strip_tags($_POST['descripcion_'.$idpromo],'<a><b><i><p><u><font><br><div><span>'));

$n_imagen=$imagen['name'];
if($n_imagen!=''){
	$sep_pos=strrpos($n_imagen,'.');
	$extension=substr($n_imagen,$sep_pos+1);
	$dimensiones=getimagesize($imagen['tmp_name']);
	$ancho=$dimensiones[0];
	$alto=$dimensiones[1];
	$ratio=$ancho/$alto;
	//var_dump($dimensiones);
	//echo '<br>';
	if(!in_array(strtolower($extension),array('jpg','png','gif'))){
		//echo 'La extensión del archivo no es correcta.';exit;
		$_SESSION['datos_'._ID_PAG_]['edita_promocion']['hayerrores']=1;
		$_SESSION['datos_'._ID_PAG_]['edita_promocion']['mensaje']='La extensión de la imagen no es correcta. '.$extension;
		fuera_de_aqui($url_dest);
	}
	if($imagen['size']>300000){
		//echo 'El archivo no puede ser de más de 300Kb.';exit;
		$_SESSION['datos_'._ID_PAG_]['edita_promocion']['hayerrores']=1;
		$_SESSION['datos_'._ID_PAG_]['edita_promocion']['mensaje']='La imagen no puede ser de más de 300Kb.';
		fuera_de_aqui($url_dest);
	}
}

if($archivo!=''){
	$n_archivo=$archivo['name'];
	if($n_archivo!=''){
		$sep_pos=strrpos($n_archivo,'.');
		$extension=substr($n_archivo,$sep_pos+1);
		//$dimensiones=getimagesize($imagen['tmp_name']);
		//$ancho=$dimensiones[0];
		//$alto=$dimensiones[1];
		//$ratio=$ancho/$alto;
		//var_dump($dimensiones);
		//echo '<br>';
		if(!in_array(strtolower($extension),array('pdf'))){
			//echo 'La extensión del archivo no es correcta.';exit;
			$_SESSION['datos_'._ID_PAG_]['edita_promocion']['hayerrores']=1;
			$_SESSION['datos_'._ID_PAG_]['edita_promocion']['mensaje']='La extensión del archivo no es correcta. '.$extension;
			fuera_de_aqui($url_dest);
		}
		if($archivo['size']>3000000){
			//echo 'El archivo no puede ser de más de 300Kb.';exit;
			$_SESSION['datos_'._ID_PAG_]['edita_promocion']['hayerrores']=1;
			$_SESSION['datos_'._ID_PAG_]['edita_promocion']['mensaje']='El archivo no puede ser de más de 3Mb.';
			fuera_de_aqui($url_dest);
		}
	}
}
else{
	$n_archivo='';
}
//echo '<br><br>Todo OK.';
//exit;
$meses<1?$meses=1:'';
$activa==''?$activa=0:'';

if($idpromo=='NEW'){//NUEVA PROMOCIÓN
	if(!query('insert into promociones (pr_tipo, pr_activa, pr_desde, pr_hasta, pr_meses, pr_titulo, pr_descripcion, pr_imagen, pr_orden) values ('.$tipo.', '.$activa.', "'.$desde.' 00:00:00", "'.$hasta.' 23:59:59", '.$meses.', "'.u8_($titulo).'", "'.u8_($descripcion).'", "'.$n_imagen.'", '.$orden.')')){
		$_SESSION['datos_'._ID_PAG_]['edita_promocion']['hayerrores']=1;
		$_SESSION['datos_'._ID_PAG_]['edita_promocion']['mensaje']='No se ha podido crear la promoción.';
	}
	else{
		if($n_imagen!=''){
			//$ant_imagen='imagenes/promociones/'.fetch_array('select pr_imagen from promociones where pr_idpromocion='.$idpromo.'','pr_imagen');
			//SUBIMOS LA IMAGEN
			$uploaddir = 'imagenes/promociones/';
			$uploadfile1 = $uploaddir.basename($n_imagen);
			
			if (!move_uploaded_file($imagen['tmp_name'], $uploadfile1)) {
				//echo 'La imagen no ha podido guardarse.';exit;
				$_SESSION['datos_'._ID_PAG_]['edita_promocion']['hayerrores']=1;
				$_SESSION['datos_'._ID_PAG_]['edita_promocion']['mensaje']='La imagen no ha podido guardarse.';
				fuera_de_aqui($url_dest);
			}
			else{
				query('update promociones set pr_imagen="'.$n_imagen.'" where pr_idpromocion='.$idpromo.'');
			}
			//SUBIMOS LA IMAGEN
		}
		if($n_archivo!=''){
			//$ant_imagen='imagenes/promociones/'.fetch_array('select pr_imagen from promociones where pr_idpromocion='.$idpromo.'','pr_imagen');
			//SUBIMOS LA IMAGEN
			$uploaddir = 'archivos/promociones/';
			$uploadfile1 = $uploaddir.basename($n_archivo);
			
			if (!move_uploaded_file($archivo['tmp_name'], $uploadfile1)) {
				//echo 'El archivo no ha podido guardarse.';exit;
				$_SESSION['datos_'._ID_PAG_]['edita_promocion']['hayerrores']=1;
				$_SESSION['datos_'._ID_PAG_]['edita_promocion']['mensaje']='El archivo no ha podido guardarse.';
				fuera_de_aqui($url_dest);
			}
			else{
				query('update promociones set pr_archivo="'.$n_archivo.'" where pr_idpromocion='.$idpromo.'');
			}
			//SUBIMOS LA IMAGEN
		}
	}
}//NUEVA PROMOCIÓN
else{//EDITAMOS PROMOCIÓN
	if(!query('update promociones set pr_activa='.$activa.', pr_desde="'.$desde.' 00:00:00", pr_hasta="'.$hasta.' 23:59:59", pr_meses='.$meses.', pr_titulo="'.u8_($titulo).'", pr_descripcion="'.u8_($descripcion).'" where pr_idpromocion='.$idpromo.'')){
		$_SESSION['datos_'._ID_PAG_]['edita_promocion']['hayerrores']=1;
		$_SESSION['datos_'._ID_PAG_]['edita_promocion']['mensaje']='No se ha podido modificar la promoción.';
	}
	else{
		if($n_imagen!=''){
			$ant_imagen='imagenes/promociones/'.fetch_array('select pr_imagen from promociones where pr_idpromocion='.$idpromo.'','pr_imagen');
			//SUBIMOS LA IMAGEN
			$uploaddir = 'imagenes/promociones/';
			$uploadfile1 = $uploaddir.basename($n_imagen);
			
			if (!move_uploaded_file($imagen['tmp_name'], $uploadfile1)) {
				//echo 'La imagen no ha podido guardarse.';exit;
				$_SESSION['datos_'._ID_PAG_]['edita_promocion']['hayerrores']=1;
				$_SESSION['datos_'._ID_PAG_]['edita_promocion']['mensaje']='La imagen no ha podido guardarse.';
				fuera_de_aqui($url_dest);
			}
			else{
				if(query('update promociones set pr_imagen="'.$n_imagen.'" where pr_idpromocion='.$idpromo.'')){
					unlink($ant_imagen);
				}
			}
			//SUBIMOS LA IMAGEN
		}
		if($n_archivo!=''){
			$ant_archivo='archivos/promociones/'.fetch_array('select pr_archivo from promociones where pr_idpromocion='.$idpromo.'','pr_archivo');
			//SUBIMOS LA IMAGEN
			$uploaddir = 'archivos/promociones/';
			$uploadfile1 = $uploaddir.basename($n_archivo);
			
			if (!move_uploaded_file($archivo['tmp_name'], $uploadfile1)) {
				//echo 'La imagen no ha podido guardarse.';exit;
				$_SESSION['datos_'._ID_PAG_]['edita_promocion']['hayerrores']=1;
				$_SESSION['datos_'._ID_PAG_]['edita_promocion']['mensaje']='El archivo no ha podido guardarse.';
				fuera_de_aqui($url_dest);
			}
			else{
				if(query('update promociones set pr_archivo="'.$n_archivo.'" where pr_idpromocion='.$idpromo.'')){
					unlink($ant_archivo);
				}
			}
			//SUBIMOS LA IMAGEN
		}
	}
}//EDITAMOS PROMOCIÓN

fuera_de_aqui($url_dest);

?>