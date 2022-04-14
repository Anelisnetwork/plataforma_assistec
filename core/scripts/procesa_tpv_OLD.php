<?php
// Reemplaza esto con los valores que recibió de TPV Virtual de Santander Elavon.
$merchantid = "assistec";
$secret = "KbmJ22xLl8";
$account = "internet";

//El código a continuación es usado para crear la marca de tiempo en el formato que 
// TPV Virtual de Santander Elavon requiere.
$timestamp = strftime("%Y%m%d%H%M%S");
mt_srand((double)microtime()*1000000);

/*

 orderid:Reemplaza esto con el orderid que quieras usar. Este valor ha de ser único.
 En el ejemplo a continuación se utiliza una combinación de marca de tiempo y un número aleatorio.
 
*/

$orderid = $nfactura."-".$idfactura;


/*
En este ejemplo los valores están escritos literalmente. En realidad deberías
pasar estos valores desde otro script o tomarlos de una base de datos.
*/
$curr = "EUR";
$amount = $total*100;


/*-----------------------------------------------
A continuación el código para generar una firma digital utilizando el algoritmo MD5 que 
PHP provee. Puedes usar SHA1 alternativamente.
*/
$tmp = "$timestamp.$merchantid.$orderid.$amount.$curr";
$sha1hash = sha1($tmp);
$tmp = "$sha1hash.$secret";
$sha1hash = sha1($tmp);

?>
<script>
$(document).ready(function() {
	setTimeout('$("#pago_tpv" ).submit()',3000);
});
</script>

<form action="https://hpp.santanderelavontpvvirtual.es/pay" id="pago_tpv" name="pago_tpv" method=post>
    <input type=hidden name="MERCHANT_ID" value="<?=$merchantid?>">
    <input type=hidden name="ORDER_ID" value="<?=$orderid?>">
    <input type=hidden name="CURRENCY" value="<?=$curr?>">
    <input type=hidden name="AMOUNT" value="<?=$amount?>">
    <input type=hidden name="ACCOUNT" value="<?=$account?>">
    <input type=hidden name="TIMESTAMP" value="<?=$timestamp?>">
    <input type=hidden name="SHA1HASH" value="<?=$sha1hash?>">
    <input type=hidden name="AUTO_SETTLE_FLAG" value="1">
</form>

    <div style="width:600px; text-align:center; margin:5% auto 0% auto; line-height:140%; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#555">
        <img src="<?=_RAIZ_?>imagenes/assistec.png" /><br /><br />
        Ser&aacute; redirigido a un servidor seguro para realizar el pago; si el navegador no le redirige autom&aacute;ticamente en 10 segundos, pulse el bot&oacute;n de abajo.
        <br /><br /><br /><br /><br /><br />
        <input form="pago_tpv" type=submit value="Ir a un servidor seguro" class=" indent redondo link" style="width:300px; background-color:#E2001A; color:#FFF">
    </div>