<div id="conttalleres" class="div_mostrarocultar listado">
	<form action="<?=_RAIZ_?>descarga_excel/" method="post" name="excel_taller" id="excel_taller">
    </form>
	<form method="post" name="busq_taller" id="busq_taller">
        <div class="linea buscador">
            
            <input type="text" name="tall_busq" id="tall_busq" value="<?=isset($_SESSION['tall_busq'])?u8d_($_SESSION['tall_busq']):''?>" placeholder="Indique el dato a buscar (Nombre, CIF, provincia...)" />
            <span style="float:left; margin:6px 5px 0px 10px;">Tipo de taller: </span>
            <select name="tall_tipo" id="tall_tipo" style="float:left; width:auto">
                <option value="99"<?=!isset($_SESSION['tall_tipo'])||$_SESSION['tall_tipo']=='99'?' selected="selected"':''?>>Todos</option>
                <option value="1"<?=isset($_SESSION['tall_tipo'])&&$_SESSION['tall_tipo']=='1'?' selected="selected"':''?>>Taller independiente</option>
                <option value="2"<?=isset($_SESSION['tall_tipo'])&&$_SESSION['tall_tipo']=='2'?' selected="selected"':''?>>Red de talleres</option>
            </select>
            <input type="submit" value="Buscar" style="margin-right:0px" />
        </div>
        
        <div class="linea buscador">
            <select name="tall_nodatos" id="tall_nodatos" style="float:left; width:auto" onchange="carga_datos(this.value)">
                <option value="99"<?=!isset($_SESSION['tall_bsqdat'])||$_SESSION['tall_bsqdat']=='99'?' selected="selected"':''?>>Todos</option>
                <option value="0"<?=isset($_SESSION['tall_bsqdat'])&&$_SESSION['tall_bsqdat']=='0'?' selected="selected"':''?>>No han cargado datos en</option>
                <option value="1"<?=isset($_SESSION['tall_bsqdat'])&&$_SESSION['tall_bsqdat']=='1'?' selected="selected"':''?>>S&iacute; han cargado datos en</option>
            </select>
            <select name="tall_mes" id="tall_mes" style="float:left; width:auto; display:<?=!isset($_SESSION['tall_bsqdat'])||$_SESSION['tall_bsqdat']=='99'?'none':'block'?>">
                <?php foreach($l_meses as $mes){?>
                    <option value="<?=conceros($mes->m_idmes,2)?>"<?=isset($_SESSION['tall_mes'])&&$_SESSION['tall_mes']==conceros($mes->m_idmes,2)?' selected="selected"':''?>><?=$mes->m_nombre?></option>
                <?php }?>
            </select>
            <select name="tall_anho" id="tall_anho" style="float:left; width:auto; display:<?=!isset($_SESSION['tall_bsqdat'])||$_SESSION['tall_bsqdat']=='99'?'none':'block'?>">
                <?php for($an='2018';$an<=date('Y');$an++){?>
                    <option value="<?=$an?>"<?=isset($_SESSION['tall_anho'])&&$_SESSION['tall_anho']==$an?' selected="selected"':''?>><?=$an?></option>
                <?php }?>
            </select>

            <input type="submit" value="Descargar" style="margin-right:0px; padding:0px; background-color:transparent; color:#0C3" form="excel_taller" />
            <input type="hidden" form="excel_taller" name="tipo_archivo" id="tipo_archivo" value="listado_excel_talleres" />
        </div>
    </form>
    
	<div class="linea taller titulos">
		<div class="lin_campo" style="width:16px">
			<span>&nbsp;</span>
		</div>
        <div class="lin_campo" style="width:193px">
			<span>NOMBRE</span>
		</div>
		<div class="lin_campo" style="width:120px">
			<span>CONTACTO</span>
		</div>
        <div class="lin_campo" style="width:90px">
			<span>TELEFONO</span>
		</div>
		<div class="lin_campo" style="width:193px">
			<span>CORREO</span>
		</div>
		<div class="lin_campo" style="width:166px">
			<span>MATRIZ</span>
		</div>
        <div class="lin_campo" style="width:16px;">
			<span>&nbsp;</span>
		</div>
        <div class="lin_campo" style="width:16px; border:0px">
			<span>&nbsp;</span>
		</div>
	</div>
<?php
if(count($talleres)>0){
	foreach($talleres as $key=>$taller){
		$nombre=u8d_($taller->ta_nombre);
		$contacto=u8d_($taller->ta_contacto);
		$correo=$taller->ta_email;
		$ultacceso=$taller->ta_ultacceso;
		$matriz=$taller->ta_idtipo==2?'---':u8d_(dato_taller('ta_nombre', $taller->ta_idparent));
		$red=$taller->ta_idtipo==2?1:0;?>
	<div class="linea taller cambiab<?=$key%2!=0?' par':''?>">
    	<div class="lin_campo" style="width:16px; text-align:center">
        <?php if($red==1){?>
			<img src="<?=_RAIZ_?>imagenes/red.png" title="Red de talleres / distribución" >
        <?php }?>
		</div>
		<div title="<?=$nombre?>" class="lin_campo" style="width:193px">
			<span><?=$nombre?></span>
		</div>
		<div title="<?=$contacto?>" class="lin_campo" style="width:120px">
			<span><?=$contacto?></span>
		</div>
        <div class="lin_campo" style="width:90px">
			<span><?=$taller->ta_telefono1?></span>
		</div>
		<div title="<?=$correo?>" class="lin_campo" style="width:193px">
			<span><?=$correo?></span>
		</div>
		<div title="<?=$matriz?>" class="lin_campo" style="width:166px;">
			<span><?=$matriz?></span>
		</div>
        <div class="lin_campo" style="width:16px; text-align:center;">
			<span class="faq"><img src="<?=_RAIZ_?>imagenes/clock_<?=$ultacceso==''?'no':'si'?>.png" title="<?=$ultacceso==''?'No hay registro de acceso':'Último acceso: '.fechahora_esp($ultacceso)?>" ></span>
		</div>
        <div class="lin_campo" style="width:16px; text-align:center; border:0px">
			<a href="<?=_RAIZ_.$m.'/editar_taller/'.$taller->ta_idtaller.'/'?>"><img src="<?=_RAIZ_?>imagenes/editar.png" title="Editar taller" ></a>
		</div>
	</div>
<?php }
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

