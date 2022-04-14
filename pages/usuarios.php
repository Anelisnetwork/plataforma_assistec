<?php include('includes/cod_usuarios.php')?>

<a href="<?=_RAIZ_.$m.'/listado_usuarios/'?>" title="Listado de usuarios" class="fs_16 nav_seccion<?=$seccion=='listado_usuarios'?' activo':''?>">Listado</a>
<a href="<?=_RAIZ_.$m.'/nuevo_usuario/'?>" title="Nuevo usuario" class="fs_16 nav_seccion<?=$seccion=='nuevo_usuario'?' activo':''?>">Nuevo usuario</a>
<span title="Editar usuario" class="fs_16 nav_seccion<?=$seccion=='editar_usuario'?' activo':''?>"<?=$seccion=='editar_usuario'?'':' style="display:none"'?>>Editar usuario</span>

<br clear="all" />

<div class="cont_seccion">
<?php include('pages/secc_'.$seccion.'.php')?>
</div>