<?php 
$dato_mensual=ultimo_dato();
$iddato=isset($dato_mensual[0]->da_iddato)?$dato_mensual[0]->da_iddato:'';
$datos_guardados = [];

if($iddato==''||$iddato==NULL){?>

    <div style="text-align:center; width:100%; padding:20px 0px"><span class="oswald texto_r fs_16">Todav&iacute;a no existen datos para elaborar un informe</span></div>
	
<?php }
else{
	$almes=$dato_mensual[0]->da_mes;
	$alano=$dato_mensual[0]->da_ano;
	$masget=$almes!=''&&$alano!=''?'/'.$almes.'/'.$alano:'';
	
	$datos_guardados=datos_guardados();
	
	if(isset($_GET['mes'])&&isset($_GET['anho'])){
		$dato_mes=datos_actividad(1, clean_get('mes'), clean_get('anho'));
		if(count($dato_mes)==1){
			$dato_mensual=$dato_mes;
			$almes=clean_get('mes');
			$alano=clean_get('anho');
			$masget=$almes!=''&&$alano!=''?'/'.$almes.'/'.$alano:'';
		}
	}
	
	$iddato=$dato_mensual[0]->da_iddato;
	
	
}

if(count($secciones)>0 && isset($masget)){
foreach($secciones as $secc){?>
<a href="<?=_RAIZ_.$m.'/'.$secc->sc_url.$masget.'/'?>" title="<?=nom_seccion($secc->sc_url)?>" class="fs_16 nav_seccion<?=$secc->sc_url==$seccion?' activo':''?>"><?=nom_seccion($secc->sc_url)?></a>
<?php }
}?>

<div style="float:right; margin: 6px 10px;">
    <?php if (count($datos_guardados)==0){?>
        <span class="dato_hist">NO HAY DATOS</span>
    <?php }
    else{?>
        <span class="oswald" style="float: left; margin-right: 10px">Seleccione mes</span>
        <select style="float: left; padding: 3px 10px;" onchange="window.location.href ='<?=_RAIZ_?>informes_del_mes/<?=$seccion?>/'+this.value+'/'">
            <? foreach($datos_guardados as $dato_guardado){?>
                <option value="<?=$dato_guardado->da_mes.'/'.$dato_guardado->da_ano?>"<?=(nom_mes($dato_mensual[0]->da_mes).' '.$dato_mensual[0]->da_ano)==(nom_mes($dato_guardado->da_mes).' '.$dato_guardado->da_ano)?' selected':''?>><?=nom_mes($dato_guardado->da_mes).' '.$dato_guardado->da_ano?></option>
            <? }?>
        </select>
    <?php }?>
</div>

<br clear="all" />

<div class="cont_seccion" id="secc-<?=$seccion?>">
<?php include('pages/secc_'.$seccion.'.php');?>
</div>
