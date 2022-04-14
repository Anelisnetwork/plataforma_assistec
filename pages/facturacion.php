<?php include('includes/cod_facturacion.php');

if($_SESSION['datos_'._ID_PAG_]['datos_user']['rango']!=1){
?>
<a href="<?=_RAIZ_.$m.'/facturas/'?>" title="Facturas" class="fs_16 nav_seccion<?=$seccion=='facturas'?' activo':''?>">Facturas</a>
<?php }
else{
?>
<a href="<?=_RAIZ_.$m.'/vencimientos/'?>" title="Vencimientos" class="fs_16 nav_seccion<?=$seccion=='vencimientos'?' activo':''?>">Vencimientos</a>
<a href="<?=_RAIZ_.$m.'/facturas/'?>" title="Facturas" class="fs_16 nav_seccion<?=$seccion=='facturas'?' activo':''?>">Facturas</a>
<span title="Emitir factura" class="fs_16 nav_seccion<?=$seccion=='emitir_factura'?' activo':''?>"<?=$seccion=='emitir_factura'?'':' style="display:none"'?>>Emitir factura</span>
<span title="Editar factura" class="fs_16 nav_seccion<?=$seccion=='editar_factura'?' activo':''?>"<?=$seccion=='editar_factura'?'':' style="display:none"'?>>Editar factura</span>
<?php }?>
<br clear="all" />

<div class="cont_seccion">
<?php include('pages/secc_'.$seccion.'.php')?>
</div>