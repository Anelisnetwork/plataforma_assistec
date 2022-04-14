<?php

$_SESSION['datos_'._ID_PAG_]['edita_info']['hayerrores']=0;

$url_dest=clean_post('url_dest');

$id_taller=clean_post('idtaller');

$pvpmo=$_SESSION['datos_'._ID_PAG_]['edita_info']['pvpmo_'.$id_taller]=clean_post('pvpmo_'.$id_taller);
$pvpmo==''?$pvpmo=0:null;
$hconvenio=$_SESSION['datos_'._ID_PAG_]['edita_info']['hconvenio_'.$id_taller]=clean_post('hconvenio_'.$id_taller);
$hconvenio==''?$hconvenio=0:null;
$vstock=$_SESSION['datos_'._ID_PAG_]['edita_info']['vstock_'.$id_taller]=clean_post('vstock_'.$id_taller);
$vstock==''?$vstock=0:null;
$parking=$_SESSION['datos_'._ID_PAG_]['edita_info']['parking_'.$id_taller]=clean_post('parking_'.$id_taller);
$parking==''?$parking=0:null;
$sustit=$_SESSION['datos_'._ID_PAG_]['edita_info']['sustit_'.$id_taller]=clean_post('sustit_'.$id_taller);
$sustit==''?$sustit=0:null;
$clitot=$_SESSION['datos_'._ID_PAG_]['edita_info']['clitot_'.$id_taller]=clean_post('clitot_'.$id_taller);
$clitot==''?$clitot=0:null;
$clivisit=$_SESSION['datos_'._ID_PAG_]['edita_info']['clivisit_'.$id_taller]=clean_post('clivisit_'.$id_taller);
$clivisit==''?$clivisit=0:null;
$clinuevos=$_SESSION['datos_'._ID_PAG_]['edita_info']['clinuevos_'.$id_taller]=clean_post('clinuevos_'.$id_taller);
$clinuevos==''?$clinuevos=0:null;
$dms=$_SESSION['datos_'._ID_PAG_]['edita_info']['dms_'.$id_taller]=clean_post('dms_'.$id_taller)==''?0:clean_post('dms_'.$id_taller);
$dmsprov=$_SESSION['datos_'._ID_PAG_]['edita_info']['dmsprov_'.$id_taller]=clean_post('dmsprov_'.$id_taller);
$fichan=$_SESSION['datos_'._ID_PAG_]['edita_info']['fichan_'.$id_taller]=clean_post('fichan_'.$id_taller)==''?0:clean_post('fichan_'.$id_taller);
$fichancomo=$_SESSION['datos_'._ID_PAG_]['edita_info']['fichancomo_'.$id_taller]=clean_post('fichancomo_'.$id_taller);
$distrip=$_SESSION['datos_'._ID_PAG_]['edita_info']['distrip_'.$id_taller]=clean_post('distrip_'.$id_taller)==''?0:clean_post('distrip_'.$id_taller);
$ndistrip=$_SESSION['datos_'._ID_PAG_]['edita_info']['ndistrip_'.$id_taller]=clean_post('ndistrip_'.$id_taller);
$asist=$_SESSION['datos_'._ID_PAG_]['edita_info']['asist_'.$id_taller]=clean_post('asist_'.$id_taller)==''?0:clean_post('asist_'.$id_taller);
$nasist=$_SESSION['datos_'._ID_PAG_]['edita_info']['nasist_'.$id_taller]=clean_post('nasist_'.$id_taller);
$ecom=$_SESSION['datos_'._ID_PAG_]['edita_info']['ecom_'.$id_taller]=clean_post('ecom_'.$id_taller)==''?0:clean_post('ecom_'.$id_taller);
$necom=$_SESSION['datos_'._ID_PAG_]['edita_info']['necom_'.$id_taller]=clean_post('necom_'.$id_taller);
$espera=$_SESSION['datos_'._ID_PAG_]['edita_info']['espera_'.$id_taller]=clean_post('espera_'.$id_taller)==''?0:clean_post('espera_'.$id_taller);
$citas=$_SESSION['datos_'._ID_PAG_]['edita_info']['citas_'.$id_taller]=clean_post('citas_'.$id_taller)==''?0:clean_post('citas_'.$id_taller);
$cafe=$_SESSION['datos_'._ID_PAG_]['edita_info']['cafe_'.$id_taller]=clean_post('cafe_'.$id_taller)==''?0:clean_post('cafe_'.$id_taller);
$ofertas=$_SESSION['datos_'._ID_PAG_]['edita_info']['ofertas_'.$id_taller]=clean_post('ofertas_'.$id_taller)==''?0:clean_post('ofertas_'.$id_taller);
$tlfase=$_SESSION['datos_'._ID_PAG_]['edita_info']['tlfase_'.$id_taller]=clean_post('tlfase_'.$id_taller)==''?0:clean_post('tlfase_'.$id_taller);
$porcita=$_SESSION['datos_'._ID_PAG_]['edita_info']['porcita_'.$id_taller]=clean_post('porcita_'.$id_taller);


