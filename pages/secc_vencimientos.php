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
                <th style=" text-align:center">ABONADOS</th>
                <th style=" text-align:center; border:0px">FACTURAR</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if(count($talleres)>0){
        foreach($talleres as $key=>$taller){
        $nabonados=num_rows('select ta_idtaller from talleres, usuarios where ta_idparent='.$taller->ta_idtaller.' and talleres.ta_idtaller=usuarios.us_idtaller and usuarios.us_estado!=3');
        $hay_fac=factura_pte($taller->ta_idtaller);
        $faltan=time()-strtotime($taller->ta_vencimiento);
        $diferencia=faltan(abs($faltan));
        ?>
                <tr>
                    <td>
                    <?php if($taller->ta_idtipo==2){?>
                        <img src="<?=_RAIZ_?>imagenes/red.png" title="Red de talleres / distribución" >
                    <?php }?>
                    </td>
                    <td>
                        <?=$taller->ta_nombre?>
                    </td>
                    <td>
                        <?=$taller->ta_telefono1?>
                    </td>
                    <td>
                        <?=dame_nombre_contrato($taller->ta_contrato)?>
                    </td>
                    <td class="faq"<?=$hay_fac!=0?'':($faltan>0?' style="color:#C30; font-weight:bold"':($faltan<0&&$faltan>-604800?' style="color:#3C0; font-weight:bold"':''))?> title="<?=$hay_fac!=0?'Hay una factura emitida':(($faltan>0?'Venci&oacute; hace ':'Faltan ').$diferencia.($faltan<0?' para que venza,.':'.'))?>">
                        <?=$hay_fac!=0?'Factura emitida':fecha($taller->ta_vencimiento)?>
                    </td>
                    <td style="text-align:center">
                        <?=$nabonados==0?'---':$nabonados?>
                    </td>
                    <td style="text-align:center; border:0px">
                    <?php if($hay_fac==0){?>
                        <a href="<?=_RAIZ_.$m.'/emitir_factura/'.$taller->ta_idtaller.'/'?>">
                            <img src="<?=_RAIZ_?>imagenes/editar.png" title="Emitir factura" >
                        </a>
                    <?php }?>
                    </td>
                </tr>
        <?php }
        }?>
        </tbody>
    </table>
</div>

<?php $npaginas>1?include('includes/paginador.php'):'';?>