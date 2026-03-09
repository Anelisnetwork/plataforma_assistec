<?php
// (Aquí debes tener definida o incluida tu función verify_token)
$clave_secreta = _SHARED_SECRET_; // Debe ser EXACTAMENTE la misma que en WooCommerce

// 1. Capturamos las cabeceras que nos envía WooCommerce
$headers = null;
if (isset($_SERVER['Authorization'])) {
    $headers = trim($_SERVER["Authorization"]);
} else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { // Nginx o Apache
    $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
} elseif (function_exists('apache_request_headers')) {
    $requestHeaders = apache_request_headers();
    $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
    if (isset($requestHeaders['Authorization'])) {
        $headers = trim($requestHeaders['Authorization']);
    }
}

// 2. Verificamos si existe la cabecera Bearer
if (!empty($headers)) {
    if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
        $token_recibido = $matches[1];
    }
}

// 3. Pasamos el filtro de seguridad
if ( empty($token_recibido) || !verify_token($token_recibido, $clave_secreta) ) {
    // El token no existe, está manipulado o la firma no coincide con nuestro secreto.
    // Bloqueamos la puerta y devolvemos un error 401 (No autorizado)
    http_response_code(401);
    echo json_encode( array('error' => 'Acceso denegado. Token inválido o ausente.') );
    exit;
}

// 1. Capturamos el cuerpo (body) de la petición POST en formato texto crudo
$json_data = file_get_contents('php://input');

// 2. Decodificamos el JSON convirtiéndolo en un Array de PHP
$datos = json_decode($json_data, true);

// 3. Validación de seguridad básica: comprobamos que hay datos
if ( empty($datos) || !isset($datos['email']) ) {
    // Si no es válido, devolvemos un error 400 y cortamos la ejecución
    http_response_code(400);
    echo json_encode( array('error' => 'Datos inválidos o petición vacía') );
    exit;
}

// 4. Extraemos y limpiamos los datos usando PHP puro
$id_woo       = filter_var( $datos['user_id'], FILTER_SANITIZE_NUMBER_INT );
$email        = filter_var( trim( $datos['email'] ), FILTER_SANITIZE_EMAIL );

// Para los textos, quitamos espacios, eliminamos etiquetas HTML y convertimos caracteres especiales
$nombre       = htmlspecialchars( strip_tags( trim( $datos['first_name'] ) ), ENT_QUOTES, 'UTF-8' );
$estado       = htmlspecialchars( strip_tags( trim( $datos['status'] ) ), ENT_QUOTES, 'UTF-8' );
$nombre_plan  = htmlspecialchars( strip_tags( trim( $datos['plan_name'] ) ), ENT_QUOTES, 'UTF-8' );

// 5. LÓGICA DE NEGOCIO DE LA APLICACIÓN EXTERNA
// Aquí conectarías con la base de datos de Assistec

// 1. Normalizamos el estado: le quitamos el 'wcm-' inicial si lo trae.
// Así 'wcm-paused' se convierte en 'paused', y 'active' se queda como 'active'.
$estado_limpio = str_replace( 'wcm-', '', $estado );

if ( $estado_limpio === 'active' ) {

    // CASO A: El usuario tiene derecho a entrar
    // Lógica: Buscar en DB si existe el email.
    $q = "select us_idusuario, us_pass, us_estado from usuarios where (us_correo='$email' OR us_nick='$email')";
    $dcli = fetch_assoc($q);
    // El usuario existe, comprobamos su estado y actualizamos si es necesario
    if($dcli != ''){
        if($dcli['us_estado'] != '1'){
            // Si el usuario existe pero no está activo, lo activamos actualizando su estado a '1' (Activo) y el token
            $token_usuario = encriptar($email.'%%'.$dcli['us_idusuario']);
            $q = "update usuarios set us_estado='1', wp_token='$token_usuario' where us_idusuario='{$dcli['us_idusuario']}'";
            query($q);
        }
    }
    // Si NO existe -> Crear usuario y generar token.
    else{
        // Primero insertamos el nuevo usuario con estado 'Inactivo' (0) y un token = null para actualizarlo tras la inserción y obtención del ID creado
        $q = "INSERT INTO usuarios (us_nick, us_correo, us_pass, us_fecha_alta, us_estado, wp_token) VALUES ('$email', '$email', '', '".date("Y-m-d H:i:s")."', '0', 0)";
        query($q);
        $id_usuario = insertado();
        $token_usuario = encriptar($email.'%%'.$id_usuario);
        // Ahora actualizamos el token generado para ese usuario y cambiamos el estado a activo (1)
        $q = "update usuarios set wp_token='$token_usuario', us_estado = '1' where us_idusuario='$id_usuario'";
        query($q);
    }
    $mensaje = 'Usuario activo (Estado recibido: ' . $estado_limpio . ')';
    __log_error( $mensaje, 3, 'integracion-cuadro-de-mando' );

} elseif ( in_array( $estado_limpio, array( 'cancelled', 'expired', 'paused', 'pending', 'on-hold' ) ) ) {

    // CASO B: El usuario pierde el acceso
    // Lógica: Buscar el email en DB y cambiar su estado a 'Inactivo' o revocar token.
    $q = "select us_idusuario, us_pass, us_estado from usuarios where (us_correo='$email' OR us_nick='$email')";
    $dcli = fetch_assoc($q);
    __log_error("datos de cliente obtenido: " . print_r($dcli, true), 0, 'integracion-cuadro-de-mando');
    // El usuario existe, comprobamos su estado y actualizamos si es necesario
    if($dcli != ''){
        if($dcli['us_estado'] != '0'){
            // Si el usuario existe y está activo, lo desactivamos actualizando su estado a '0' (Inactivo)
            $q = "update usuarios set us_estado='0' where us_idusuario='{$dcli['us_idusuario']}'";
            query($q);
        }
    }
    $mensaje = 'Usuario inactivo (Estado recibido: ' . $estado_limpio . ')';
    __log_error( $mensaje, 3, 'integracion-cuadro-de-mando' );

} else {

    // CASO C: Estado desconocido o ignorado
    // Por si acaso WooCommerce envía algo raro (ej. 'free_trial' o 'delayed')
    // Lógica: Buscar el email en DB y cambiar su estado a 'Inactivo' por si acaso y notificamos.
    $q = "select us_idusuario, us_pass, us_estado from usuarios where (us_correo='$email' OR us_nick='$email')";
    $dcli = fetch_assoc($q);
    // El usuario existe, comprobamos su estado y actualizamos si es necesario
    if($dcli){
        if($dcli['us_estado'] != '0'){
            // Si el usuario existe y está activo, lo desactivamos actualizando su estado a '0' (Inactivo)
            $q = "update usuarios set us_estado='0' where us_idusuario='{$dcli['us_idusuario']}'";
            query($q);
        }
    }
    $mensaje = 'Estado no reconocido: ' . $estado_limpio . '. Se ha desactivado el usaurio. Por favor, revisa la documentación de WooCommerce para ver los posibles estados de suscripciones.';
    __log_error( $mensaje, 3, 'integracion-cuadro-de-mando' );

}

// 6. MUY IMPORTANTE: Devolver un OK a WooCommerce
// Si no devuelves un código 200, WooCommerce pensará que ha fallado y el log mostrará un error.
http_response_code(200);
echo json_encode( array(
    'success' => true,
    'mensaje' => $mensaje ?? 'Webhook procesado correctamente',
    'token'   => $token_usuario ?? '' // Enviamos el token de vuelta
) );
exit;