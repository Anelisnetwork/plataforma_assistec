<?php if(count($secciones)>0){
foreach($secciones as $secc){?>
<a href="<?=_RAIZ_.$m.'/'.$secc->sc_url.'/'?>" title="<?=nom_seccion($secc->sc_url)?>" class="fs_16 nav_seccion<?=$secc->sc_url==$seccion?' activo':''?>"><?=nom_seccion($secc->sc_url)?></a>
<?php }
}?>

<br clear="all" />

<div class="cont_seccion" id="secc-<?=$seccion?>">
<?php include('pages/secc_'.$seccion.'.php')?>
</div>