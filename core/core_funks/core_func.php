<?php
open_bd();
	$l_estados=list_object('Select * from estados_usuario');
	$l_rangos=list_object('Select * from rangos_usuario');
	$l_abonos=list_object('Select * from tipos_abono where ta_disponible=1');
	$l_contratos=list_object('Select * from tipos_contrato');
	$l_tiposcli=list_object('Select * from tipos_cliente');
	$l_paises=list_object('Select * from paises where disponible=1 order by orden asc, nombre_pais asc');
	$l_provincias=list_object('Select * from provincias order by prov_nombre asc');
	$l_meses=list_object('Select * from meses');
	$tipos_iva=list_object('Select * from tipos_iva');
close_bd();

function show_errors($mode){
	if($mode=='on'){
		ini_set('display_errors', '1'); 
		error_reporting(E_ALL ^E_DEPRECATED);
	}
	else if($mode=='off'){
		ini_set('display_errors', '0'); 
		error_reporting(0);
	}
}

function dame_trimestre($mes){
	$mes=intval($mes);
	switch($mes){
		case 1:
			$trimestre='1';
			break;
		case 2:
			$trimestre='1';
			break;
		case 3:
			$trimestre='1';
			break;
		case 4:
			$trimestre='2';
			break;
		case 5:
			$trimestre='2';
			break;
		case 6:
			$trimestre='2';
			break;
		case 7:
			$trimestre='3';
			break;
		case 8:
			$trimestre='3';
			break;
		case 9:
			$trimestre='3';
			break;
		case 10:
			$trimestre='4';
			break;
		case 11:
			$trimestre='4';
			break;
		case 12:
			$trimestre='4';
			break;
	}
	return $trimestre;
}

function margen_sobre_coste($coste, $venta){
	$margen=$coste==0?0:($venta-$coste)/$coste*100;
	return $margen;
}

function damearraypag($array,$pagina,$limite){
	$comienzo=($pagina-1)*$limite;
	$res=implode(',',array_slice($array, $comienzo, $limite));
	return $res;
}

function margen_sobre_venta($coste, $venta){
	$margen=($coste-$venta)/$venta*100;
	return $margen;
}

function porcentaje_($fraccion, $total){
	$porcentaje=$total==0?0:$fraccion*100/$total;
	return $porcentaje;
}

function nom_dia($dia){
	$dias = array("Domingo","Lunes","Martes","Mi&eacute;rcoles","Jueves","Viernes","S&aacute;bado");
	return array_key_exists($dia, $dias)?$dias[$dia]:'';
}

function nom_mes($mes){
	$meses = array(1=>"Enero",2=>"Febrero",3=>"Marzo",4=>"Abril",5=>"Mayo",6=>"Junio",7=>"Julio",8=>"Agosto",9=>"Septiembre",10=>"Octubre",11=>"Noviembre",12=>"Diciembre");
	return array_key_exists($mes, $meses)?$meses[$mes]:'';
}

function nom_estado($estado){
	switch($estado){
		case '0':
			$estado='Pendiente';
			break;
		case '1':
			$estado='Pagada';
			break;
		case '2':
			$estado='Devuelta';
			break;
		case '9':
			$estado='Anulada';
			break;
	}
	return $estado;
}

function moneda_puntocoma($importe, $decimales='2'){//Pasa al formato numérico con separador de miles=. y separador decimales=,
	return number_format($importe, $decimales, ',', '.');
}

function moneda_punto($importe, $decimales='2'){//Pasa al formato numérico sin separador de miles y separador decimales=.
	return number_format($importe, $decimales, '.', '');
}

function fuera_de_aqui($url_dest='inicio/'){
	$url_dest=$url_dest==''?_RAIZ_.'inicio/':$url_dest;
	substr($url_dest, -1)!='/'?$url_dest.='/':'';
	close_bd();
	header('Location:'.$url_dest);
	exit;
}

function nombremes($fecha, $idioma='EN'){//Devuelve el nombre del mes a partir del formato YY-mm-dd
	$idioma=='ES'?setlocale(LC_TIME, 'spanish'):setlocale(LC_TIME, 'C');
	$nombre=strftime("%B",strtotime($fecha)); 
	return $nombre;
}

