<?php
/**
 * Para acceso pruebas:
 * Usuario: pruebas o pruebas_red (taller o red de talleres)
 * Password: jk&y@FF6
 */

$entorno = $_SERVER['SERVER_NAME'] == 'localhost' || str_contains($_SERVER['SERVER_NAME'], 'siguetuproyecto') ? 'local':'produccion';

define('_ENTORNO_',$entorno);
if(_ENTORNO_=='local'){
    define( '_DEBUG_', true);

    define( '_TEST_', true);// True = Base de datos de pruebas
}
else{
    define( '_DEBUG_', false);

    define( '_TEST_', false);// True = Base de datos de pruebas
}

if ( _DEBUG_ ){
    ini_set("display_errors", 1);
    error_reporting(E_ALL ^E_DEPRECATED);
}
else{
    ini_set("display_errors", 0);
}

date_default_timezone_set('Europe/Madrid');

ini_set("session.cookie_lifetime","86400");
ini_set("session.gc_maxlifetime","86400");

session_start();

define( '_ID_PAG_','ASSISTEC' );

define( '_TIPO_ACCESO_','USERS' );//USERS=acceso a usuarios ALL=acceso libre

define( '_RECEPTOR_','web@assistec.es' );
define( '_RECEPTOR_N_','Web Assistec' );

define( '_SMTP_SERVER_','mail.assistec.es' );

define( '_SMTP_USER_','formulario@assistec.es' );

define( '_SMTP_PASSWORD_','Ass1sT3c&F0rM' );

define('_CLAVE_CIFRADO_','fuEA7&kkl23ua4$do');

if(_ENTORNO_=='local'){
    define( '_SMTP_PORT_','25' );
}
else{
    define( '_SMTP_PORT_','587' );
}

define( '_BD_HOST_', 'localhost');

define( '_IVA_', '1.21');

define('DS',DIRECTORY_SEPARATOR);

if(_TEST_){
    define( '_PATH_', DS.'var'.DS.'www'.DS.'vhosts'.DS.'siguetuproyecto.com'.DS.'assistec.siguetuproyecto.com'.DS);
    define( '_RAIZ_', 'https://assistec.siguetuproyecto.com/');
    define( '_WEB_', 'https://assistec.siguetuproyecto.com/');
    define( '_ZEND_', DS.'var'.DS.'www'.DS.'vhosts'.DS.'siguetuproyecto.com'.DS.'assistec.siguetuproyecto.com'.DS.'core'.DS);

    define( '_BD_NAME_', 'assistec_stp');
    define( '_BD_USER_', 'assistec_usr');
    define( '_BD_PASS_', 'fP1y449w_$1wF8l46w');
}
else{
    define( '_PATH_', DS.'var'.DS.'www'.DS.'vhosts'.DS.'assistec.es'.DS.'plataforma.assistec.es'.DS);
    define( '_RAIZ_', 'https://plataforma.assistec.es/');
    define( '_WEB_', 'https://assistec.es/');
    define( '_ZEND_', DS.'var'.DS.'www'.DS.'vhosts'.DS.'assistec.es'.DS.'plataforma.assistec.es'.DS.'core'.DS);

    define( '_BD_NAME_', 'bbdd_assistec');
    define( '_BD_USER_', 'usr_assistec');
    define( '_BD_PASS_', 't1j42$2qJzl58$l46X');
}
const RUTA_LOGS = _PATH_ . "tmp";
if (!file_exists(RUTA_LOGS)) {
    if (!mkdir($concurrentDirectory = RUTA_LOGS) && !is_dir($concurrentDirectory)) {
        throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
    }
}

ini_set("log_errors", 1);
ini_set("error_log", RUTA_LOGS . "/PHP_errors_" . date("Ymd") . ".log");

function c_(){
    $db_host = _BD_HOST_;
    $db_nombre = _BD_NAME_;
    $db_user = _BD_USER_;
    $db_pass = _BD_PASS_;

    $link= mysqli_connect($db_host, $db_user, $db_pass, $db_nombre) or die ("Ups! Error conectando a la base de datos.");
    return $link;
}

/*         ¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡  DEFINIR RAIZ EN funciones.js   !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!    */

define('_ADMIN_',_PATH_.'admin/');

define('module_folder','core_funks');

define('module_prev','core_');

define( '_DEFAULT_MODULE_','inicio' );

$_core_mods_ = array(

    /*
        -------------------------------------------------------
          Cargamos modulos del nucleo
        -------------------------------------------------------
    */

    0 => 'stuff',
    1 => 'func',
    2 => 'modulos',
    3 => 'usuarios'

);

$_m = count($_core_mods_);

for ( $i=0; $i<$_m; $i++ ){
    require _ZEND_.module_folder.DS.module_prev.$_core_mods_[$i].'.php';
}