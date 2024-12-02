<?php
/*
 * INSERT INTO `secciones` (`sc_idseccion`, `sc_idmodulo`, `sc_nombre`, `sc_url`, `sc_orden`) VALUES (NULL, '2', 'gastos generales', 'gastos_generales', '7');
 * UPDATE `secciones` SET `sc_nombre` = 'Gastos generales' WHERE `secciones`.`sc_idseccion` = 29;
 */
if(isset($_SESSION['datos_'._ID_PAG_]['edita_gastos']['hayerrores'])){
    if($_SESSION['datos_'._ID_PAG_]['edita_gastos']['hayerrores']==1){?>
        <script>
            alertify.error("No se ha podido guardar");
        </script>
    <?php }
    else{?>
        <script>
            alertify.success("Guardado correctamente");
        </script>
    <?php }
}
$infotaller=dame_gastos($_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']);

$idtaller=$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller'];

$haydatos=count($infotaller)==1;

$nominas=$haydatos?$infotaller[0]->nominas:0;
$seg_social=$haydatos?$infotaller[0]->seg_social:0;
$alquileres=$haydatos?$infotaller[0]->alquileres:0;
$suministros=$haydatos?$infotaller[0]->suministros:0;
$renting=$haydatos?$infotaller[0]->renting:0;
$serv_prof=$haydatos?$infotaller[0]->serv_prof:0;
$cuotas=$haydatos?$infotaller[0]->cuotas:0;
$amortizaciones=$haydatos?$infotaller[0]->amortizaciones:0;
$otros=$haydatos?$infotaller[0]->otros:0;


$porcentajes=personal_porcentaje($_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']);

?>
    <div id="infotaller" class="div_mostrarocultar" style="float:left;">
        <form action="<?=_RAIZ_?>procesando.php" method="post" name="edita_gastos" id="edita_gastos">
            <input type="hidden" id="idproceso" name="idproceso" value="edita_gastos" />
            <input type="hidden" id="url_dest" name="url_dest" value="<?=_RAIZ_?>datos_del_taller/gastos_generales" />
            <input type="hidden" id="idtaller" name="idtaller" value="<?=$idtaller?>" />
            <div class="linea">
                <label for="nominas_<?=$idtaller?>" class="ancho">Coste personal:</label><input type="text" id="nominas_<?=$idtaller?>" name="nominas_<?=$idtaller?>" class="peq orig" value="<?=$nominas?>" style="width:70px; text-align:right" onkeyup="comprueba_cambios('edita_gastos')"><span class="fs_14" style="float:left; margin:7px;">&euro;</span>
                <input type="hidden" id="nominas_<?=$idtaller?>_def" name="nominas_<?=$idtaller?>_def" value="<?=$nominas?>" />
                <input type="submit" style="display:none" id="edita_gastos_<?=$idtaller?>" name="edita_gastos_<?=$idtaller?>" value="Guardar" />
            </div>
            <div class="linea">
                <label for="seg_social_<?=$idtaller?>" class="ancho">Coste Seg. social trab.:</label><input type="text" id="seg_social_<?=$idtaller?>" name="seg_social_<?=$idtaller?>" class="peq orig" value="<?=$seg_social?>" style="width:70px; text-align:right" onkeyup="comprueba_cambios('edita_gastos')"><span class="fs_14" style="float:left; margin:7px;">&euro;</span>
                <input type="hidden" id="seg_social_<?=$idtaller?>_def" name="seg_social_<?=$idtaller?>_def" value="<?=$seg_social?>" />
            </div>
            <div class="linea">
                <label for="gastos_pers_<?=$idtaller?>" class="texto_r ancho">Total gastos de personal:</label>
                <input type="text" id="gastos_pers_<?=$idtaller?>" name="gastos_pers_<?=$idtaller?>" class="peq orig" value="<?=$nominas+$seg_social?>" style="width:70px; text-align:right; background-color:#ffd7b4" disabled>
                <span class="fs_14" style="float:left; margin:7px;">&euro;</span>
            </div>

            <div class="linea">
                <label for="alquileres_<?=$idtaller?>" class="ancho">Alquileres:</label><input type="text" id="alquileres_<?=$idtaller?>" name="alquileres_<?=$idtaller?>" class="peq orig" value="<?=$alquileres?>" style="width:70px; text-align:right" onkeyup="comprueba_cambios('edita_gastos')"><span class="fs_14" style="float:left; margin:7px;">&euro;</span>
                <input type="hidden" id="alquileres_<?=$idtaller?>_def" name="alquileres_<?=$idtaller?>_def" value="<?=$alquileres?>" />
            </div>
            <div class="linea">
                <label for="suministros_<?=$idtaller?>" class="ancho">Suministros:</label><input type="text" id="suministros_<?=$idtaller?>" name="suministros_<?=$idtaller?>" class="peq orig" value="<?=$suministros?>" style="width:70px; text-align:right" onkeyup="comprueba_cambios('edita_gastos')"><span class="fs_14" style="float:left; margin:7px;">&euro;</span>
                <input type="hidden" id="suministros_<?=$idtaller?>_def" name="suministros_<?=$idtaller?>_def" value="<?=$suministros?>" />
            </div>
            <div class="linea">
                <label for="renting_<?=$idtaller?>" class="ancho">Renting de equipos:</label><input type="text" id="renting_<?=$idtaller?>" name="renting_<?=$idtaller?>" class="peq orig" value="<?=$renting?>" style="width:70px; text-align:right" onkeyup="comprueba_cambios('edita_gastos')"><span class="fs_14" style="float:left; margin:7px;">&euro;</span>
                <input type="hidden" id="renting_<?=$idtaller?>_def" name="renting_<?=$idtaller?>_def" value="<?=$renting?>" />
            </div>
            <div class="linea">
                <label for="serv_prof_<?=$idtaller?>" class="ancho">Servicios profesionales:</label><input type="text" id="serv_prof_<?=$idtaller?>" name="serv_prof_<?=$idtaller?>" class="peq orig" value="<?=$serv_prof?>" style="width:70px; text-align:right" onkeyup="comprueba_cambios('edita_gastos')"><span class="fs_14" style="float:left; margin:7px;">&euro;</span>
                <input type="hidden" id="serv_prof_<?=$idtaller?>_def" name="serv_prof_<?=$idtaller?>_def" value="<?=$serv_prof?>" />
            </div>
            <div class="linea">
                <label for="cuotas_<?=$idtaller?>" class="ancho">Cuotas:</label><input type="text" id="cuotas_<?=$idtaller?>" name="cuotas_<?=$idtaller?>" class="peq orig" value="<?=$cuotas?>" style="width:70px; text-align:right" onkeyup="comprueba_cambios('edita_gastos')"><span class="fs_14" style="float:left; margin:7px;">&euro;</span>
                <input type="hidden" id="cuotas_<?=$idtaller?>_def" name="cuotas_<?=$idtaller?>_def" value="<?=$cuotas?>" />
            </div>
            <div class="linea">
                <label for="amortizaciones_<?=$idtaller?>" class="ancho">Amortizaciones:</label><input type="text" id="amortizaciones_<?=$idtaller?>" name="amortizaciones_<?=$idtaller?>" class="peq orig" value="<?=$amortizaciones?>" style="width:70px; text-align:right" onkeyup="comprueba_cambios('edita_gastos')"><span class="fs_14" style="float:left; margin:7px;">&euro;</span>
                <input type="hidden" id="amortizaciones_<?=$idtaller?>_def" name="amortizaciones_<?=$idtaller?>_def" value="<?=$amortizaciones?>" />
            </div>
            <div class="linea">
                <label for="otros_<?=$idtaller?>" class="ancho">Otros gastos:</label><input type="text" id="otros_<?=$idtaller?>" name="otros_<?=$idtaller?>" class="peq orig" value="<?=$otros?>" style="width:70px; text-align:right" onkeyup="comprueba_cambios('edita_gastos')"><span class="fs_14" style="float:left; margin:7px;">&euro;</span>
                <input type="hidden" id="otros_<?=$idtaller?>_def" name="otros_<?=$idtaller?>_def" value="<?=$otros?>" />
            </div>
            <div class="linea">
                <label for="gastos_estruc_<?=$idtaller?>" class="texto_r ancho">Total gastos de estructura:</label>
                <input type="text" id="gastos_estruc_<?=$idtaller?>" name="gastos_estruc_<?=$idtaller?>" class="peq orig" value="<?=$alquileres+$suministros+$renting+$serv_prof+$cuotas+$amortizaciones+$otros?>" style="width:70px; text-align:right; background-color:#ffd7b4" disabled>
                <span class="fs_14" style="float:left; margin:7px;">&euro;</span>
            </div>

    </div>
<?php unset($_SESSION['datos_'._ID_PAG_]['edita_gastos']);?>