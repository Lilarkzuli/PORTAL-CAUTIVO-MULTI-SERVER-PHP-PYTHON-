<?php
session_start();

$enlace = mysqli_connect("localhost", "root", "123", "Acceso");

if (!$enlace) {
    echo "Error en la base de datos: " . mysqli_connect_error();
    exit;
}

$ip = $_SERVER['REMOTE_ADDR'];
$hora = date("Y-m-d H:i:s");
$nom = $_POST['nombre'];
$correo = $_POST['email'];
$tipo = $_POST['tipo'];

// Función para generar tokens aleatorios
function random_strings($length_of_string) {
    return substr(md5(time()), 0, $length_of_string);
}

function random_strings2($length_of_string) {
    return substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, $length_of_string);
}




$insertar = "INSERT INTO registro_conexiones (nombre, correo, ip, duracion, tipo, fecha) VALUES ('$nom', '$correo', '$ip', NULL, '$tipo', '$hora')";

$resultado = mysqli_query($enlace, $insertar);

if ($tipo == 'gratis') {
   
   
    if ($resultado) {
        echo "Registro completado. Tienes 1 hora de tiempo. Por favor, espera unos momentos y puedes abandonar la página. Si no funciona, sal y vuelve a entrar en la red WiFi.";
    } else {
        echo "Registro fallido. Ha habido un fallo en el sistema. Por favor, informa a uno de nuestros tenderos, ellos te ayudarán.";
    }



}        

elseif ($tipo == 'pago') {
    // Genera dos tokens aleatorios para usuarios de pago
    $token1 = random_strings(8);
    $token2 = random_strings2(8);
    
    $insertar2 = "INSERT INTO Tokens (nombre, token, tiempo_acceso) VALUES ('$nom', '$token1', '$hora'), ('$nom', '$token2', '$hora')";
    $resultado2 = mysqli_query($enlace, $insertar2);

    if ($resultado2) {
        echo "Registro completado. Tienes 5 horas de acceso premium. Por favor, espera unos momentos y puedes abandonar la página. Si no funciona, sal y vuelve a entrar en la red WiFi. Aquí tienes tus tokens: $token1, $token2";
    } else {
        echo "Registro fallido. Ha habido un fallo en el sistema. Por favor, informa a uno de nuestros tenderos, ellos te ayudarán.";
    }
} 
else {
    echo "Tipo de conexión desconocido.";
}

mysqli_close($enlace);
exit;
?>
