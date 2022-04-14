<?php include('includes/cod_promociones.php')?>

<a href="<?=_RAIZ_.$m.'/listado_promociones/'?>" title="Listado de promociones" class="fs_16 nav_seccion<?=$seccion=='listado_promociones'?' activo':''?>">Listado</a>
<a href="<?=_RAIZ_.$m.'/nueva_promocion/'?>" title="Nueva promoci&oacute;n" class="fs_16 nav_seccion<?=$seccion=='nueva_promocion'?' activo':''?>">Nueva promoci&oacute;n</a>
<span title="Editar promoci&oacute;n" class="fs_16 nav_seccion<?=$seccion=='editar_promocion'?' activo':''?>"<?=$seccion=='editar_promocion'?'':' style="display:none"'?>>Editar promoci&oacute;n</span>

<br clear="all" />

<div class="cont_seccion">
<?php include('pages/secc_'.$seccion.'.php')?>
</div>