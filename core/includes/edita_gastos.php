<?php

$_SESSION['datos_'._ID_PAG_]['edita_gastos']['hayerrores']=0;

$url_dest=clean_post('url_dest');

$id_taller=clean_post('idtaller');

$nominas=$_SESSION['datos_'._ID_PAG_]['edita_gastos']['nominas_'.$id_taller]=clean_post('nominas_'.$id_taller)==''?0:clean_post('nominas_'.$id_taller);
$seg_social=$_SESSION['datos_'._ID_PAG_]['edita_gastos']['seg_social_'.$id_taller]=clean_post('seg_social_'.$id_taller)==''?0:clean_post('seg_social_'.$id_taller);
$alquileres=$_SESSION['datos_'._ID_PAG_]['edita_gastos']['alquileres_'.$id_taller]=clean_post('alquileres_'.$id_taller)==''?0:clean_post('alquileres_'.$id_taller);
$suministros=$_SESSION['datos_'._ID_PAG_]['edita_gastos']['suministros_'.$id_taller]=clean_post('suministros_'.$id_taller)==''?0:clean_post('suministros_'.$id_taller);
$renting=$_SESSION['datos_'._ID_PAG_]['edita_gastos']['renting_'.$id_taller]=clean_post('renting_'.$id_taller)==''?0:clean_post('renting_'.$id_taller);
$serv_prof=$_SESSION['datos_'._ID_PAG_]['edita_gastos']['serv_prof_'.$id_taller]=clean_post('serv_prof_'.$id_taller)==''?0:clean_post('serv_prof_'.$id_taller);
$cuotas=$_SESSION['datos_'._ID_PAG_]['edita_gastos']['cuotas_'.$id_taller]=clean_post('cuotas_'.$id_taller)==''?0:clean_post('cuotas_'.$id_taller);
$amortizaciones=$_SESSION['datos_'._ID_PAG_]['edita_gastos']['amortizaciones_'.$id_taller]=clean_post('amortizaciones_'.$id_taller)==''?0:clean_post('amortizaciones_'.$id_taller);
$otros=$_SESSION['datos_'._ID_PAG_]['edita_gastos']['otros_'.$id_taller]=clean_post('otros_'.$id_taller)==''?0:clean_post('otros_'.$id_taller);


if($_SESSION['datos_'._ID_PAG_]['edita_gastos']['hayerrores']==0){
    if(count(dame_gastos($id_taller))!=1){
        query("DELETE FROM gastos_taller WHERE idtaller={$id_taller}");
        query("INSERT INTO gastos_taller (idtaller,nominas,seg_social,alquileres,suministros,renting,serv_prof,cuotas,amortizaciones,otros) VALUES ({$id_taller},{$nominas},{$seg_social},{$alquileres},{$suministros},{$renting},{$serv_prof},{$cuotas},{$amortizaciones},{$otros})");
    }
    else {
        query("UPDATE gastos_taller SET nominas={$nominas},seg_social={$seg_social},alquileres={$alquileres},suministros={$suministros},renting={$renting},serv_prof={$serv_prof},cuotas={$cuotas},amortizaciones={$amortizaciones},otros={$otros} WHERE idtaller={$id_taller}");
    }
}

fuera_de_aqui($url_dest);

?>