<div id="contusuarios" class="div_mostrarocultar listado">
	<div class="linea buscador">
    	<form method="post" name="busq_promocion" id="busq_promocion">
            <input type="text" name="prom_busq" id="prom_busq" value="<?=isset($_SESSION['prom_busq'])?u8d_($_SESSION['prom_busq']):''?>" placeholder="Indique el t&iacute;tulo a buscar" />
            <input type="submit" value="Buscar" style="margin-right:0px" />
        </form>
    </div>
	<div class="linea usuario titulos">
		<div class="lin_campo" style="width:100px">
			<span>TIPO</span>
		</div>
        <div class="lin_campo" style="width:70px">
			<span>MESES</span>
		</div>
		<div class="lin_campo" style="width:360px">
			<span>TITULO</span>
		</div>
        <div class="lin_campo" style="width:110px">
			<span>FECHA INICIO</span>
		</div>
		<div class="lin_campo" style="width:110px">
			<span>FECHA FIN</span>
		</div>
		<div class="lin_campo" style="width:55px">
			<span>ESTADO</span>
		</div>
        <div class="lin_campo" style="width:16px; border:0px">
			<span>&nbsp;</span>
		</div>
	</div>
<?php 
if(count($promociones)>0){
	foreach($promociones as $key=>$promocion){?>
	<div class="linea usuario cambiab<?=$key%2!=0?' par':''?>">
		<div class="lin_campo" style="width:100px">
			<span><?=$promocion->pr_tipo==1?'Suscripci&oacute;n':'Obsequio'?></span>
		</div>
        <div class="lin_campo" style="width:70px; text-align:center">
			<span><?=$promocion->pr_tipo==1?$promocion->pr_meses:'---'?></span>
		</div>
		<div class="lin_campo" style="width:360px">
			<span><?=$promocion->pr_titulo?></span>
		</div>
        <div class="lin_campo" style="width:110px">
			<span><?=fecha($promocion->pr_desde)?></span>
		</div>
		<div class="lin_campo" style="width:110px">
			<span><?=fecha($promocion->pr_hasta)?></span>
		</div>
		<div class="lin_campo" style="width:55px; text-align:center" title="<?=$promocion->pr_activa==0?'Inactiva':'Activa'?>">
			<img src="<?=_RAIZ_?>imagenes/<?=$promocion->pr_activa?>.png" >
		</div>
        <div class="lin_campo" style="width:16px; text-align:center; border:0px">
            <a href="<?=_RAIZ_.$m.'/editar_promocion/'.$promocion->pr_idpromocion.'/'?>"><img src="<?=_RAIZ_?>imagenes/editar.png" title="Editar promoci&oacute;n" ></a>
		</div>
	</div>
<?php }
}
$total_items=$total_filtrado;
$npaginas>1?include('includes/paginador.php'):'';


?>
</div>