<?php
$hayErrores = true;
$url_dest='https://assistec.es/login/';

$token=clean_get('token');

if(!empty($token) && verify_token($token)){
    $dato_cli=list_object("select us_idusuario, us_pass, us_estado from usuarios where wp_token='$token'");
    //vd__($dato_cli);

    // Si solo hay un cliente y está activo, cargamos sus datos
    if(count($dato_cli) === 1 && $dato_cli[0]->us_estado === '1'){
        datos_usuario($dato_cli[0]->us_idusuario);
        // Si no es súper admin y no hay idtaller definido, salimos
        if($dato_cli[0]->us_idusuario === '5' || ($_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller'] > 0 && $_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller'] !== '')){
            //vd__($_SESSION['datos_'._ID_PAG_]['datos_user']);
            $_SESSION['datos_'._ID_PAG_]['idusuario'] = $dato_cli[0]->us_idusuario;
            $url_dest = _RAIZ_ . 'inicio/';
            $hayErrores = false;
        }
    }
}

fuera_de_aqui($url_dest);