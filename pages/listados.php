<?php include('includes/cod_listados.php');?>
<div class="cont_seccion">
	<form target="_blank" action="<?=_RAIZ_?>descarga_excel/" method="post" name="excel_listados" id="excel_listados">
        <input type="hidden" name="tipo_archivo" id="tipo_archivo" value="listado_filtros" />
    </form>
    
    <div class="listados_banda_titulo banda active" id="banda_tipoinf">
        <span class="titulo">TIPO DE INFORME</span>
        <span class="icon active" id="icon_tipoinf"></span>
        <span class="detalle" id="f_informe_nombre"></span>
    </div>
    <div class="listado_cont_filtros div_icon" id="tipoinf" style="display:block">
        <div class="line">
            <?
            /*
            0=Productividad
            1=Eficacia
            2=Rendimiento
            3=Margen vta. PR
            4=Nº de entradas
            5=Tiempo por entrada
            6=Importe medio por OR
            7=Importe de MO por OR
            8=Importe PR por OR
            9=Coste personal
            */
            $tipo_informes=array('Productividad', 'Eficacia', 'Rendimiento', 'Margen vta. PR', 'Nº de entradas', 'Tiempo por entrada', 'Importe medio por OR', 'Importe de MO por OR', 'Importe PR por OR', 'Coste personal');
            ?>

            <?php foreach($tipo_informes as $key=>$tipo_informe){?>
                <div class="subline" style="width: 250px">
                    <span class="label deinput" style="margin-left: 50px; font-weight: normal; width: 170px"><?=$tipo_informe?></span>
                    <input type="checkbox" class="sel_tipoinf" name="f_tipoinf_sel[]" id="f_tipoinf_sel<?=$key?>"<?=$key<=2?' checked="checked"':''?> value="<?=$key?>" style="float: left; margin: 7px;" form="excel_listados">
                </div>
            <?php }?>
        </div>
    </div>

    <div class="listados_banda_titulo banda" id="banda_portaller">
    	<span class="titulo">FILTRO POR TALLER O RED DE TALLERES</span>
        <span class="icon" id="icon_portaller"></span>
        <span class="detalle" id="f_taller_nombre"></span>
    </div>
    <div class="listado_cont_filtros div_icon" id="portaller">
    	<div class="line">
            <!--<span class="label deinput">Seleccione tipo:</span>
            <select name="f_tipo_taller" id="f_tipo_taller" style="margin-left:15px; padding: 6px; height: 31px; float: left" form="excel_listados">
                <option value="1">Taller independiente</option>
                <option value="2">Red de talleres</option>
            </select>-->

            <span class="label deinput" style="margin-left:0px">Indique el nombre del taller o la red de talleres:</span>
            <input type="text" name="f_nombre_taller" id="f_nombre_taller" value="" style="margin-left:15px; float: left; width: 350px" form="excel_listados"/>
            
            <input type="hidden" name="f_tipo_taller" id="f_tipo_taller" value="1" form="excel_listados" />
            <input type="hidden" name="f_id_taller" id="f_id_taller" value="" form="excel_listados" />
        </div>
    </div>

    <div class="listados_banda_titulo banda" id="banda_porprov">
    	<span class="titulo">FILTRO POR PROVINCIA</span>
        <span class="icon" id="icon_porprov"></span>
        <span class="detalle" id="f_prov_nombre">TODAS</span>
    </div>
    <div class="listado_cont_filtros div_icon" id="porprov">
    	<div class="line">
            <span class="label deinput">Seleccione provincias:</span>

            <input type="checkbox" name="f_prov_todas" id="f_prov_todas" checked="checked" disabled="disabled" value="ALL" style="float: right; margin: 7px;" form="excel_listados">
            <span class="label deinput" style="float: right; font-weight: normal;">Seleccionar todas</span>
        </div>
            
        <div class="line">
        <?php foreach($provincias as $key=>$provincia){?>
            <div class="subline">
                <span class="label deinput" style="margin-left: 50px; font-weight: normal;"><?=u8_($provincia->prov_nombre)?></span>
                <input type="checkbox" class="porprov" name="f_prov_sel[]" id="f_prov_sel<?=$provincia->prov_idcp?>" checked="checked" disabled="disabled" value="<?=$provincia->prov_idcp?>" style="float: left; margin: 7px;" form="excel_listados">
            </div>
        <?php }?>
        </div>
    </div>

    <?php
    $anhosel=date('m')==1?date('Y')-1:date('Y');
    $mespasado=date('m')==1?12:date('m')-1;
    ?>
    <div class="listados_banda_titulo banda" id="banda_porfecha">
        <span class="titulo">FILTRO POR FECHAS</span>
        <span class="icon" id="icon_porfecha"></span>
        <span class="detalle" id="f_fecha_nombre"><strong>Seleccionado:</strong> Año <?=$anhosel?> (<?=ucwords(nombremes($anhosel.'-'.$mespasado.'-01','ES'))?>)</span>
    </div>
    <div class="listado_cont_filtros div_icon" id="porfecha">
        <!--<div class="line">
            <span class="label deinput">POR AÑO Y MES:</span>
            <input type="radio" checked="checked" name="f_porfecha" id="f_porfecha_1" style="margin-left:15px; margin-top: 6px; float: left">
            
            <input type="radio" name="f_porfecha" id="f_porfecha_2" style="margin-left:15px; margin-top: 6px; float: right">
            <span class="label deinput" style="float: right;">ENTRE FECHAS:</span>
        </div>-->

        <div class="line" style="margin-top: 15px">
            <span class="label deinput">Seleccione año:</span>
            <select name="f_anho" id="f_anho" style="margin-left:15px; padding: 6px; height: 31px; float: left" form="excel_listados">
            <?php for($anho=date('Y');$anho>=2016;$anho--){?>
                <option value="<?=$anho?>"<?=$anho==$anhosel?' selected="selected"':''?>><?=$anho?></option>
            <?php }?>
            </select>
        </div>

        <div class="line" style="margin-top: 15px">
            <span class="label deinput">Seleccione mes/es:</span>
            <br clear="all">
            <?php for($mes=1;$mes<=12;$mes++){
                $fecha=date('Y').'-'.$mes.'-'.date('d');?>
            <span class="label deinput" style="margin-left: 15px; font-weight: normal;"><?=ucwords(substr(nombremes($fecha,'ES'), 0,3))?></span>
            <input type="checkbox" class="pormes" name="f_mes_sel[]" id="f_mes_sel<?=$mes?>"<?=$mes==$mespasado?' checked="checked"':''?> value="<?=$mes?>" style="float: left; margin: 7px;" form="excel_listados">
            <?php }?>
        </div>           
    </div>
    <br clear="all">
    <br clear="all">
    <div class="line" style="text-align: center;">
        <input type="submit" value="Descargar informe" style="margin-left: auto; margin-right: auto; float: none; width:150px" form="excel_listados" />
    </div>
</div>