<?php if($idtaller==''){?>
<div style="text-align:center; width:100%; padding:20px 0px"><span class="oswald texto_r fs_16">No ha indicado ning&uacute;n taller v&aacute;lido.</span></div>
<?php }
else{?>
<form action="<?=_RAIZ_?>procesando.php" method="post" name="emitir_factura" id="emitir_factura">
    <div class="fac_linea">
        <div class="fac_datos">
            <div class="dat_lin">
                <span class="fs_20"><?=u8d_($datos_fac['uf_denomsoc'])?></span>
            </div>
            <div class="dat_lin">
                <span><?=$datos_fac['uf_cifnif']?></span>
            </div>
            <?php if($datos_fac['uf_contacto']!=''){?>
            <div class="dat_lin">
                <span><?='A/A '.u8d_($datos_fac['uf_contacto'])?></span>
            </div>
            <?php }?>
            <div class="dat_lin">
                <span><?=u8d_($datos_fac['uf_direccion'])?></span>
            </div>
            <div class="dat_lin">
                <span><?=$datos_fac['uf_cp'].' - '.u8d_($datos_fac['uf_localidad'])?></span>
            </div>
            <div class="dat_lin">
                <span><?=u8d_($datos_fac['uf_provincia'])?></span>
            </div>
            <div class="dat_lin">
                <span><?=$datos_fac['uf_email']?></span>
            </div>
            <div class="dat_lin">
                <span><?=$datos_fac['uf_telefono1'].($datos_fac['uf_telefono2']!=''?' - '.$datos_fac['uf_telefono2']:'')?></span>
            </div>
        </div>
        <div class="fac_datos">
            <div class="dat_lin">
                <span><strong>Tipo:</strong> <?=$datos_taller['ta_idtipo']==1?'Taller independiente':($datos_taller['ta_idtipo']==2?'Red de talleres':'---')?></span>
            </div>
            <?php $productos=array();
			if($datos_taller['ta_idtipo']==1){
				$productos[]=array($datos_taller['ta_contrato'], 1);?>
            <div class="dat_lin">
                <span><strong>Contrato:</strong> <?=dame_nombre_contrato($datos_taller['ta_contrato'])?></span>
            </div>
            <?php }
            else{?>
            <div class="dat_lin">
                <span><strong>Contratos:</strong></span>
            </div>
            <?php foreach ($l_contratos as $contrato){
				$cuantos=count(dame_abonados($idtaller, 'activo', $contrato->tc_idtipo));
				$cuantos==0?'':$productos[]=array($contrato->tc_idtipo, $cuantos);?>
            <div class="dat_lin">
                <span><?=u8d_($contrato->tc_nombre)?> ---> <?=$cuantos?> talleres</span>
            </div>
            <?php }
            }?>
        </div>
        <input type="hidden" id="idproceso" name="idproceso" value="emitir_factura" />
        <input type="hidden" id="url_dest" name="url_dest" value="<?=_RAIZ_?>facturacion/facturas" />
        <input type="hidden" id="idtaller" name="idtaller" value="<?=$idtaller?>" />
        <input type="hidden" id="tipoiva" name="tipoiva" value="<?=valor_iva($datos_fac['uf_tipoiva'])?>" />
        <input type="hidden" id="retiene" name="retiene" value="<?=$datos_fac['uf_retiene']?>" />
    </div>

    <span style="float:left; margin-top:32px;"><strong>Factura n&ordm;: </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ACM-</span><input type="text" id="nfactura" name="nfactura" value="<?='ACM-'.$nfactura?>" style="margin-top:25px; margin-left:0px; width:80px; text-align:right; float:left" />
    
    <input type="date" id="vencimiento" name="vencimiento" required="required" value="<?=quita_hora(fin_mes_siguiente($datos_taller['ta_vencimiento']))?>" min="<?=date('Y-m-d')?>" style="margin-top:25px; margin-left:15px; width:auto; text-align:right; float:right" /><span style="float:right; margin-top:32px;"><strong>Servicio hasta: </strong></span>
    
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
		foreach($productos as $key=>$producto){
			$linea=$key;
			$referencia=dame_ref_contrato($producto[0]).($sigla_ta=='m'?'':$sigla_ta);
			$concepto='SUSCRIPCION MODULO '.strtoupper(dame_nombre_contrato($producto[0])).' ASSISTEC';
			$cantidad=$producto[1];
			$precio_u=fetch_array('select tc_'.$tipo_tarifa.' from tipos_contrato where tc_idtipo='.$producto[0].'','tc_'.$tipo_tarifa);
			$importe=number_format($cantidad*$precio_u,2,'.','');
			$base+=$importe;?>
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
                <input type="number" id="dto<?=$key?>" name="dto[]" value="0.00" min="0.00" step="0.01" max="100.00" style="width:50px" onchange="act_fac('<?=$key?>')" onblur="act_fac('<?=$key?>')"/>
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
        	<textarea id="observaciones" name="observaciones" style="width:438px"></textarea>
        </div>
        <div class="mitad">
        	<?php $iva=number_format($base*(valor_iva($datos_fac['uf_tipoiva'])/100),2,'.','');
			$rec=$datos_fac['uf_retiene']==1?number_format($base*(5.2/100),2,'.',''):0.00;
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
			<div class="lin_tot"<?=$datos_fac['uf_retiene']==0?' style="display:none"':''?>>
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
					<input type="submit" id="guardadatos" name="guardadatos" value="Emitir" style="margin:0px" />
				</div>
				<div class="tot_nombre">
					<input type="checkbox" id="pormail_<?=$idtaller?>" name="pormail_<?=$didtaller?>" value="1" style="float:left; margin-top:10px" class="faq" title="Marque la casilla si quiere que la factura se env&iacute;e a su cliente una vez generada." />
					<span class="fs_14" style="float:left; margin-top:8px;">Enviar por e-mail</span>
				</div>
			</div>
        </div>
    </div>
</form>
<?php }?>