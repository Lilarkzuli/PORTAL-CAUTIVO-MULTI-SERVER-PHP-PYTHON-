<?php
session_start();

$ticket = $_POST['tic'];

$enlace = mysqli_connect("localhost", "root", "123", "Acceso");

if (!$enlace) {
    echo "Error en la base de datos: " . mysqli_connect_error();
    exit;
}

$ip = $_SERVER['REMOTE_ADDR'];
$hora = date("Y-m-d H:i:s");
$tipo = "ticket";
$nom = "na";
$correo = "na";

$codigo = "SELECT * FROM Tokens";
$datos = mysqli_query($enlace, $codigo);

if (!$datos) {
    echo "Error al ejecutar la consulta: " . mysqli_error($enlace);
    exit;
}

$ticket_encontrado = false;

while ($fila = mysqli_fetch_assoc($datos)) {
    if ($fila['token'] == $ticket) {
        $ticket_encontrado = true;

        break;
    }
}

if ($ticket_encontrado) {
    $insertar = "INSERT INTO registro_conexiones (nombre, correo, ip, duracion, tipo, fecha) VALUES ('$nom', '$correo', '$ip', NULL, '$tipo', '$hora')";
    $resultado = mysqli_query($enlace, $insertar);

    if (!$resultado) {
        echo "Error al insertar registro de conexión: " . mysqli_error($enlace);
        exit;
    }

    $delete = "DELETE FROM Tokens WHERE token = '$ticket'";
    $resultado = mysqli_query($enlace, $delete);

    if (!$resultado) {
        echo "Error al eliminar el ticket: " . mysqli_error($enlace);
        exit;
    }

    echo "Registro completado, tienes 5 horas de tiempo. Recuerda, espera unos momentos y luego puedes abandonar la página. Si no funciona, sal y vuelve a entrar en el WiFi.";
} else {
    echo "El ticket proporcionado no es válido.";
}

mysqli_close($enlace);
#header("Location: index2.php");
exit;
?>
