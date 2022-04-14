<?php 
if(isset($_SESSION['datos_'._ID_PAG_]['edita_equipamiento']['hayerrores'])){
	if($_SESSION['datos_'._ID_PAG_]['edita_equipamiento']['hayerrores']==1){?>
    <script>
	alertify.error("No se ha podido guardar");
	</script>
	<?php }
	else{?>
    <script>
	alertify.success("Guardado correctamente");
	</script>
	<?php }
}

$tipos_equipamiento=tipos_equipamiento();

$equipamientos=dame_equipamiento($_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']);?>
<div class="linea">
	<span style="float:left" class="oswald fs_16">A&Ntilde;ADIR EQUIPAMIENTO</span><div class="link mostrarocultar" id="mostrarocultar_nuevoequipo"></div>
</div>
<div id="nuevoequipo" class="div_mostrarocultar" style="display:none">
	<div class="linea equipo_NEW">
        <form action="<?=_RAIZ_?>procesando.php" method="post" name="nuevo_equipamiento" id="nuevo_equipamiento">
            <input type="hidden" id="idproceso" name="idproceso" value="edita_equipamiento" />
            <input type="hidden" id="url_dest" name="url_dest" value="<?=_RAIZ_?>datos_del_taller/equipamiento" />
            <input type="hidden" id="idequipo" name="idequipo" value="NEW" />
            <input type="hidden" id="idtaller" name="idtaller" value="<?=$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']?>" />
            <label for="tipo_NEW">Equipamiento:</label>
            <select id="tipo_NEW" name="tipo_NEW">
            <?php foreach($tipos_equipamiento as $tipo_equipamiento){?>
                <option value="<?=$tipo_equipamiento->te_idequip?>"><?=$tipo_equipamiento->te_nombre?></option>
            <?php }?>
            </select>
            <label for="cantidad_NEW" style="width:auto; margin:0px 5px">X</label>
            <input type="number" id="cantidad_NEW" name="cantidad_NEW" value="1" min="0" max="100" step="1">
            <input type="text" id="notas_NEW" name="notas_NEW" value="<?=isset($_SESSION['datos_'._ID_PAG_]['edita_equipamiento']['notas_NEW'])?$_SESSION['datos_'._ID_PAG_]['edita_equipamiento']['notas_NEW']:''?>" placeholder="Notas" style="width:350px; margin-left:15px">
            <input type="submit" id="guardaequipo_NEW" name="guardaequipo_NEW" value="Guardar" style="margin:0px" />
        </form>
    </div>
</div>
<div id="contequipos" class="div_mostrarocultar">
<?php if(count($equipamientos)>0){
	foreach($equipamientos as $equipamiento){?>
    <div class="linea equipo" id="it_equipamiento_<?=$equipamiento->et_idequip?>">
    	<form action="<?=_RAIZ_?>procesando.php" method="post" name="nuevo_equipamiento" id="nuevo_equipamiento">
            <input type="hidden" id="idproceso" name="idproceso" value="edita_equipamiento" />
            <input type="hidden" id="url_dest" name="url_dest" value="<?=_RAIZ_?>datos_del_taller/equipamiento" />
            <input type="hidden" id="idequipo" name="idequipo" value="<?=$equipamiento->et_idequip?>" />
            <input type="hidden" id="idtaller" name="idtaller" value="<?=$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']?>" />
            <label for="tipo_<?=$equipamiento->et_idequip?>">Equipamiento:</label>
            <select id="tipo_<?=$equipamiento->et_idequip?>" name="tipo_<?=$equipamiento->et_idequip?>">
            <?php foreach($tipos_equipamiento as $tipo_equipamiento){?>
                <option value="<?=$tipo_equipamiento->te_idequip?>"<?=$tipo_equipamiento->te_idequip==$equipamiento->et_idtipo?' selected="selected"':''?>><?=$tipo_equipamiento->te_nombre?></option>
            <?php }?>
            </select>
            <input type="hidden" id="tipo_<?=$equipamiento->et_idequip?>_def" name="tipo_<?=$equipamiento->et_idequip?>_def" value="<?=$equipamiento->et_idtipo?>" />
            <label for="cantidad_<?=$equipamiento->et_idequip?>" style="width:auto; margin:0px 5px">X</label>
            <input type="number" id="cantidad_<?=$equipamiento->et_idequip?>" name="cantidad_<?=$equipamiento->et_idequip?>" value="<?=$equipamiento->et_cantidad?>" min="0" max="100" step="1" onchange="comprueba_cambios_equipo('<?=$equipamiento->et_idequip?>')" onkeyup="comprueba_cambios_equipo('<?=$equipamiento->et_idequip?>')">
            <input type="hidden" id="cantidad_<?=$equipamiento->et_idequip?>_def" name="cantidad_<?=$equipamiento->et_idequip?>_def" value="<?=$equipamiento->et_cantidad?>" />
            <input type="text" id="notas_<?=$equipamiento->et_idequip?>" name="notas_<?=$equipamiento->et_idequip?>" value="<?=u8d_($equipamiento->et_notas)?>" placeholder="Notas" style="width:350px; margin-left:15px" onkeyup="comprueba_cambios_equipo('<?=$equipamiento->et_idequip?>')">
            <input type="hidden" id="notas_<?=$equipamiento->et_idequip?>_def" name="notas_<?=$equipamiento->et_idequip?>_def" value="<?=u8d_($equipamiento->et_notas)?>" />
            <img class="eliminar link" src="<?=_RAIZ_?>imagenes/basura.png" title="Eliminar" onclick="eliminar('equipamiento', '<?=$equipamiento->et_idequip?>')" />
            <input type="submit" id="guardaequipo_<?=$equipamiento->et_idequip?>" name="guardaequipo_<?=$equipamiento->et_idequip?>" value="Guardar" style="margin:0px; display:none" />
        </form>
    </div>
<?php }
}
unset($_SESSION['datos_'._ID_PAG_]['edita_equipamiento']);?>
</div>