<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <?php include 'includes/metas.php';?>
	<title>Plataforma Assitec Online - <?=nom_modulo($m)?><?=$seccion!=''?' - '.nom_seccion($seccion):''?></title>
    <?php include 'includes/recursos.php';?>
    <script>
	$(document).ready(function() {
	 mueveReloj();
	})
	</script>
</head>

<body id="panel">
	<div class="centrado">
    	<div class="menu">
        	<a href="<?=_RAIZ_.'inicio/'?>" class="logo"></a>
            <div class="sep_menu"></div>
            <?php foreach($lista_pages as $npage){?>
            <a href="<?=_RAIZ_.$npage->mo_url.'/'?>" title="<?=nom_modulo($npage->mo_url)?>" id="menunav_<?=str_replace('_','',$npage->mo_url)?>" class="fs_16 nav<?=$npage->mo_url==$m?' activo':''?> "><?=nom_modulo($npage->mo_url)?></a>
            <?php }?>
        </div>
        <div class="cabecera">
        	<span class="fs_16"><?=nom_dia(date('w'))?> <?=date('d')?> de <?=nom_mes(date('n'))?> de <?=date('Y')?> &nbsp;&nbsp;&nbsp;&nbsp; <span id="imp_hora"><?=date('H')?>:<?=date('i')?>:<?=date('s')?></span></span>
            <span class="fs_16" style="float:right">Conectado como: &nbsp;&nbsp;&nbsp;&nbsp;<span class="texto_r ubuntu_b"><?=dame_dato_usuario('us_nick')?></span><a href="<?=_RAIZ_?>salir.php"><img src="<?=_RAIZ_?>imagenes/salir.png" title="Salir" alt="Salir" id="salir" /></a></span>
        </div>
        <div class="contenido">
        	<?php include('pages/'.$m.'.php')?>
        </div>
    </div>

</body>
<?php //unset($_SESSION['datos_'._ID_PAG_]['idusuario']);?>
</html>