function nom_modulo($modulo){
	return u8_(fetch_array('select mo_nombre from modulos where mo_url="'.$modulo.'"','mo_nombre'));
}
function nom_seccion($seccion){
	return u8_(fetch_array('select sc_nombre from secciones where sc_url="'.$seccion.'"','sc_nombre'));
}
function modulo_ico($modulo){
    switch($modulo) {
        case 'inicio':
            $ico = 'bi bi-speedometer2';
            break;
        case 'informes_del_mes':
            $ico = 'fa-solid fa-file-contract';
            break;
        case 'ratios_acumulados':
            $ico = 'fa-solid fa-chart-line';
            break;
        case 'datos_del_mes':
            $ico = 'fa-solid fa-table-list';
            break;
        case 'km0':
            $ico = 'fa-solid fa-gauge';
            break;
        case 'analisis_de_datos':
            $ico = 'fa-solid fa-magnifying-glass-chart';
            break;
        case 'datos_del_taller':
            $ico = 'fa-solid fa-screwdriver-wrench';
            break;
        case 'facturacion':
            $ico = 'fa-solid fa-file-invoice-dollar';
            break;
        case 'contactar_con_assistec':
            $ico = 'fa-solid fa-address-book';
            break;
        case 'usuarios':
            $ico = 'fa-solid fa-users';
            break;
        case 'talleres':
            $ico = 'fa-solid fa-screwdriver-wrench';
            break;
        case 'promociones':
            $ico = 'fa-solid fa-bullhorn';
            break;
        case 'listados':
            $ico = 'fa-solid fa-list';
            break;
        default:
            $ico = '';
            break;
    }
    return $ico;
}

function dame_secciones($modulo){
	if($_SESSION['datos_'._ID_PAG_]['datos_user']['rango']!=1&&$modulo=='facturacion'){
		$res=list_object('select * from secciones, modulos where mo_idmodulo=sc_idmodulo and mo_url="'.$modulo.'" and sc_url="facturas" order by sc_orden asc, sc_nombre asc');
	}
	else{
		$res=list_object('select * from secciones, modulos where mo_idmodulo=sc_idmodulo and mo_url="'.$modulo.'" order by sc_orden asc, sc_nombre asc');
	}
	return $res;
}

function comprueba_acceso($modulo, $defmod){
	$modulo=$modulo=='login'?$defmod:$modulo;
	$m=isset($_SESSION['datos_'._ID_PAG_]['idusuario'])?(comprueba_usuario($_SESSION['datos_'._ID_PAG_]['idusuario'])?$modulo:'login'):'login';
	$m=$m!='login'&&isset($_SESSION['datos_'._ID_PAG_]['datos_user']['rango'])?comprueba_acceso_modulo($m):'login';
	return $m;
}

function comprueba_usuario($usuario){
	$usr=num_rows('select us_idusuario from usuarios where us_idusuario='.$usuario.' and us_estado!=0');
	return $usr==1?true:false;
}

function comprueba_acceso_modulo($modulo){
	$m=fetch_array('select mo_url from modulos, rangos_usuario where mo_url="'.$modulo.'" and find_in_set (mo_idmodulo, ru_acceso_mod) and ru_idrango='.$_SESSION['datos_'._ID_PAG_]['datos_user']['rango'].'','mo_url');
	return $m!=NULL&&$m!=''?$m:'inicio';
}

function comprueba_seccion($modulo, $seccion){
	if($_SESSION['datos_'._ID_PAG_]['datos_user']['rango']!=1&&$modulo=='facturacion'&&$seccion!='facturas'){
		$seccion='facturas';
	}
	else{
		$seccion=fetch_array('select sc_url from modulos, secciones where mo_url="'.$modulo.'" and sc_url="'.$seccion.'" and sc_idmodulo=mo_idmodulo','sc_url');
	}
	return $seccion!=NULL&&$seccion!=''?$seccion:'';
}

function tipos_personal(){
	return list_object('select * from tipos_personal');
}

function tipos_equipamiento(){
	return list_object('select * from tipos_equipamiento');
}

function cargos_personal($idtipo=0){
	$filtro=$idtipo==0?'':' and cp_idtipo='.$idtipo.'';
	return list_object('select * from cargos_personal where 1'.$filtro.'');
}

function funciones_personal($idempleado){
	return list_object('select * from personal_funciones where pf_idpersonal='.$idempleado.'');
}

function dato_rango($idrango, $campo){
	return fetch_array('select '.$campo.' from rangos_usuario where ru_idrango='.$idrango.'',$campo);
}

function dato_estado($idestado, $campo){
	return fetch_array('select '.$campo.' from estados_usuario where eu_idestado='.$idestado.'',$campo);
}

function dato_contrato($idcontrato, $campo){
	return fetch_array('select '.$campo.' from tipos_contrato where tc_idtipo='.$idcontrato.'',$campo);
}

