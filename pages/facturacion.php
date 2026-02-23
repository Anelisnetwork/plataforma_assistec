<?php include('includes/cod_facturacion.php');?>
<div class="d-flex flex-column align-items-center justify-content-start w-100 p-2 p-sm-5">
    <div class="d-flex flex-column flex-sm-row align-items-center justify-content-start w-100">
        <?php if($_SESSION['datos_'._ID_PAG_]['datos_user']['rango']!=1){?>
        <a href="<?=_RAIZ_.$m.'/facturas/'?>" title="Facturas" class="fs_16 px-3 py-1 m-1 col-12 col-sm-auto btn btn-outline-secondary nav_seccion<?=$seccion=='facturas'?' actieo':''?>">Facturas</a>
        <?php }
        else{?>
        <a href="<?=_RAIZ_.$m.'/vencimientos/'?>" title="Vencimientos" class="fs_16 px-3 py-1 m-1 col-12 col-sm-auto btn btn-outline-secondary nav_seccion<?=$seccion=='vencimientos'?' active':''?>">Vencimientos</a>
        <a href="<?=_RAIZ_.$m.'/facturas/'?>" title="Facturas" class="fs_16 px-3 py-1 m-1 col-12 col-sm-auto btn btn-outline-secondary nav_seccion<?=$seccion=='facturas'?' active':''?>">Facturas</a>
        <span title="Emitir factura" class="fs_16 nav_seccion<?=$seccion=='emitir_factura'?' activo':''?>"<?=$seccion=='emitir_factura'?'':' style="display:none"'?>>Emitir factura</span>
        <span title="Editar factura" class="fs_16 nav_seccion<?=$seccion=='editar_factura'?' activo':''?>"<?=$seccion=='editar_factura'?'':' style="display:none"'?>>Editar factura</span>
        <?php }?>
    </div>
    <div class="col col-12 d-flex flex-column align-items-start align-items-sm-start">
    <?php include('pages/secc_'.$seccion.'.php')?>
    </div>
</div>