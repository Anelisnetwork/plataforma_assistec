<?php
date_default_timezone_set('Europe/Madrid');

include('core/core.php');

show_errors('on');

open_bd();

$datos=clean_get('datos');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="<?=_RAIZ_?>imagenes/assistec_ico.png">
<meta name="viewport" content="width=device-width, user-scalable=yes" />
<script src="<?=_RAIZ_?>js/jquery-1.11.2.js" type="text/javascript"></script>
<title>Assistec - Proceso de pago</title>
<link href='https://fonts.googleapis.com/css?family=Ubuntu|Oswald:400,300' rel='stylesheet' type='text/css'>
<link href="<?=_RAIZ_?>estilos/estilos.css?v=30032023" rel="stylesheet" type="text/css" />
</head>

<body>
<style>
a{
    color:#555;
    text-decoration:none;
}
a:hover{
    text-decoration:none;
}
.link {
    cursor:pointer;
}
.indent{
    padding:5px 8px;
}
.redondo{
    -moz-border-radius: 3px;
    -webkit-border-radius: 3px;
    border-radius: 3px;
}
</style>
<div style="width:600px; text-align:center; margin:5% auto 0% auto; line-height:140%; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#555">
    <img src="<?=_RAIZ_?>imagenes/assistec.png" /><br /><br />
    El pago ha sido realizado correctamente; ya puede acceder a su panel de control desde el siguiente enlace: <a href="http://www.cuadrodemando.assistec.es/"><strong style="color:#EF7F1F">Acceder a Assistec Online</strong></a>
    <br /><br />
    Muchas gracias por su confianza.
    <br /><br /><br /><br />
    <a target="_blank" href="<?=_RAIZ_?>pdf/<?=$datos?>/" class="indent redondo link" style="width:300px; background-color:#EF7F1F; color:#FFF">Descargar factura</a>
</div>

</body>
</html>