function genera_captcha(){
	$_SESSION['datos_'._ID_PAG_]['captcha1']=rand(0,9);
	$_SESSION['datos_'._ID_PAG_]['captcha2']=rand(0,9);	
	$_SESSION['datos_'._ID_PAG_]['captcha_sum']=$_SESSION['datos_'._ID_PAG_]['captcha1']+$_SESSION['datos_'._ID_PAG_]['captcha2'];
}

/* Encripta */
function en__($v){
	return base64_encode( base64_encode( base64_encode($v) ) );	
}

/* Desencripta */
function de__($v){
	return base64_decode( base64_decode( base64_decode($v) ) );			
}

function clean_post($var){
	if (isset($_POST[$var])) {
		return trim(addslashes(strip_tags($_POST[$var])));
	}
	else {
		return '';	
	}
}

function clean_session($var){
	return trim(addslashes(strip_tags($_SESSION[$var])));		
}

function clean_get($var){
	if (isset($_GET[$var])) {
		return trim(addslashes(strip_tags($_GET[$var])));
	}
	else {
		return '';
	}
			
}

/* Encode UTF-8 */
function u8_($var){
	return $var;
}

/* Decode UTF-8 */
function u8d_($var){
	return $var;
}

function html_($var){
	return htmlentities($var);
}

/* Formatea fecha */
function fecha($input){
	$input = explode(' ',$input);
	$input = explode('-',$input[0]);
	$input = $input[2].'/'.$input[1].'/'.$input[0];
	return $input;
}

function exp_fecha_hora($fecha){
	$input = explode(' ',$fecha);
	$fechas = explode('-',$input[0]);
	$horas = explode(':',$input[1]);
	return array('anho'=>$fechas[0], 'mes'=>$fechas[1], 'dia'=>$fechas[2], 'hora'=>$horas[0], 'minuto'=>$horas[1], 'segundo'=>$horas[2]);
}

/* Devuelve la extension de un archivo */
function extension_($file){
	$ext = explode('.',$file);
	$ext = $ext[count($ext)-1];
	return strtolower($ext);	
}

/* Seguridad */

function secure_md5($val){
	$val = md5($val);
	$val = $val.'d4s8asaf9sa7s6d51'.$val.'d8sha8sd'.$val;
	$val = md5($val);
	$val = md5($val);
	return $val;
}

