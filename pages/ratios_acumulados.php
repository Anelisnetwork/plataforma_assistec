<?php 
$dato_mensual=ultimo_dato();
$iddato=isset($dato_mensual[0]->da_iddato)?$dato_mensual[0]->da_iddato:'';

if($iddato==''||$iddato==NULL){?>

    <div style="text-align:center; width:100%; padding:20px 0px"><span class="oswald texto_r fs_16">Todav&iacute;a no existen datos para elaborar un informe</span></div>
	
<?php }
else{
	$anhos=dame_anhos();
	
	$anho_acumulado=$dato_mensual[0]->da_ano;
	
	
	
	$datos_guardados=datos_guardados();
	
	if(isset($_GET['anho'])){
		num_rows('select da_iddato from datos_actividad where da_ano='.clean_get('anho').' and da_idtipo=1')<=0?'':$anho_acumulado=clean_get('anho');
	}
	
	$datos_acumulados=dame_acumulado($anho_acumulado);
	
	$alano=$anho_acumulado;
	$masget=$alano!=''?'/'.$alano:'';
	
	$iddato=$dato_mensual[0]->da_iddato;

    $porcentajes=personal_porcentaje($_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']);
	
}

if(count($secciones)>0){
	foreach($secciones as $secc){?>
<a href="<?=_RAIZ_.$m.'/'.$secc->sc_url.$masget.'/'?>" title="<?=nom_seccion($secc->sc_url)?>" class="fs_16 nav_seccion<?=$secc->sc_url==$seccion?' activo':''?>"><?=nom_seccion($secc->sc_url)?></a>
<?php }
}?>

<div style="float:right; margin: 6px 10px;">
    <?php if (count($anhos)==0){?>
        <span class="dato_hist">NO HAY DATOS</span>
    <?php }
    else{?>
        <span class="oswald" style="float: left; margin-right: 10px">Seleccione período</span>
    <select style="float: left; padding: 3px 10px;" onchange="window.location.href ='<?=_RAIZ_?>ratios_acumulados/<?=$seccion?>/'+this.value+'/'">
        <? foreach($anhos as $anho){?>
            <option value="<?=$anho->da_ano?>"<?=$anho->da_ano==$anho_acumulado?' selected':''?>>A&ntilde;o <?=$anho->da_ano?></option>
        <? }?>
    </select>
    <?php }?>
</div>

<br clear="all" />

<div class="cont_seccion" id="secc-<?=$seccion?>">
<?php include('pages/secc_'.$seccion.'.php');?>
</div>
