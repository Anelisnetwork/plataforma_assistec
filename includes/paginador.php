    <?php $primer_it=($pagina*$porpagina)-$porpagina+1;
	$ultimo_it=$pagina*$porpagina;
	$ultimo_it>$total_items?$ultimo_it=$total_items:'';?>
    <div style="float:left; margin-top:25px">
        Mostrando del <?=$primer_it?> al <?=$ultimo_it?> de <?=$total_items?>
    </div>
    
    <div style="float:right; margin-top:25px">
        <?php if($paganterior==0){?>
        <div style="float:left; margin-right:15px; width:13px; height:15px"></div>
        <?php } else {?>
        <a href="<?=$url?>pagina/1/" style="float:left; margin-right:15px" title="Ir a la primera página"><img src="<?=_RAIZ_?>imagenes/primero.png" style="border:0px" /></a>
        <?php }
        if($paganterior==0){?>
        <div style="float:left; margin-right:15px; width:10px; height:15px"></div>
        <?php } else {?>
        <a href="<?=$url?>pagina/<?=$paganterior?>/" style="float:left; margin-right:15px" title="Ir a la página anterior"><img src="<?=_RAIZ_?>imagenes/anterior.png" style="border:0px" /></a>
        <?php }?>
        <select name="sel_pag" id="sel_pag" style="width:auto; font-size:12px; float:left; margin-right:15px" class="form-select form-select-sm" title="Ir a la página" onchange="window.location = '<?=$url?>pagina/'+this.value+'/'">
        	<?php for($p=1;$p<=$npaginas;$p++){?>
            <option value="<?=$p?>"<?php if($p==$pagina){?> selected="selected"<?php }?> title="Ir a la página <?=$p?>"><?=$p?></option>
            <?php }?>
        </select>
        <?php if($pagsiguiente>$npaginas){?>
        <div style="float:left; margin-right:15px; width:10px; height:15px"></div>
        <?php } else {?>
        <a href="<?=$url?>pagina/<?=$pagsiguiente?>/" style="float:left; margin-right:15px" title="Ir a la página siguiente"><img src="<?=_RAIZ_?>imagenes/siguiente.png" style="border:0px" /></a>
        <?php }
        if($pagsiguiente>$npaginas){?>
        <div style="float:left; margin-right:15px; width:13px; height:15px"></div>
        <?php } else {?>
        <a href="<?=$url?>pagina/<?=$npaginas?>/" style="float:left" title="Ir a la última página"><img src="<?=_RAIZ_?>imagenes/ultimo.png" style="border:0px" /></a>
        <?php }?>
    </div>
