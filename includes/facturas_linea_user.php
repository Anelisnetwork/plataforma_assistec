<div class="linea cambiab<?=$key%2!=0?' par':''?>">
    <div class="lin_campo" style="width:97px; text-align:right">
        <span><?=$factura->idfactura>11?'ACM-'.$factura->nfactura:$factura->nfactura?></span>
    </div>
    <div class="lin_campo" style="width:77px; text-align:right">
        <span><?=moneda_puntocoma($factura->importe).' &euro;'?></span>
    </div>
    <div class="lin_campo" style="width:238px">
        <span><?=u8d_($factura->cliente_nombre)?></span>
    </div>
    <div class="lin_campo" style="width:120px; text-align:center">
        <span><?=fecha($factura->fecha_emision)?></span>
    </div>
    <div class="lin_campo" style="width:140px; text-align:center">
        <span><?=fecha($factura->fecha_vencimiento)?></span>
    </div>
    <div id="estado_fac_<?=$idfactura?>" class="lin_campo" style="width:80px; text-align:center">
        <span style="color:<?=$estado==1?'#390':'#C00'?>"><?=$estado==1?'Pagada':($estado==0?'<strong>Pendiente</strong>':($estado==9?'Anulada':($estado==2?'Devuelta':'')))?></span>
    </div>
    <div class="lin_campo" style="width:16px">
        <a target="_blank" href="<?=_RAIZ_.'pdf/'.en__('pdf_factura%%imprimir%%'.$idfactura.'%%'.$factura->idcli.'').'/'?>"><img src="<?=_RAIZ_?>imagenes/imprimir.png" title="Imprimir factura" ></a>
    </div>
    <div class="lin_campo" style="width:16px">
    <?php /*if($estado==0){*/?><!--
    	<a target="_blank" href="<?/*=_RAIZ_.'proceso_de_pago/'.en__('pago_factura%%'.$idfactura.'%%'.$factura->idcli.'%%'.$factura->importe.'').'/'*/?>"><img src="<?/*=_RAIZ_*/?>imagenes/tarjeta.png" title="Pagar por TPV" ></a>
    --><?php /*}
	else {*/?>
        &nbsp;
    <?php /*}*/?>
    </div>
    <div class="lin_campo" style="width:16px; border:0px">
        &nbsp;
    </div>
</div>