function encriptar($cadena){ //Devuelve el string encriptado
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('AES-256-XTS'));
    return base64url_encode(openssl_encrypt($cadena, "AES-256-XTS", md5(_CLAVE_CIFRADO_),0,$iv)."%%".$iv);
}
function desencriptar($cadena){ //Devuelve el string desencriptado
    $cadena_mas_iv = explode("%%", base64url_decode($cadena));
    $r=count($cadena_mas_iv)==2;
    return !$r?'':openssl_decrypt($cadena_mas_iv[0], "AES-256-XTS", md5(_CLAVE_CIFRADO_),0,$cadena_mas_iv[1]);
}
function base64url_encode($data) { // Codificar Base64 para URLs
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function base64url_decode($data) { // Decodificar Base64 para URLs
    return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
}


/* URLs amigables */

function url_amigable($titulo, $id) {  
	$palabrasCensuradas = array();
	$formato = '{id}/{titulo}/';
	$suffix = '';
	  
    $wrong = array('á', 'é', 'í', 'ó', 'ú', 'ñ', 'Á', 'É', 'Í', 'Ó', 'Ú', 'Ñ', 'ç', 'ü');  
    $right = array('a', 'e' ,'i', 'o', 'u', 'n', 'A', 'E', 'I', 'O', 'U', 'N', 'c', 'u');  
      
    //Reemplaza los caracteres especiales  
    $titulo = str_replace($wrong, $right, $titulo);  
    //Pone la cadena en minisculas  
    $titulo = strtolower($titulo);  
    //Reemplaza todo lo que no sean letras ni numeros por "-"  
    $titulo = preg_replace("/[^a-z0-9]+/", "-", $titulo);  
    //Elimino los "-" al principio y final de la cadena  
    $titulo = trim($titulo, '-');  
    //Separo la cadena en un array, usando "-" como delimitador  
    $palabras = explode("-", $titulo);  
      
    $censuradas = array("a", "en", "el", "un", "la", "una", "o", "se", "de", "del");  
    $censuradas = array_merge($censuradas, $palabrasCensuradas);  
      
    //Usando array_diff, a mi array antes obtenido le resto el array de palabras comunes  
    $palabras = array_diff($palabras, $censuradas);  
    //Vuelvo a "pegar" la cadena  
    $titulo = implode("-", $palabras);  
    //Vuelvo id a su valor numerico  
    $id = intval($id);  
      
	if ( ! empty($formato)) {
		$plantilla = array('{id}', '{titulo}');
		$reemplazo = array($id, $titulo);
		$url = str_replace($plantilla, $reemplazo, $formato);
		$url .= $suffix;
	} 
	
	else $url = "$titulo-$id$suffix";   
    
	return $url;  
}  

function limita($c,$v) {
	$str='';
	$length=0;
	for($i=0;$i<strlen($v);$i++){
		if($length<$c){
			$str.=$v[$i];
			$length+=(ctype_upper($v[$i])||!ctype_lower($v[$i]))&&!is_numeric($v[$i])?1.25:1;
		}
		else{
			break;
		}
	}
	echo $str;	
}

function limita_puntos($c,$v) {
	$str='';
	$length=0;
	for($i=0;$i<strlen($v);$i++){
		if($length<$c-3){
			$str.=$v[$i];
			$length+=(ctype_upper($v[$i])||!ctype_lower($v[$i]))&&!is_numeric($v[$i])?1.25:1;
		}
		else{
			break;
		}
	}
	echo $str.'...';	
}

function genera_pass($longitud){
	$str = "ABCDEFGHIJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789";
	$cad = "";
	for($i=0;$i<$longitud;$i++) {
		$cad .= substr($str,rand(0,57),1);
	}
	return $cad;
}

function formato_pass($password){//Devuelve 1 si el formato es correcto
	$patron='/^[0-9-A-z-_@$&]*$/';
	return preg_match($patron, $password);
}

function formato_cp($cp){//Devuelve 1 si el formato es correcto
	$patron='/^[0-9-]*$/';
	return preg_match($patron, $cp);
}

function VerificarDireccionCorreo($direccion){
   $patron='#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#';
   if(preg_match($patron,$direccion))
      return true;
   else
     return false;
}

function enviar_email($mail_destino, $nombre_destino, $mail_cco='', $nombre_cco='', $asunto, $cuerpo, $origen_nombre, $origen_email, $respuesta_nombre='', $respuesta_email='', $urlalt='', $adjuntos='', $nadjuntos='', $imagen='', $n_imagen='', $altbody=''){
    require_once _PATH_.'core/Helpers/PHPMailer/PHPMailer.php';
    require_once _PATH_.'core/Helpers/PHPMailer/SMTP.php';
    require_once _PATH_.'core/Helpers/PHPMailer/Exception.php';
	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->IsHTML(true);// se envía como HTML
	$mail->Timeout=5;
	$mail->SetLanguage("es");//Idioma
	$mail->CharSet ="utf-8";//Codificación
	
	$mail->Host = _SMTP_SERVER_;  // nombre del servidor
	$mail->SMTPAuth = true;// Autenticación SMTP activa
	$mail->Port       = _SMTP_PORT_;// Puerto de salida
	$mail->Username = _SMTP_USER_;  //Usuario
	$mail->Password = _SMTP_PASSWORD_; //password
	
	$mail->From = $origen_email;//correo de origen
	$mail->FromName = $origen_nombre;//nombre origen
	$mail->AddAddress($mail_destino, $nombre_destino);//correo y nombre del destinatario
	if($mail_cco!=''){//Si se envía copia oculta
		$mail->AddBCC($mail_cco, $nombre_cco);//correo y nombre del destinatario oculto
	}
	if($respuesta_email!=''){//Si se responde a otra dirección
		$mail->AddReplyTo($respuesta_email, $respuesta_nombre);//correo y nombre del destinatario de respuesta
	}
	
	if($imagen!=''){//Si se incrusta una imagen
		$mail->AddEmbeddedImage($imagen, $n_imagen, $n_imagen.'.jpg', 'base64', 'image/jpeg');
	}
	
	if($adjuntos!=''){//Si se adjuntan archivos
		$adjuntos=explode('%%',$adjuntos);
		$nadjuntos=explode('%%',$nadjuntos);
		foreach($adjuntos as $key=>$adjunto){
			$mail->AddAttachment($adjunto, $nadjuntos[$key]);
		}
	}
	
	$mail->Subject = $asunto;//asunto
	$mail->Body = $cuerpo;//contenido
	if($altbody!=''){//Si se indica body alternativo
		$mail->AltBody = $altbody;
	}
					
	$exito = $mail->Send();
	$intentos=1; 
	/*while ((!$exito) && ($intentos < 5)) {
		sleep(5);
		$exito = $mail->Send();
		$intentos=$intentos+1;	
	}*/
	if(!$exito){
		$enviado=$mail->ErrorInfo;
	}
	else{
		$enviado=1;
	}
	return $enviado;
}

function dame_url(){//Obtiene la URL actual
	$parte1=$_SERVER['HTTP_HOST'];
	$parte2=$_SERVER['REQUEST_URI'];
	$url=$parte1;
	return $url;
}

function getRealIP() {//Obtiene la IP conectada
    if (!empty($_SERVER['HTTP_CLIENT_IP']))
        return $_SERVER['HTTP_CLIENT_IP'];
       
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
   
    return $_SERVER['REMOTE_ADDR'];
}

function decode($string) { //quitar caracteres especiales para evitar sqlinjection
	$nopermitidos = array("'",'\\','<','>',"\"","-","%");
	$string = str_replace($nopermitidos, "", $string);
	return $string;
}

function quitar_acentos($string){
    $string = trim($string);
    $string = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä', ),
        array('a', 'a', 'a', 'a', '', 'A', 'A', 'A', 'A'),
        $string
    );
    $string = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $string
    );
    $string = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $string
    );
    $string = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'º', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', '', 'O', 'O', 'O', 'O'),
        $string
    );
    $string = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $string
    );
	$string = str_replace(
        array("\\", "¨", "~",
             "#", "@", "|", "!", "\"",
             "·", "$", "%", "/",
             "(", ")", "?", "'", "¡",
             "¿", "[", "^", "`", "]",
             "+", "}", "{", "¨", "´",
             ">", "<", ";", ",", ":",
             "."),
        ' ',
        $string
    );
    return $string;
}

