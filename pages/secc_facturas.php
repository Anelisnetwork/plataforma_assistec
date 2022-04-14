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



<div id="conttalleres" class="div_mostrarocultar listado">
	<div class="linea taller titulos">
		<div class="lin_campo" style="width:97px">
			<span>NUMERO</span>
		</div>
        <div class="lin_campo" style="width:77px">
			<span>IMPORTE</span>
		</div>
        <div class="lin_campo" style="width:238px">
			<span>CLIENTE</span>
		</div>
		<div class="lin_campo" style="width:120px" title="Fecha de emisión">
			<span>FECHA</span>
		</div>
        <div class="lin_campo" style="width:140px" title="Fecha hasta la que tendrá servicio una vez abonado el importe">
			<span>HASTA</span>
		</div>
		<div class="lin_campo" style="width:80px">
			<span>ESTADO</span>
		</div>
        <div class="lin_campo" style="width:16px">
			<span>&nbsp;</span>
		</div>
        <div class="lin_campo" style="width:16px">
			<span>&nbsp;</span>
		</div>
        <div class="lin_campo" style="width:16px; border:0px">
			<span>&nbsp;</span>
		</div>
	</div>
    
<?php 
if(count($facturas)>0){
	foreach($facturas as $key=>$factura){
		$estado=$factura->estado;
		$idfactura=$factura->idfactura;
		include('includes/facturas_linea'.($_SESSION['datos_'._ID_PAG_]['datos_user']['rango']!=1?'_user':'').'.php');
	}
}
else{?>
	<div class="linea taller" style="text-align:center; color:#C30; font-weight:bold">
    	NO HAY RESULTADOS
    </div>
<?php }
$total_items=$total_filtrado;
$npaginas>1?include('includes/paginador.php'):'';


?>
</div>

