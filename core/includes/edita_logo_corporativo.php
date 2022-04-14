<?php
$_SESSION['proceso']['guardar_logotipo']['resultado']='OK';
$_SESSION['proceso']['guardar_logotipo']['mensaje']='Datos guardados correctamente';

$url_dest=clean_post('url_dest');
$idtaller=clean_post('idtaller');

$archivo=$_FILES['logo_corp']['tmp_name'];
$size=$_FILES['logo_corp']['size'];
$fichero=$_FILES['logo_corp']['name'];
$tipo=$_FILES['logo_corp']['type'];
$guardalogo=false;

if($archivo!=''){
    $extensiones_permitidas=array('jpg','jpeg','png');
    $guardalogo=true;
    if($size>500000){// Permitimos hasta 500Kb
        $guardalogo=false;
        $_SESSION['proceso']['guardar_logotipo']['resultado']='KO';
        $_SESSION['proceso']['guardar_logotipo']['mensaje']='El tamaño de la imagen no puedes ser superior a 500Kb';
    }
    $tipo=explode('/',$tipo);
    $extension=strtolower($tipo[1]);
    if($tipo[0]!='image'){
        $guardalogo=false;
        $_SESSION['proceso']['guardar_logotipo']['resultado']='KO';
        $_SESSION['proceso']['guardar_logotipo']['mensaje']='El logotipo debe ser una imagen';
    }
    if(!in_array($extension,$extensiones_permitidas)){
        $guardalogo=false;
        $_SESSION['proceso']['guardar_logotipo']['resultado']='KO';
        $_SESSION['proceso']['guardar_logotipo']['mensaje']='La extensión del archivo no es válida, las extensiones permitidas son: '.implode(',',$extensiones_permitidas);
    }
}

if($guardalogo){
    $nombre_logo=$idtaller.'.'.$extension;
    $destino_logo = _PATH_.'imagenes/talleres/logotipos/'.$nombre_logo;
    $q=query("UPDATE talleres SET ta_logotipo='{$nombre_logo}' WHERE ta_idtaller='{$idtaller}'");
    move_uploaded_file( $archivo, $destino_logo);
}
fuera_de_aqui($url_dest);