function limpia_tlf($string) { //permitir sólo números y signo +
	$string=preg_replace('/[^+0-9]/', '', $string);
	return $string;
}

function limpia_nifcif($string) { //permitir sólo números y letras mayúsculas
	$string=preg_replace('/[^a-zA-Z0-9]/', '', $string);
	return strtoupper($string);
}

function time_a_date($tiempo){
	$fecha=date('Y-m-d H:i:s', $tiempo);
	return $fecha;
}

function fechahora_esp($cadena,$sep='-'){//devuelve dd-mm-aaaa hh:mm:ss personalizando el separador
	if (!isset($sep)){$sep='-';}
	$fechahora=explode(' ',$cadena);
	$fecha=explode('-',$fechahora[0]);
	$res=$fecha[2].$sep.$fecha[1].$sep.$fecha[0].$sep.' '.$fechahora[1];
	return $res;
}

function fecha_esp($cadena,$sep='-'){//devuelve dd-mm-aaaa personalizando el separador
	if (!isset($sep)){$sep='-';}
	$fechahora=explode(' ',$cadena);
	$fecha=explode('-',$fechahora[0]);
	$res=$fecha[2].$sep.$fecha[1].$sep.$fecha[0];
	
	return $res;
}

function quita_hora($cadena){//devuelve sólo día, mes y año
	$fechahora=explode(' ',$cadena);
	return $fechahora[0];
}

function dias_mes($mes, $ano){
	return cal_days_in_month(CAL_GREGORIAN, $mes, $ano);
}

function fin_mes_siguiente($fecha){
	$fecha=quita_hora($fecha);
	$dato=explode('-',$fecha);
	$mes=$dato[1]==12?1:$dato[1]+1;
	$ano=$mes==1?$dato[0]+1:$dato[0];
	$ult_dia=dias_mes($mes, $ano);
	return $ano.'-'.conceros($mes,2).'-'.$ult_dia.' 23:59:59';
}

function suma_mes($mes, $cantidad){
	for($n=1; $n<=$cantidad; $n++){
		$mes++;
		$mes==13?$mes=1:'';
	}
	return $mes;
}

function fechahora_bd($cadena,$sep){//devuelve aaaa-mm-dd hh:mm:ss
	if (!isset($sep)){$sep='-';}
	$fechahora=explode(' ',$cadena);
	$fecha=explode($sep,$fechahora[0]);
	$res=$fecha[2].'-'.$fecha[1].'-'.$fecha[0].'-'.' '.$fechahora[1];
	return $res;
}

function h_m($cadena){//devuelve hh:mm
	$fechahora=explode(' ',$cadena);
	$hora=explode(':',$fechahora[1]);
	$res=$hora[0].':'.$hora[1];
	return $res;
}

