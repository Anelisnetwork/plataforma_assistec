<?php

require_once('core/core.php');

open_bd();
if(isset($_SESSION['datos_'._ID_PAG_]['idusuario'])){
    datos_usuario($_SESSION['datos_'._ID_PAG_]['idusuario']);
}
include('layouts/'.$layout.'.php');

close_bd();

?>