<?php
$merchantid = "031022312";
$secret = "sq7HjrUOBfKmC576ILgskD5srU870gJ7";

$orderid = conceros($idfactura,12);

$curr = "978";
$amount = $total*100;

$trans_type=0;

$url_comercio='http://www.cuadrodemando.assistec.es/proceso_de_pago/';

$firma=sha1($amount.$orderid.$merchantid.$curr.$trans_type.$url_comercio.$secret);

?>
<script>
$(document).ready(function() {
	setTimeout('$("#pago_tpv" ).submit()',3000);
});
</script>

<form action="https://sis-t.redsys.es:25443/sis/realizarPago" id="pago_tpv" name="pago_tpv" method=post>
	<input type=hidden name="Ds_Merchant_Amount" value="<?=$amount?>">
    <input type=hidden name="Ds_Merchant_Currency" value="<?=$curr?>">
    <input type=hidden name="Ds_Merchant_Order" value="<?=$orderid?>">
    <input type=hidden name="Ds_Merchant_ProductDescription" value="Cuota servicio Assistec">
    <input type=hidden name="Ds_Merchant_MerchantCode" value="<?=$merchantid?>">
    <input type=hidden name="Ds_Merchant_MerchantURL" value="<?=$url_comercio?>">
    <input type=hidden name="Ds_Merchant_MerchantSignature" value="<?=$firma?>">
    <input type=hidden name="Ds_Merchant_Terminal" value="1">
</form>

    <div style="width:600px; text-align:center; margin:5% auto 0% auto; line-height:140%; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#555">
        <img src="<?=_RAIZ_?>imagenes/assistec.png" /><br /><br />
        Ser&aacute; redirigido a un servidor seguro para realizar el pago; si el navegador no le redirige autom&aacute;ticamente en 10 segundos, pulse el bot&oacute;n de abajo.
        <br /><br /><br /><br /><br /><br />
        <input form="pago_tpv" type=submit value="Ir a un servidor seguro" class=" indent redondo link" style="width:300px; background-color:#E2001A; color:#FFF">
    </div>