function fechahora_min($cadena,$sep){
	if (!isset($sep)){$sep='-';}
	$fecha=fecha_esp($cadena,$sep);
	$hora=h_m($cadena);
	$res=$fecha.' '.$hora;
	return $res;
}

function mas_menos_tiempo($fecha, $dias, $horas, $minutos, $segundos){//$fecha='', $dias='+0', $horas='+0', $minutos='+0', $segundos='+0'
	$nuevafecha=$fecha==''?date('Y-m-d H:i:s'):$fecha;
	$nuevafecha = date('Y-m-d H:i:s', strtotime($horas.' hour', strtotime($nuevafecha)));
	$nuevafecha = date('Y-m-d H:i:s', strtotime($minutos.' minute', strtotime($nuevafecha)));
	$nuevafecha = date('Y-m-d H:i:s', strtotime($segundos.' second', strtotime($nuevafecha)));
	$nuevafecha = date('Y-m-d H:i:s', strtotime($dias.' day', strtotime($nuevafecha)));
	return $nuevafecha;
}

function faltan($time){//devuelve d días, h horas y m minutos desde formato UNIX
    if($time < 10) {
		$dato_dia = number_format(($time / (60*60)) / 24,6);
	}
	else {
		$dato_dia = number_format(($time / (60*60)) / 24,6);
	}
	
	//return $dato_dia;exit;	
	
	$data = explode('.',$dato_dia);
	$dato_dia = $data[0];
	$dato_hora = ('0.'.$data[1])*24;
	$data = explode('.',$dato_hora);
	$dato_hora = $data[0];
	$dato_min = ('0.'.$data[1])*60;
	$data = explode('.',$dato_min);
	$dato_min = $data[0];
	$dato_seg = ('0.'.$data[1])*60;
	$data = explode('.',$dato_seg);
	$dato_seg = $data[0];
	if($dato_dia < 10) $dato_dia = '0'.$dato_dia;
	if($dato_hora < 10) $dato_hora = '0'.$dato_hora;
	if($dato_min < 10) $dato_min = '0'.$dato_min;
	if($dato_seg < 10) $dato_seg = '0'.$dato_seg;
	//
	
	if($dato_dia == '0'){
		$dato_dia = '';
	}
	else {
		$dato_dia = $dato_dia. ' d&iacute;as ';
	}
	if($dato_hora == '0'){
		$dato_hora = '';
		if($dato_min == '0'){
			$dato_min = '';
			if ($dato_seg == '0'){
				$dato_seg = '';
				if ($dato_dia==''){
					$res='';
				}
			}
			else {
				$dato_seg = $dato_seg. ' seg';
				
				$res=$dato_dia.$dato_hora.$dato_min.$dato_seg;
			}
		}
		else {
			$dato_min = $dato_min. ' min ';
			$dato_seg = $dato_seg. ' seg';
			
			$res=$dato_dia.$dato_hora.$dato_min.$dato_seg;
		}
	}
	else {
		$dato_hora = $dato_hora. ' horas ';
		$dato_min = $dato_min. ' min ';
		$dato_seg = $dato_seg. ' seg';
		
		$res=$dato_dia.$dato_hora.$dato_min.$dato_seg;
	}
	
	return $res;
}

function faltan2($time){//devuelve d días, h horas y m minutos desde formato UNIX
    if($time < 10) {
		return '';
	}
	else {
		$dato_hora = number_format(($time / (60*60)),6);
	}
	
	//return $dato_dia;exit;	
	
	//$data = explode('.',$dato_dia);
	//$dato_dia = $data[0];
	//$dato_hora = ('0.'.$data[1])*24;
	$data = explode('.',$dato_hora);
	$dato_hora = $data[0];
	$dato_min = ('0.'.$data[1])*60;
	//$data = explode('.',$dato_min);
	//$dato_min = $data[0];
	//$dato_seg = ('0.'.$data[1])*60;
	//$data = explode('.',$dato_seg);
	//$dato_seg = $data[0];
	//if($dato_dia < 10) $dato_dia = '0'.$dato_dia;
	if($dato_hora < 10) $dato_hora = '0'.$dato_hora;
	if($dato_min < 10) $dato_min = '0'.$dato_min;
	//if($dato_seg < 10) $dato_seg = '0'.$dato_seg;
	
	/*if($dato_dia == '0'){
		$dato_dia = '';
	}
	else {
		$dato_dia = $dato_dia. ' d&iacute;as ';
	}*/
	if($dato_hora == '0'){
		$dato_hora = '';
		if($dato_min == '0'){
			$dato_min = '';
			/*if ($dato_seg == '0'){
				$dato_seg = '';
				if ($dato_dia==''){
					$res='';
				}
			}
			else {
				$dato_seg = $dato_seg. ' seg';
				
				$res=$dato_hora.$dato_min;
			}*/
		}
		else {
			$dato_min = round($dato_min,0). ' min ';
			//$dato_seg = $dato_seg. ' seg';
			
			$res=$dato_hora.$dato_min;
		}
	}
	else {
		$dato_hora = $dato_hora. ' horas ';
		$dato_min = round($dato_min,0). ' min ';
		//$dato_seg = $dato_seg. ' seg';
		
		$res=$dato_hora.$dato_min;
	}
	
	return $res;
}

