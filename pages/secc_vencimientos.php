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

<div id="contusuarios" class="div_mostrarocultar listado">
	<div class="linea usuario titulos">
    	<div class="lin_campo" style="width:16px">
			<span>&nbsp;</span>
		</div>
		<div class="lin_campo" style="width:300px">
			<span>TALLER</span>
		</div>
        <div class="lin_campo" style="width:115px">
			<span>TELEFONO</span>
		</div>
		<div class="lin_campo" style="width:120px">
			<span>CONTRATO</span>
		</div>
        <div class="lin_campo" style="width:120px">
			<span>VENCIMIENTO</span>
		</div>
        <div class="lin_campo" style="width:80px">
			<span>ABONADOS</span>
		</div>
        <div class="lin_campo" style="width:70px; border:0px">
			<span>FACTURAR</span>
		</div>
	</div>
<?php 
if(count($talleres)>0){
	foreach($talleres as $key=>$taller){
		$nabonados=num_rows('select ta_idtaller from talleres, usuarios where ta_idparent='.$taller->ta_idtaller.' and talleres.ta_idtaller=usuarios.us_idtaller and usuarios.us_estado!=3');
		$hay_fac=factura_pte($taller->ta_idtaller);
		$faltan=time()-strtotime($taller->ta_vencimiento);
		$diferencia=faltan(abs($faltan));
?>
	<div class="linea cambiab<?=$key%2!=0?' par':''?>">
		<div class="lin_campo" style="width:16px">
        <?php if($taller->ta_idtipo==2){?>
			<img src="<?=_RAIZ_?>imagenes/red.png" title="Red de talleres / distribución" >
        <?php }?>
		</div>
		<div class="lin_campo" style="width:300px">
			<span><?=$taller->ta_nombre?></span>
		</div>
        <div class="lin_campo" style="width:115px">
			<span><?=$taller->ta_telefono1?></span>
		</div>
		<div class="lin_campo" style="width:120px">
			<span><?=dame_nombre_contrato($taller->ta_contrato)?></span>
		</div>
		<div class="lin_campo faq" style="width:120px" title="<?=$hay_fac!=0?'Hay una factura emitida':(($faltan>0?'Venci&oacute; hace ':'Faltan ').$diferencia.($faltan<0?' para que venza,.':'.'))?>">
			<span<?=$hay_fac!=0?'':($faltan>0?' style="color:#C30; font-weight:bold"':($faltan<0&&$faltan>-604800?' style="color:#3C0; font-weight:bold"':''))?>><?=$hay_fac!=0?'Factura emitida':fecha($taller->ta_vencimiento)?></span>
		</div>
        <div class="lin_campo" style="width:80px; text-align:center">
			<span><?=$nabonados==0?'---':$nabonados?></span>
		</div>
        <div class="lin_campo" style="width:70px; text-align:center; border:0px">
        <?php if($hay_fac==0){?>
        	<a href="<?=_RAIZ_.$m.'/emitir_factura/'.$taller->ta_idtaller.'/'?>"><img src="<?=_RAIZ_?>imagenes/editar.png" title="Emitir factura" ></a>
        <?php }?>
		</div>
	</div>
<?php }
}
$npaginas>1?include('includes/paginador.php'):'';
?>
</div>