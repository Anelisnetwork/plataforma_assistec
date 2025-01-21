<?php

/* Abre conexion */

function open_bd(){
	$_SESSION['datos_'._ID_PAG_]['bd_connection'] = c_();
    mysqli_set_charset($_SESSION['datos_'._ID_PAG_]['bd_connection'], 'utf8');
    mysqli_report(MYSQLI_REPORT_OFF);
}

/* Cierra conexion */

function close_bd(){
	if ( isset($_SESSION['datos_'._ID_PAG_]['bd_connection']) ) {
		mysqli_close($_SESSION['datos_'._ID_PAG_]['bd_connection']);
		unset($_SESSION['datos_'._ID_PAG_]['bd_connection']);	
	}
}

/* Devuelve ID insertado */

function insertado(){
	return mysqli_insert_id($_SESSION['datos_'._ID_PAG_]['bd_connection']);
}

/* Ejecuta una consulta */

function query($sql){
    $link = $_SESSION['datos_'._ID_PAG_]['bd_connection'];
    $res = false;
    try {
        $res = mysqli_query($link,$sql);
    } catch (Exception $e) {
        $message = date('Y-m-d H:i:s').' - Query: '.$sql.' - '.$e->getMessage();
        __log_error($message, 99);
    }
	return $res;
}

/* Devuelve array con datos encontrados, o bien el dato en concreto, si lo conocemos */
function fetch_array($sql,$query=''){
	$r = mysqli_fetch_array( query($sql) );
	if ( $query != '' ){
		return $r[$query];
	}
	else{
		return $r;			
	}
}


function fetch_assoc($sql){
	$r = mysqli_fetch_assoc( query($sql) );
	return $r;			
}


/* Devuelve un listado con objetos */
function list_object($sql){
	$res = query($sql);
	$cant = mysqli_num_rows($res);
	$lista = array();
	for ( $i=0; $i<$cant; $i++ ){
		$lista[$i] = mysqli_fetch_object($res);	
	}
	return $lista;
}

/* Devuelve un listado separado por comas */
function array_comas($sql){
	$res = query($sql);
	$cant = mysqli_num_rows($res);
	$lista='';
	$i=0;
	while ($lista2 = mysqli_fetch_array($res, MYSQLI_NUM)) {
		if ($i==0){$sep='';} else {$sep=',';}
			$lista=$lista.$sep.$lista2[0];
			$i++;
		}
	return $lista;
}

/* Devuelve un listado separado por comas y entre comillas dobles */
function array_comas_par($sql){
	$res = query($sql);
	$cant = mysqli_num_rows($res);
	$lista='';
	$i=0;
	while ($lista2 = mysqli_fetch_array($res, MYSQLI_NUM)) {
		if ($i==0){$sep='';} else {$sep=',';}
		$lista=$lista.$sep.'"'.$lista2[0].'"';
		$i++;
	}
	return $lista;
}

/* Cuenta filas */
function num_rows($sql){
	$n = mysqli_num_rows( query($sql) );
	return $n;			
}

	

/* Inserta */
function insert($table,$array){	
	$names = '';
	$values = '';
	
	foreach( $array as $key => $val ) {
		$names .= $key.',';	
		$values .= ( $val == 'SYSDATE()' ) ? 'SYSDATE(),' : '"'.$val.'",';	
	}
	
	$names = substr($names,0,strlen($names)-1);
	$values = substr($values,0,strlen($values)-1);
	
	$sql = 'INSERT into '.$table.' ('.$names.') VALUES ('.$values.')';
		
	return query($sql);
}

function aaa_test($fechahora, $datos){
    query("INSERT INTO aaa_test (fechahora, datos) VALUES ('{$fechahora}', '{$datos}')");
}

function clean_var_ob($var,$indice=''){
    if($indice==''){
        $r=(isset($var)?trim(addslashes(strip_tags($var))):false);
    }
    else{
        $r=(isset($var->$indice)?trim(addslashes(strip_tags($var->$indice))):false);
    }
    return $r;
}
function dame_reader_excel($archivo){
    $objPHPExcel = '';
    require_once _ZEND_.'excel/Classes/PHPExcel.php';//W210K
    require_once _ZEND_.'excel/fn_PHPExcel.php';//W210K

    $extension = PHPExcel_IOFactory::identify($archivo);
    if($extension=='Excel5' || $extension=='Excel2007') {
        if ($extension == 'Excel5') {
            require_once _ZEND_.'excel/Classes/PHPExcel/Reader/Excel5.php';//W210K
            $objReader = new PHPExcel_Reader_Excel5();
        } else if ($extension == 'Excel2007') {
            require_once _ZEND_.'excel/Classes/PHPExcel/Reader/Excel2007.php';//W210K
            $objReader = new PHPExcel_Reader_Excel2007();
        }
        $objPHPExcel = $objReader->load($archivo);
    }
    return $objPHPExcel;
}

