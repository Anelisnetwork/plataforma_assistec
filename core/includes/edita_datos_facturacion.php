<?php

$_SESSION['datos_'._ID_PAG_]['datos_facturacion']['hayerrores']=0;

$url_dest=clean_post('url_dest');

$id_dir=clean_post('iddir');

$nomcomf=$_SESSION['datos_'._ID_PAG_]['datos_facturacion']['nomcomf_'.$id_dir]=clean_post('nomcomf_'.$id_dir);
$razsoc=$_SESSION['datos_'._ID_PAG_]['datos_facturacion']['razsoc_'.$id_dir]=clean_post('razsoc_'.$id_dir);
$nifcif=$_SESSION['datos_'._ID_PAG_]['datos_facturacion']['nifcif_'.$id_dir]=limpia_nifcif(clean_post('nifcif_'.$id_dir));
$direccionf=$_SESSION['datos_'._ID_PAG_]['datos_facturacion']['direccionf_'.$id_dir]=clean_post('direccionf_'.$id_dir);
$cpf=$_SESSION['datos_'._ID_PAG_]['datos_facturacion']['cpf_'.$id_dir]=clean_post('cpf_'.$id_dir);
$localidadf=$_SESSION['datos_'._ID_PAG_]['datos_facturacion']['localidadf_'.$id_dir]=clean_post('localidadf_'.$id_dir);
$provinciaf=$_SESSION['datos_'._ID_PAG_]['datos_facturacion']['provinciaf_'.$id_dir]=clean_post('provinciaf_'.$id_dir);
$telefonof=$_SESSION['datos_'._ID_PAG_]['datos_facturacion']['telefonof_'.$id_dir]=limpia_tlf(clean_post('telefonof_'.$id_dir));
$movilf=$_SESSION['datos_'._ID_PAG_]['datos_facturacion']['movilf_'.$id_dir]=limpia_tlf(clean_post('movilf_'.$id_dir));
$correof=$_SESSION['datos_'._ID_PAG_]['datos_facturacion']['correof_'.$id_dir]=clean_post('correof_'.$id_dir);
$contactof=$_SESSION['datos_'._ID_PAG_]['datos_facturacion']['contactof_'.$id_dir]=clean_post('contactof_'.$id_dir);
$observaciones=$_SESSION['datos_'._ID_PAG_]['datos_facturacion']['observaciones_'.$id_dir]=clean_post('observaciones_'.$id_dir);

$razsoc==''||$nifcif==''||$direccionf==''||$cpf==''||$localidadf==''||$provinciaf==''||$telefonof==''||$movilf==''||$correof==''||$contactof==''||!VerificarDireccionCorreo($correof)?$_SESSION['datos_'._ID_PAG_]['datos_facturacion']['hayerrores']=1:'';

if($_SESSION['datos_'._ID_PAG_]['datos_facturacion']['hayerrores']==0){
	query('update usuarios_facturacion set uf_denomsoc="'.u8_($razsoc).'", uf_cifnif="'.$nifcif.'", uf_nomcom="'.u8_($nomcomf).'", uf_contacto="'.u8_($contactof).'", uf_telefono1="'.$telefonof.'", uf_telefono2="'.$movilf.'", uf_email="'.$correof.'", uf_direccion="'.u8_($direccionf).'", uf_cp="'.$cpf.'", uf_localidad="'.u8_($localidadf).'", uf_provincia="'.u8_($provinciaf).'", uf_observaciones="'.u8_($observaciones).'" where uf_iddir='.$id_dir.'');
}

fuera_de_aqui($url_dest);

?>