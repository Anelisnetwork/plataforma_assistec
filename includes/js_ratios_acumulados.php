<?php
if(isset($seccion) && $seccion != '') {
    if (file_exists(_PATH_ . 'includes/js_' . $seccion . '.php')) {
        include_once(_PATH_ . 'includes/js_' . $seccion . '.php');
    }
}
?>