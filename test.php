<?php
date_default_timezone_set('Europe/Madrid');

ini_set('display_errors', '1');
error_reporting(E_ALL|E_STRICT);

include('core/core.php');

// Ejemplo de uso:
$prev = mes_anho_anterior();
echo "Mes anterior: {$prev['mes']}, Año anterior: {$prev['anho']}";


exit;

//$token_silent=encriptar($correo.'%%'.$pass1);
open_bd();
$idparent='1578';
$ls=list_object("SELECT {$idparent} AS IDRED, ta_nombre AS TALLER, ta_idtaller AS IDTALLER, ta_log_token AS TOKEN, u.us_accesosilent AS SILENTLOGIN, u.us_idusuario, u.us_correo, u.us_pass FROM talleres t INNER JOIN usuarios u on t.ta_idtaller = u.us_idtaller WHERE ta_idparent='{$idparent}'");

$archivo='Talleres_Gemicar.csv';
$csv_file = fopen($archivo, 'w+');

$datos_linea = array('NOMBRE','IDTALLER','IDRED','CORREO ACCESO','TOKEN ENVIO DATOS','ACCESO SILENT LOGIN');
fputcsv($csv_file,$datos_linea,';','"');
foreach($ls as $l){
    $idred=$l->IDRED;
    $idtaller=$l->IDTALLER;
    $taller=u8d_($l->TALLER);
    $token=$l->TOKEN;
    $token=$l->TOKEN;
    if($token==''){
        $token=md5('idtaller='.$d_tall[0]->ta_idtaller.' momento='.time());
        query("UPDATE talleres SET ta_log_token='{$token}' WHERE ta_idtaller='{$idtaller}'");
    }
    $silentlogin=$l->SILENTLOGIN;
    if($silentlogin==''){
        $silentlogin=encriptar($l->us_correo.'%%'.$l->us_pass);
        query("update usuarios set us_accesosilent='{$silentlogin}' where us_idusuario='{$l->us_idusuario}'");
    }
    $idred=en__id($idred);
    $idtaller=en__id($idtaller);
    $datos_linea = array($taller,$idtaller,$idred,$l->us_correo,$token,$silentlogin);
    fputcsv($csv_file,$datos_linea,';','"');
    //echo '"'.$taller.'";"'.$idtaller.'";"'.$idred.'";"'.$l->us_correo.'";"'.$token.'";"'.$silentlogin.'<br>';
}
fclose($csv_file);



exit;
$archivo = _PATH_.'documentos/GEMICAR.xlsx';
importar_talleres($archivo);

close_bd();