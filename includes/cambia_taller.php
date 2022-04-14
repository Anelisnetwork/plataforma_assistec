<?php
$idtaller=clean_post('idtaller');

$_SESSION['datos_'._ID_PAG_]['datos_user']['idtaller']=fetch_array('SELECT ta_idtaller from talleres where ta_idparent='.$_SESSION['datos_'._ID_PAG_]['datos_user']['idred'].' and ta_idtaller='.$idtaller.'','ta_idtaller');
?>