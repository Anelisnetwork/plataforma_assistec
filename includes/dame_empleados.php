<?php
$porcentajes=personal_porcentaje($_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']);
?>

<div>
    <div id="res_empleados_total"><?=$porcentajes[0]?></div>
    <div id="res_empleados_directos"><?=$porcentajes[4]?></div>
    <div id="res_empleados_dir_porc"><?=$porcentajes[2]?></div>
    <div id="res_empleados_indirectos"><?=$porcentajes[5]?></div>
    <div id="res_empleados_indir_porc"><?=$porcentajes[3]?></div>
</div>
