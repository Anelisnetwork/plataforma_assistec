<?php
require_once('core/core.php');

open_bd();

isset($_POST['idproceso'])?$idproceso=clean_post('idproceso'):(isset($_GET['idproceso'])?$idproceso=clean_get('idproceso'):fuera_de_aqui());

if($idproceso=='acceso'){//UN CLIENTE SE ESTÁ LOGUEANDO
	
	include(_ZEND_.'includes/acceso_cte.php');
	
}//UN CLIENTE SE ESTÁ LOGUEANDO
else if($idproceso=='silent_login'){//UN CLIENTE ESTÁ ACCEDIENDO EN SILENCIO
	
	include(_ZEND_.'includes/silent_login.php');
	
}//UN CLIENTE ESTÁ ACCEDIENDO EN SILENCIO
else if($idproceso=='nuevapass'){//UN CLIENTE OLVIDÓ LA CONTRASEÑA

	include(_ZEND_.'includes/nuevapass.php');

}//UN CLIENTE OLVIDÓ LA CONTRASEÑA
else if($idproceso=='edita_empleado'){//AÑADIMOS O EDITAMOS UN EMPLEADO
	
	include(_ZEND_.'includes/edita_empleado.php');
	
}//AÑADIMOS O EDITAMOS UN EMPLEADO
else if($idproceso=='edita_equipamiento'){//AÑADIMOS O EDITAMOS UN EQUIPAMIENTO
	
	include(_ZEND_.'includes/edita_equipamiento.php');
	
}//AÑADIMOS O EDITAMOS UN EQUIPAMIENTO
else if($idproceso=='datos_generales'){//EDITAMOS DATOS GENERALES
	
	include(_ZEND_.'includes/edita_datos_generales.php');
	
}//EDITAMOS DATOS GENERALES
else if($idproceso=='datos_facturacion'){//EDITAMOS DATOS DE FACTURACION
	
	include(_ZEND_.'includes/edita_datos_facturacion.php');
	
}//EDITAMOS DATOS DE FACTURACION
else if($idproceso=='datos_acceso'){//CAMBIAMOS DATOS DE ACCESO
	
	include(_ZEND_.'includes/edita_datos_acceso.php');
	
}//CAMBIAMOS DATOS DE FACTURACION
else if($idproceso=='logo_corporativo'){//CAMBIAMOS LOGOTIPO

	include(_ZEND_.'includes/edita_logo_corporativo.php');

}//CAMBIAMOS LOGOTIPO
else if($idproceso=='edita_info'){//MODIFICAMOS INFORMACIÓN
	
	include(_ZEND_.'includes/edita_informacion.php');
	
}//MODIFICAMOS INFORMACIÓN
else if($idproceso=='edita_gastos'){//MODIFICAMOS GASTOS GENERALES

    include(_ZEND_.'includes/edita_gastos.php');

}//MODIFICAMOS GASTOS GENERALES
else if($idproceso=='edita_actividad'){//MODIFICAMOS ACTIVIDAD
	
	include(_ZEND_.'includes/edita_actividad.php');
	
}//MODIFICAMOS ACTIVIDAD
else if($idproceso=='edita_datosactividad'){//MODIFICAMOS ACTIVIDAD
	
	include(_ZEND_.'includes/edita_datosactividad.php');
	
}//MODIFICAMOS ACTIVIDAD
else if($idproceso=='edita_datomensual'){//MODIFICAMOS DATO MENSUAL
	
	include(_ZEND_.'includes/edita_datomensual.php');
	
}//MODIFICAMOS DATO MENSUAL
else if($idproceso=='edita_usuario'){//MODIFICAMOS DATOS DE USUARIO
	
	include(_ZEND_.'includes/edita_usuario.php');
	
}//MODIFICAMOS DATOS DE USUARIO
else if($idproceso=='nuevo_usuario'){//NUEVO USUARIO
	
	include(_ZEND_.'includes/nuevo_usuario.php');
	
}//NUEVO USUARIO
else if($idproceso=='nuevo_taller'){//NUEVO TALLER
	
	include(_ZEND_.'includes/nuevo_taller.php');
	
}//NUEVO TALLER
else if($idproceso=='edita_taller'){//EDITAR TALLER
	
	include(_ZEND_.'includes/edita_taller.php');
	
}//EDITAR TALLER
else if($idproceso=='emitir_factura'){//EMITIR FACTURA
	
	include(_ZEND_.'includes/emitir_factura.php');
	
}//EMITIR FACTURA
else if($idproceso=='editar_factura'){//EDITAR FACTURA
	
	include(_ZEND_.'includes/editar_factura.php');
	
}//EDITAR FACTURA
else if($idproceso=='contacto'){//FORMULARIO DE CONTACTO
	
	include(_ZEND_.'includes/contacto.php');
	
}//EDITA PROMOCION
else if($idproceso=='edita_promocion'){//EDITA PROMOCION
	
	include(_ZEND_.'includes/edita_promocion.php');
	
}//EDITA PROMOCION
else{
    // Comprobamos si el archivo existe
    if(!file_exists(_ZEND_.'includes/'.$idproceso.'.php')){
        fuera_de_aqui('');
    }
    include(_ZEND_.'includes/'.$idproceso.'.php');
}

close_bd();
?>