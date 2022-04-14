<?php include('includes/cod_talleres.php')?>

<a href="<?=_RAIZ_.$m.'/listado_talleres/'?>" title="Listado de talleres" class="fs_16 nav_seccion<?=$seccion=='listado_talleres'?' activo':''?>">Listado</a>
<a href="<?=_RAIZ_.$m.'/nuevo_taller/'?>" title="Nuevo taller" class="fs_16 nav_seccion<?=$seccion=='nuevo_taller'?' activo':''?>">Nuevo taller</a>
<span title="Editar taller" class="fs_16 nav_seccion<?=$seccion=='editar_taller'?' activo':''?>"<?=$seccion=='editar_taller'?'':' style="display:none"'?>>Editar taller</span>

<br clear="all" />

<div class="cont_seccion">
<?php include('pages/secc_'.$seccion.'.php')?>
</div>