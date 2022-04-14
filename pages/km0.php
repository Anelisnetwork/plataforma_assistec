<?php if(count($secciones)>0){
foreach($secciones as $secc){?>
<a href="<?=_RAIZ_.$m.'/'.$secc->sc_url.'/'?>" title="<?=nom_seccion($secc->sc_url)?>" class="fs_16 nav_seccion<?=$secc->sc_url==$seccion?' activo':''?>"><?=nom_seccion($secc->sc_url)?></a>
<?php }
}?>

<br clear="all" />

<div class="cont_seccion" id="secc-<?=$seccion?>">
<?php 
$dato_mensual=datos_actividad();

$iddato=isset($dato_mensual[0]->da_iddato)?$dato_mensual[0]->da_iddato:'';

if($iddato==''||$iddato==NULL){?>

    <div style="text-align:center; width:100%; padding:20px 0px"><span class="oswald texto_r fs_16">Todav&iacute;a no existen datos para elaborar un informe</span></div>
	
<?php }
else{
	include('pages/secc_'.$seccion.'.php');
}
?>
</div>