function importar_talleres($archivo){
    $tipotaller=1;
    $idparent=1578; // Gemicar
    $contrato = 1;
    $abono = 5;
    $vencimiento = "2020-10-31 00:00:00";
    $pais=1;
    global $objPHPExcel;
    $objPHPExcel = dame_reader_excel($archivo);
    if($objPHPExcel==''){
        return 'No se ha creado el lector del EXCEL';
    }

    set_hoja(0);
    $fila=2;
    while (true) {
        $col='A';
        $alias = coge_valor_celda($col.$fila);$col++;
        $correo = coge_valor_celda($col.$fila);$col++;
            $correo=explode(";",$correo);
            $correo=$correo[0];
        $password = coge_valor_celda($col.$fila);$col++;
            $password==''||strlen($password)<6?$password=genera_pass(8):null;
        $nombre = coge_valor_celda($col.$fila);$col++;
        $nif = coge_valor_celda($col.$fila);$col++;
        $nomcom = coge_valor_celda($col.$fila);$col++;
        $contacto = coge_valor_celda($col.$fila);$col++;
        $tlf1 = coge_valor_celda($col.$fila);$col++;
        $tlf2 = coge_valor_celda($col.$fila);$col++;
        $direccion = coge_valor_celda($col.$fila);$col++;
        $cp = coge_valor_celda($col.$fila);$col++;
        $localidad = coge_valor_celda($col.$fila);$col++;
        $provincia = coge_valor_celda($col.$fila);$col++;
        $socio = coge_valor_celda($col.$fila);$col++;
        $correo_fact = coge_valor_celda($col.$fila);
            $correo_fact==''?$correo_fact=$correo:null;
        $sec_pass=secure_md5($password);
        $token_silent=encriptar($correo.'%%'.$sec_pass);

        if($correo==''){
            breaK;
        }

        // Insertamos taller
        $q="INSERT INTO talleres 
        (ta_idtipo, ta_idparent, ta_nombre, ta_contacto, ta_telefono1, ta_email, ta_direccion, ta_cp, ta_localidad, ta_provincia, ta_contrato, ta_abono, ta_vencimiento, ta_testing) 
        VALUES 
        ('{$tipotaller}', '{$idparent}', '{$nombre}', '{$contacto}', '{$tlf1}', '{$correo}', '{$direccion}', '{$cp}', '{$localidad}', '{$provincia}', '{$contrato}', '{$abono}', '{$vencimiento}', 0)";
        $r=query($q);
        $idtaller=insertado();

        $q="INSERT INTO usuarios_facturacion (uf_idtaller, uf_denomsoc, uf_cifnif, uf_nomcom, uf_contacto, uf_telefono1, uf_email, uf_direccion, uf_cp, uf_localidad, uf_provincia, uf_testing) VALUES ('".$idtaller."', '{$nombre}', '{$nif}', '{$nombre}', '{$contacto}', '{$tlf1}', '{$correo}', '{$direccion}', '{$cp}', '{$localidad}', '{$provincia}', 0)";
        query($q);
        $iddirfac=insertado();

        $q="INSERT INTO usuarios (us_nick, us_correo, us_pass, us_fecha_alta, us_estado, us_testing, us_accesosilent, us_idtaller) VALUES ('{$alias}', '{$correo}', '{$sec_pass}', '".date("Y-m-d H:i:s")."', '1', 0, '{$token_silent}', '{$idtaller}')";
        query($q);
        $idusuario=insertado();

        query("update talleres set ta_iddirfac='{$iddirfac}' where ta_idtaller='{$idtaller}'");
        query("INSERT into info_taller (it_idtaller, it_testing) VALUES ('{$idtaller}', 0)");
        query("INSERT into datos_actividad (da_mes, da_idtaller, da_idtipo, da_testing) VALUES (1, '{$idtaller}', 0, 0)");
        $fila++;
    }
    return true;
}

/**
 * @param string|array|object $message
 * @param int $type
 * @param string $fichero
 * @return bool
 */
function __log_error($message = 'Error inesperado', int $type = 3, string $fichero = ''): bool
{
    $tipo = $type;
    $name = $fichero=='' ? 'errores_varios' : "debug_".$fichero;
    $destino = '';
    switch ($type){
        case 1:
            $destino = 'g.barrasa@anelis.com';
            break;
        case 0:// Error con fichero personalizado para crear un log aparte para debug
            $tipo = 3;
            break;
        case 99:// Error de query, lo añadimos a otro fichero diferente
            $tipo = 3;
            $name = "errores_query";
            break;
        default:// Error general
            $tipo = 3;
    }
    is_string($message) ?: $message=json_encode($message);
    $destiny = $destino == '' ? RUTA_LOGS."/{$name}_".date('Ymd').".log" : $destino;
    $description = date('Y-m-d H:i:s')." - ".$message."\r\n";
    return error_log($description, $tipo, $destiny);
}