function conceros($dato,$cifras){
	$res='';
	$diferencia = $cifras - strlen($dato); 
	for($i = 0 ; $i < $diferencia; $i++) { 
		$res .= 0; 
	} 
	$res .= $dato; 
	return $res;
}

function dame_num_fra($anho=''){
	$anho==''?$anho=date('Y'):'';
	$idanho=substr($anho,2,2);
	$num=fetch_array('select MAX(nfactura)+1 as NUMERO from facturas where anho_factura='.$anho.'','NUMERO');
	if($num==''||$num==NULL){
		$nfactura=$idanho.conceros(1,6);
	}
	else{
		$nfactura=$num;
	}
	return $nfactura;
}

function dame_max_stat($datos){
	$mayor=max($datos);
	$ind=substr($mayor, 0, 1);
	$cifras=strlen($mayor);
	
	$mult=1;
	
	for($i=1;$i<$cifras;$i++){
		$mult*=10;
	}
	
	return $mult*($ind+1);
}

function fin_mes_pasado($fecha){
	$fecha=quita_hora($fecha);
	$dato=explode('-',$fecha);
	$mes=$dato[1]==1?12:$dato[1]-1;
	$ano=$mes==12?$dato[0]-1:$dato[0];
	$ult_dia=dias_mes($mes, $ano);
	return $ano.'-'.conceros($mes,2).'-'.$ult_dia.' 23:59:59';
}

function dame_error_redsys($iderror){
	switch($iderror){
		case '0101':
			$res='Tarjeta caducada';
			break;
		case '0102':
			$res='Tarjeta en excepción transitoria o bajo sospecha de fraude';
			break;
		case '0104':
			$res='Operación no permitida para esa tarjeta o terminal';
			break;
		case '9104':
			$res='Operación no permitida para esa tarjeta o terminal';
			break;
		case '0106':
			$res='Intentos de PIN excedidos';
			break;
		case '0116':
			$res='Disponible insuficiente';
			break;
		case '0118':
			$res='Tarjeta no registrada';
			break;
		case '0125':
			$res='Tarjeta no efectiva';
			break;
		case '0129':
			$res='Código de seguridad (CVV2/CVC2) incorrecto';
			break;
		case '0180':
			$res='Tarjeta ajena al servicio';
			break;
		case '0184':
			$res='Error en la autenticación del titular';
			break;
		case '0190':
			$res='Denegación sin especificar Motivo';
			break;
		case '0191':
			$res='Fecha de caducidad errónea';
			break;
		case '0202':
			$res='Tarjeta en excepción transitoria o bajo sospecha de fraude con retirada de tarjeta';
			break;
		case '0904':
			$res='Comercio no registrado en FUC';
			break;
		case '0909':
			$res='Error de sistema';
			break;
		case '9912':
			$res='Emisor no disponible';
			break;
		case '0912':
			$res='Emisor no disponible';
			break;
		case '0950':
			$res='Operación de devolución no permitida';
			break;
		case '9064':
			$res='Número de posiciones de la tarjeta incorrecto';
			break;
		case '9078':
			$res='Tipo de operación no permitida para esa tarjeta';
			break;
		case '9999':
			$res='Operación que ha sido redirigida al emisor a autenticar';
			break;
		case '9998':
			$res='Operación en proceso de solicitud de datos de tarjeta';
			break;
		case '9998':
			$res='Operación';
			break;
		case '9997':
			$res='Se está procesando otra transacción en SIS con la misma tarjeta';
			break;
		case '9093':
			$res='Tarjeta no existente';
			break;
		case '9218':
			$res='El comercio no permite op. seguras por entrada /operaciones';
			break;
		case '9253':
			$res='Tarjeta no cumple el check-digit';
			break;
		case '9256':
			$res='El comercio no puede realizar preautorizaciones';
			break;
		case '9257':
			$res='Esta tarjeta no permite operativa de preautorizaciones';
			break;
		case '9261':
			$res='Operación detenida por superar el control de restricciones en la entrada al SIS';
			break;
		case '9913':
			$res='Error en la confirmación que el comercio envía al TPV Virtual';
			break;
		case '9914':
			$res='Confirmación KO del comercio';
			break;
		case '9928':
			$res='Anulación de autorización en diferido realizada por el SIS';
			break;
		case '9929':
			$res='Anulación de autorización en diferido realizada por el comercio';
			break;
		case '9104':
			$res='Comercio con titular seguro y titular sin clave de compra segura';
			break;
		case '9915':
			$res='A petición del usuario se ha cancelado el pago';
			break;
		case '9094':
			$res='Rechazo servidores internacionales';
			break;
		case '0944':
			$res='Sesión Incorrecta';
			break;
		case '0913':
			$res='Pedido repetido';
			break;
		default:
			$res='Error desconocido: '.$iderror;
	}
	return $res;
}

