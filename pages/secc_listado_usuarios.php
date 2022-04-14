<div id="contusuarios" class="div_mostrarocultar listado">
	<form action="<?=_RAIZ_?>descarga_excel/" method="post" name="excel_usuarios" id="excel_usuarios">
    </form>
	<form method="post" name="busq_usuario" id="busq_usuario">
        <div class="linea buscador">
            <input type="text" name="usu_busq" id="usu_busq" value="<?=isset($_SESSION['usu_busq'])?u8d_($_SESSION['usu_busq']):''?>" placeholder="Indique el dato a buscar (nick, correo, taller...)" />
            <input type="submit" value="Buscar" style="margin-right:0px" />

            <span style="float:left; margin:6px 5px 0px 25px;">Estado de usuario: </span>
            <select name="usu_est" id="usu_est" style="float:left; width:auto">
                <option value="99"<?=!isset($_SESSION['usu_est'])||$_SESSION['usu_est']=='99'?' selected="selected"':''?>>Todos</option>
                <option value="1"<?=isset($_SESSION['usu_est'])&&$_SESSION['usu_est']=='1'?' selected="selected"':''?>>Activo</option>
                <option value="3"<?=isset($_SESSION['usu_est'])&&$_SESSION['usu_est']=='3'?' selected="selected"':''?>>Inactivo</option>
                <option value="2"<?=isset($_SESSION['usu_est'])&&$_SESSION['usu_est']=='2'?' selected="selected"':''?>>Pte. datos</option>
            </select>
            
            <input type="submit" value="Descargar" style="margin-right:0px; padding:0px; background-color:transparent; color:#0C3" form="excel_usuarios" />
            <input type="hidden" form="excel_usuarios" name="tipo_archivo" id="tipo_archivo" value="listado_excel_usuarios" />
        </div>
    </form>
        
	<div class="linea usuario titulos">
		<!--<div class="lin_campo" style="width:100px">
			<span>NICK</span>
		</div>-->
		<div class="lin_campo" style="width:260px">
			<span>CORREO DE ACCESO</span>
		</div>
        <div class="lin_campo" style="width:110px">
			<span>ALTA</span>
		</div>
        <div class="lin_campo" style="width:110px">
            <span>BAJA</span>
        </div>
		<div class="lin_campo" style="width:110px">
			<span>RANGO</span>
		</div>
		<div class="lin_campo" style="width:55px">
			<span>ESTADO</span>
		</div>
		<div class="lin_campo" style="width:160px">
			<span>TALLER</span>
		</div>
        <div class="lin_campo" style="width:16px; border:0px">
			<span>&nbsp;</span>
		</div>
	</div>
<?php 
if(count($usuarios)>0){
	foreach($usuarios as $key=>$usuario){?>
	<div class="linea usuario cambiab<?=$key%2!=0?' par':''?>">
		<!--<div class="lin_campo" style="width:100px">
			<span><?/*=$usuario->us_nick*/?></span>
		</div>-->
		<div class="lin_campo" style="width:260px">
			<span><?=$usuario->us_correo?></span>
		</div>
        <div class="lin_campo" style="width:110px">
			<span><?=fecha($usuario->us_fecha_alta)?></span>
		</div>
        <div class="lin_campo" style="width:110px">
            <span><?=$usuario->us_estado==3 && $usuario->us_fecha_baja!='0000-00-00 00:00:00'?fecha($usuario->us_fecha_baja):'---'?></span>
        </div>
		<div class="lin_campo" style="width:110px">
			<span><?=dato_rango($usuario->us_rango, 'ru_nombre')?></span>
		</div>
		<div class="lin_campo" style="width:55px; text-align:center">
			<img src="<?=_RAIZ_?>imagenes/<?=$usuario->us_estado?>.png" title="<?=dato_estado($usuario->us_estado, 'eu_nombre')?>" >
		</div>
		<div class="lin_campo" style="width:160px">
			<span><?=u8d_(dato_taller('ta_nombre', $usuario->us_idtaller))?></span>
		</div>
        <div class="lin_campo" style="width:16px; text-align:center; border:0px">
        <?php if($usuario->us_rango!=1){?>
			<a href="<?=_RAIZ_.$m.'/editar_usuario/'.$usuario->us_idusuario.'/'?>"><img src="<?=_RAIZ_?>imagenes/editar.png" title="Editar usuario" ></a>
        <?php }?>
		</div>
	</div>
<?php }
}
$total_items=$total_filtrado;
$npaginas>1?include('includes/paginador.php'):'';


?>
</div>