<?php

$_SESSION['datos_'._ID_PAG_]['datos_generales']['hayerrores']=0;

$url_dest=clean_post('url_dest');

$id_taller=clean_post('idtaller');

$nomcom=$_SESSION['datos_'._ID_PAG_]['datos_generales']['nomcom_'.$id_taller]=clean_post('nomcom_'.$id_taller);
$direccion=$_SESSION['datos_'._ID_PAG_]['datos_generales']['direccion_'.$id_taller]=clean_post('direccion_'.$id_taller);
$cp=$_SESSION['datos_'._ID_PAG_]['datos_generales']['cp_'.$id_taller]=clean_post('cp_'.$id_taller);
$localidad=$_SESSION['datos_'._ID_PAG_]['datos_generales']['localidad_'.$id_taller]=clean_post('localidad_'.$id_taller);
$provincia=$_SESSION['datos_'._ID_PAG_]['datos_generales']['provincia_'.$id_taller]=clean_post('provincia_'.$id_taller);
$telefono=$_SESSION['datos_'._ID_PAG_]['datos_generales']['telefono_'.$id_taller]=limpia_tlf(clean_post('telefono_'.$id_taller));
$movil=$_SESSION['datos_'._ID_PAG_]['datos_generales']['movil_'.$id_taller]=limpia_tlf(clean_post('movil_'.$id_taller));
$correo=$_SESSION['datos_'._ID_PAG_]['datos_generales']['correo_'.$id_taller]=clean_post('correo_'.$id_taller);
$contacto=$_SESSION['datos_'._ID_PAG_]['datos_generales']['contacto_'.$id_taller]=clean_post('contacto_'.$id_taller);

$nomcom==''||$direccion==''||$cp==''||$localidad==''||$provincia==''||$telefono==''||$movil==''||$correo==''||$contacto==''||!VerificarDireccionCorreo($correo)?$_SESSION['datos_'._ID_PAG_]['datos_generales']['hayerrores']=1:'';

if($_SESSION['datos_'._ID_PAG_]['datos_generales']['hayerrores']==0){
	query('update talleres set ta_nombre="'.u8_($nomcom).'", ta_contacto="'.u8_($contacto).'", ta_telefono1="'.$telefono.'", ta_telefono2="'.$movil.'", ta_email="'.$correo.'", ta_direccion="'.u8_($direccion).'", ta_cp="'.$cp.'", ta_localidad="'.u8_($localidad).'", ta_provincia="'.u8_($provincia).'" where ta_idtaller='.$id_taller.'');
}

fuera_de_aqui($url_dest);

?>