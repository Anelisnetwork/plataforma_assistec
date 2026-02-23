<?php 
if(isset($_SESSION['datos_'._ID_PAG_]['emitir_factura']['hayerrores'])){
	$mensaje=$_SESSION['datos_'._ID_PAG_]['emitir_factura']['mensaje'];
	if($_SESSION['datos_'._ID_PAG_]['emitir_factura']['hayerrores']==1){
?>
    <script>
		alertify.error("<?=$mensaje?>");
	</script>
	<?php }
	else{?>
    <script>
		alertify.success("<?=$mensaje?>");
	</script>
	<?php }
}

unset ($_SESSION['datos_'._ID_PAG_]['emitir_factura']);
?>
<div class="table-responsive w-100">
    <table class="table table-sm table-striped table-bordered">
        <thead>
            <tr>
                <th style="">&nbsp;</th>
                <th style="">TALLER</th>
                <th style="">TELEFONO</th>
                <th style="">CONTRATO</th>
                <th style="">VENCIMIENTO</th>
                <th style="; text-align:center">ABONADOS</th>
                <th style="; text-align:center; border:0px">FACTURAR</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if(count($facturas)>0){
            foreach($facturas as $key=>$factura){
                $estado=$factura->estado;
                $idfactura=$factura->idfactura;?>
                <tr>
                    <td><?=$factura->idfactura>11?'ACM-'.$factura->nfactura:$factura->nfactura?></td>
                    <td><?=moneda_puntocoma($factura->importe).' &euro;'?></td>
                    <td><?=$factura->cliente_nombre?></td>
                    <td><?=fecha($factura->fecha_emision)?></td>
                    <td><?=fecha($factura->fecha_vencimiento)?></td>
                    <td style="text-align: center" id="estado_fac_<?=$idfactura?>"><?php include 'includes/f_est_'.$estado.'.php';?></td>
                    <td style="text-align: center">
                        <a target="_blank" href="<?=_RAIZ_.'pdf/'.en__('pdf_factura%%guardar%%'.$idfactura.'%%'.$factura->idcli.'').'/'?>"><img src="<?=_RAIZ_?>imagenes/mail_send.png" title="Enviar factura" ></a>
                    </td>
                    <td style="text-align: center">
                        <a href="<?=_RAIZ_.$m.'/editar_factura/'.$idfactura.'/'?>"><img src="<?=_RAIZ_?>imagenes/editar.png" title="Editar factura" ></a>
                    </td>
                </tr>
            <?php }
        }
        else{?>
            <tr>
                <td colspan="7" class="text-center">
                    NO HAY RESULTADOS
                </td>
            </tr>
        <?php }?>
        </tbody>
    </table>
</div>
    <?php $total_items=$total_filtrado;
$npaginas>1?include('includes/paginador.php'):'';

