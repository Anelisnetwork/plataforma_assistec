<?php if(isset($_SESSION['datos_'._ID_PAG_]['editar_factura']['hayerrores'])){
	$mensaje=$_SESSION['datos_'._ID_PAG_]['editar_factura']['mensaje'];
	if($_SESSION['datos_'._ID_PAG_]['editar_factura']['hayerrores']==1){
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

unset ($_SESSION['datos_'._ID_PAG_]['editar_factura']);

if($idfactura==''){?>
<div style="text-align:center; width:100%; padding:20px 0px"><span class="oswald texto_r fs_16">No ha indicado ninguna factura v&aacute;lida.</span></div>
<?php }
else{?>
<form action="<?=_RAIZ_?>procesando.php" method="post" name="editar_factura" id="editar_factura">
    <div class="fac_linea">
        <div class="fac_datos">
            <div class="dat_lin">
                <span class="fs_20"><?=u8d_($factura['cliente_nombre'])?></span>
            </div>
            <div class="dat_lin">
                <span><?=$factura['cliente_cif']?></span>
            </div>
            <?php if($factura['cliente_contacto']!=''){?>
            <div class="dat_lin">
                <span><?='A/A '.u8d_($factura['cliente_contacto'])?></span>
            </div>
            <?php }?>
            <div class="dat_lin">
                <span><?=u8d_($factura['cliente_direccion'])?></span>
            </div>
            <div class="dat_lin">
                <span><?=$factura['cliente_cp'].' - '.u8d_($factura['cliente_poblacion'])?></span>
            </div>
            <div class="dat_lin">
                <span><?=u8d_($factura['cliente_provincia'])?></span>
            </div>
            <div class="dat_lin">
                <span><?=$factura['cliente_correo']?></span>
            </div>
            <div class="dat_lin">
                <span><?=$factura['cliente_telefono']?></span>
            </div>
        </div>
        <input type="hidden" id="idproceso" name="idproceso" value="editar_factura" />
        <input type="hidden" id="url_dest" name="url_dest" value="<?=_RAIZ_?>facturacion/editar_factura/<?=$idfactura?>" />
        <input type="hidden" id="idtaller" name="idfactura" value="<?=$idfactura?>" />
        <input type="hidden" id="tipoiva" name="tipoiva" value="<?=valor_iva($factura['tipo_iva'])?>" />
        <input type="hidden" id="retiene" name="retiene" value="<?=$factura['retiene']?>" />
    </div>

    <span style="float:left; margin-top:32px;"><strong>Factura n&ordm;: </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$factura['idfactura']>11?'ACM-':''?></span><input type="text" id="nfactura" name="nfactura" value="<?=$factura['nfactura']?>" style="margin-top:25px; margin-left:0px; width:70px; text-align:right; float:left" />
    
    <input type="date" id="vencimiento" name="vencimiento" required="required" value="<?=quita_hora($factura['fecha_vencimiento'])?>" min="<?=date('Y-m-d')?>" style="margin-top:25px; margin-left:15px; width:auto; text-align:right; float:right" /><span style="float:right; margin-top:32px;"><strong>Servicio hasta: </strong></span>
    
    <div class="fac_linea listado" style="margin-top:10px">
        <div class="linea titulos">
            <div class="lin_campo" style="width:150px">
                <span>REFERENCIA</span>
            </div>
            <div class="lin_campo" style="width:335px">
                <span>CONCEPTO</span>
            </div>
            <div class="lin_campo" style="width:50px">
                <span>CANT.</span>
            </div>
            <div class="lin_campo" style="width:120px">
                <span>PRECIO/UD.</span>
            </div>
            <div class="lin_campo" style="width:50px">
                <span>DTO.</span>
            </div>
            <div class="lin_campo" style="width:120px; border:0px">
                <span>IMPORTE</span>
            </div>
        </div>
        <?php $base=0;
		foreach($lineas as $key=>$producto){
			$linea=$key;
			$referencia=$producto->fl_referencia;
			$concepto=$producto->fl_concepto;
			$cantidad=$producto->fl_cantidad;
			$precio_u=$producto->fl_preciou;
			$dto=$producto->fl_dto;
			$importe=$producto->fl_importe;?>
        <div class="linea">
            <div class="lin_campo" style="width:150px">
                <input type="text" id="ref<?=$key?>" name="ref[]" value="<?=$referencia?>" style="width:150px" />
            </div>
            <div class="lin_campo" style="width:335px">
                <input type="text" id="conc<?=$key?>" name="conc[]" value="<?=$concepto?>" required="required" style="width:335px" />
            </div>
            <div class="lin_campo" style="width:50px; text-align:center">
                <input type="number" id="cant<?=$key?>" name="cant[]" value="<?=$cantidad?>" step="0.01" min="-10000" max="10000" required="required" style="width:50px" onchange="act_fac('<?=$key?>')" onblur="act_fac('<?=$key?>')"/>
            </div>
            <div class="lin_campo" style="width:120px; text-align:right">
                <input type="number" id="preu<?=$key?>" name="preu[]" value="<?=$precio_u?>" step="0.01" min="0.00" max="10000.00" required="required" style="width:120px" onchange="act_fac('<?=$key?>')" onblur="act_fac('<?=$key?>')"/>
            </div>
            <div class="lin_campo" style="width:50px; text-align:right">
                <input type="number" id="dto<?=$key?>" name="dto[]" value="<?=$dto?>" min="0.00" step="0.01" max="100.00" style="width:50px" onchange="act_fac('<?=$key?>')" onblur="act_fac('<?=$key?>')"/>
            </div>
            <div class="lin_campo" style="width:120px; border:0px; text-align:right">
                <input type="number" id="imp<?=$key?>" name="imp[]" value="<?=$importe?>" readonly="readonly" style="width:120px"/>
            </div>
        </div>
        <?php $linea++;}?>
        <div class="linea">
            <div class="lin_campo" style="width:150px">
                <input type="text" id="ref<?=$linea?>" name="ref[]" value="" style="width:150px" />
            </div>
            <div class="lin_campo" style="width:335px">
                <input type="text" id="conc<?=$linea?>" name="conc[]" value="" style="width:335px" />
            </div>
            <div class="lin_campo" style="width:50px; text-align:center">
                <input type="number" id="cant<?=$linea?>" name="cant[]" value="0" min="-10000" max="10000" style="width:50px" onchange="act_fac('<?=$linea?>')" onblur="act_fac('<?=$linea?>')"/>
            </div>
            <div class="lin_campo" style="width:120px; text-align:right">
                <input type="number" id="preu<?=$linea?>" name="preu[]" value="0.00" min="0.00" max="10000.00" style="width:120px" onchange="act_fac('<?=$linea?>')" onblur="act_fac('<?=$linea?>')"/>
            </div>
            <div class="lin_campo" style="width:50px; text-align:right">
                <input type="number" id="dto<?=$linea?>" name="dto[]" value="0.00" min="0.00" max="100.00" style="width:50px" onchange="act_fac('<?=$linea?>')" onblur="act_fac('<?=$linea?>')"/>
            </div>
            <div class="lin_campo" style="width:120px; border:0px; text-align:right">
                <input type="number" id="imp<?=$linea?>" name="imp[]" value="0.00" readonly="readonly" style="width:120px"/>
            </div>
        </div>
    </div>
    <input type="hidden" id="nlineas" name="nlineas" value="<?=$linea?>" />
    <div class="fac_linea" style="margin-top:25px">
    	<div class="mitad">
        	<textarea id="observaciones" name="observaciones" style="width:438px"><?=u8d_($factura['observaciones'])?></textarea>
        </div>
        <div class="mitad">
        	<?php 
			$base=$factura['base_imponible'];
			$iva=number_format($base*(valor_iva($factura['tipo_iva'])/100),2,'.','');
			$rec=$factura['retiene']==1?number_format($base*(5.2/100),2,'.',''):0.00;
			$total=number_format($base+$iva+$rec,2,'.','');?>
			<div class="lin_tot">
				<div class="tot_valor">
					<input type="number" id="base" name="base" value="<?=number_format($base,2,'.','')?>" readonly="readonly" />
				</div>
				<div class="tot_nombre">
					<span>Base imponible:</span>
				</div>
			</div>
			<div class="lin_tot">
				<div class="tot_valor">
					<input type="number" id="iva" name="iva" value="<?=$iva?>" readonly="readonly" />
				</div>
				<div class="tot_nombre">
					<span>IVA (21,00%):</span>
				</div>
			</div>
			<div class="lin_tot"<?=$factura['retiene']==0?' style="display:none"':''?>>
				<div class="tot_valor">
					<input type="number" id="recargo" name="recargo" value="<?=$rec?>" readonly="readonly" />
				</div>
				<div class="tot_nombre">
					<span>R.E. (5,20%):</span>
				</div>
			</div>
			<div class="lin_tot">
				<div class="tot_valor">
					<input type="number" id="total" name="total" value="<?=$total?>" readonly="readonly" style="font-size:18px; font-weight:bold" />
				</div>
				<div class="tot_nombre">
					<span class="fs_18 ubuntu_b">TOTAL:</span>
				</div>
			</div>
			<div class="lin_tot" style="margin-top:25px;">
				<div class="tot_valor">
					<input type="submit" id="guardadatos" name="guardadatos" value="Guardar" style="margin:0px" />
				</div>
			</div>
        </div>
    </div>
</form>
<?php }?>