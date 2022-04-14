<?php
include('core/core.php');
open_bd();
$archivo=clean_get('metodo');
include _ZEND_ .'metodos/' . $archivo . '.php';