/*if(!is_numeric($pvpmo)||!is_numeric($vstock)||!is_numeric($parking)||!is_numeric($sustit)||!is_numeric($clitot)||!is_numeric($clivisit)||!is_numeric($clinuevos)||!is_numeric($porcita)){
	$_SESSION['datos_'._ID_PAG_]['edita_info']['hayerrores']=1;
}*/

if($_SESSION['datos_'._ID_PAG_]['edita_info']['hayerrores']==0){
    $existe=num_rows("SELECT * FROM info_taller WHERE it_idtaller={$id_taller}");
    $q=$existe==0?
        "INSERT INTO info_taller 
(it_idtaller, it_impmo, hconvenio, it_valorstock, it_parking, it_vehicsus, it_tienedms, it_provdms, it_fichan, it_comofichan, it_distrip, it_nomdistri, it_asistec, it_nomasist, it_comelec, it_nomcomelec, it_zonaespera, it_pantcitas, it_maqcafe, it_ofrecep, it_telinal, it_porcentr, it_totalclientes, it_clivisitas, it_clinuevos) VALUES 
({$id_taller}, '{$pvpmo}', '{$hconvenio}', '{$vstock}', '{$parking}', '{$sustit}', '{$dms}', '".u8_($dmsprov)."', '{$fichan}', '".u8_($fichancomo)."', '{$distrip}', '".u8_($ndistrip)."', '{$asist}', '".u8_($nasist)."', '{$ecom}', '".u8_($necom)."', '{$espera}', '{$citas}', '{$cafe}', '{$ofertas}', '{$tlfase}', '{$porcita}', '{$clitot}', '{$clivisit}', '{$clinuevos}')":
        "update info_taller set it_impmo='{$pvpmo}', hconvenio='{$hconvenio}', it_valorstock='{$vstock}', it_parking='{$parking}', it_vehicsus='{$sustit}', it_tienedms='{$dms}', it_provdms='".u8_($dmsprov)."', it_fichan='{$fichan}', it_comofichan='".u8_($fichancomo)."', it_distrip='{$distrip}', it_nomdistri='".u8_($ndistrip)."', it_asistec='{$asist}', it_nomasist='".u8_($nasist)."', it_comelec='{$ecom}', it_nomcomelec='".u8_($necom)."', it_zonaespera='{$espera}', it_pantcitas='{$citas}', it_maqcafe='{$cafe}', it_ofrecep='{$ofertas}', it_telinal='{$tlfase}', it_porcentr='{$porcita}', it_totalclientes='{$clitot}', it_clivisitas='{$clivisit}', it_clinuevos='{$clinuevos}' where it_idtaller={$id_taller}";
    //if($id_taller==1){echo $q;exit;}
	query($q)?null:$_SESSION["datos_"._ID_PAG_]["edita_info"]["hayerrores"]=1;
}

fuera_de_aqui($url_dest);

?>