function vd__($data) {
    echo '<pre>'; var_dump($data); echo '</pre>';
}

function floatvalue($val){
    $val = str_replace(",",".",$val);
    $val = preg_replace('/\.(?=.*\.)/', '', $val);
    return floatval($val);
}

function get_client_ip(): string {
    foreach (['HTTP_CLIENT_IP','HTTP_X_FORWARDED_FOR','HTTP_X_FORWARDED','HTTP_X_CLUSTER_CLIENT_IP','HTTP_FORWARDED_FOR','HTTP_FORWARDED','REMOTE_ADDR'] as $key) {
        if (!empty($_SERVER[$key])) {
            $ip = $_SERVER[$key];
            if (strpos($ip, ',') !== false) $ip = explode(',', $ip)[0];
            return trim($ip);
        }
    }
    return '0.0.0.0';
}

function cidr_match(string $ip, string $cidr): bool {
    if (!str_contains($cidr, '/')) return $ip === $cidr;
    [$subnet, $mask] = explode('/', $cidr);
    $ip_long = ip2long($ip);
    $subnet_long = ip2long($subnet);
    if ($ip_long === false || $subnet_long === false) return false;
    $mask_long = -1 << (32 - (int)$mask);
    $subnet_long &= $mask_long;
    return ($ip_long & $mask_long) === $subnet_long;
}

function include_javascript(){
    $allowed_ips = [
        '89.131.66.1',// Jose
        '91.242.149.68',//Gerardo
        '91.243.132.83',// Sergi
        '185.73.171.215',// Sergi
        '185.73.171.223'//Sergi
    ];
    $client_ip = get_client_ip();
    $allowed = false;
    foreach ($allowed_ips as $allowed_ip) {
        if (str_contains($allowed_ip, '/')) {
            if (cidr_match($client_ip, $allowed_ip)) { $allowed = true; break; }
        } else {
            if ($client_ip === $allowed_ip) { $allowed = true; break; }
        }
    }

    if ($allowed) {
        // Ruta al JS a cargar
        echo '<script src="' . _RAIZ_ . 'chatbot/chat.js?v='.time().'"></script>';
    }
}

// Genera un token seguro y firmado (payload.signature)
function generate_token(int $bytes = 32, ?string $secret = null): string {
    if ($secret === null && defined('_SHARED_SECRET_')) {
        $secret = _SHARED_SECRET_;
    }

    $random = random_bytes($bytes);
    $payload = rtrim(strtr(base64_encode($random), '+/', '-_'), '=');

    $sig = hash_hmac('sha256', $payload, $secret ?? '', true);
    $sig_b64 = rtrim(strtr(base64_encode($sig), '+/', '-_'), '=');

    return $payload . '.' . $sig_b64;
}

// Verifica el token generado por generate_token
function verify_token(string $token, ?string $secret = null): bool {
    if ($secret === null && defined('_SHARED_SECRET_')) {
        $secret = _SHARED_SECRET_;
    }

    $parts = explode('.', $token);
    if (count($parts) !== 2) {
        return false;
    }

    [$payload, $sig] = $parts;

    $expected_sig = rtrim(strtr(base64_encode(hash_hmac('sha256', $payload, $secret ?? '', true)), '+/', '-_'), '=');

    return hash_equals($expected_sig, $sig);
}
?>