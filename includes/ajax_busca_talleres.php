<?php
$busqueda=addslashes(strip_tags($_POST['term']));

$talleres=list_object('SELECT ta_idtaller, ta_nombre, ta_idtipo from talleres, usuarios_facturacion where ta_idtaller=uf_idtaller and (ta_nombre like "%'.$busqueda.'%" or ta_contacto like "%'.$busqueda.'%" or ta_socio like "%'.$busqueda.'%" or ta_email like "%'.$busqueda.'%" or uf_denomsoc like "%'.$busqueda.'%" or uf_cifnif like "%'.$busqueda.'%" or uf_nomcom like "%'.$busqueda.'%" or uf_contacto like "%'.$busqueda.'%" or uf_email like "%'.$busqueda.'%") group by ta_idtaller limit 0,20');

echo u8d_(json_encode($talleres));
?>