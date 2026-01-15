<?php
include('core/core.php');

vd__(verify_token(''));

exit;
open_bd();
$archivo=clean_get('metodo');
include _ZEND_ .'metodos/' . $archivo . '.php';
