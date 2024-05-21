<?php 

session_start();

// Establecer la conexión a la base de datos
$enlace = mysqli_connect("192.168.80.20", "root", "123", "Acceso");

// Verificar si la conexión a la base de datos fue exitosa
if (!$enlace) {
    echo "<p class='error'>Error en la base de datos: " . mysqli_connect_error() . "</p>";
    exit;
}


$mac = $_GET['mac'];

$host = '192.168.80.10';
$port = 22;
$username = 'helena';
$password = '123';

// Establecer la conexión SSH
$connection = ssh2_connect($host, $port);
if (!$connection) {
    echo "<p class='error'>Error al conectar por SSH al servidor remoto</p>";
    exit;
}


if (!ssh2_auth_password($connection, $username, $password)) {
    echo "<p class='error'>Error de autenticación SSH</p>";
    exit;
}


$stream = ssh2_exec($connection, "sudo iptables -t mangle -D PREROUTING -m mac --mac-source $mac -j MARK --set-mark 2");
stream_set_blocking($stream, true);
$output = stream_get_contents($stream);


// Cerrar la conexión SSH
ssh2_disconnect($connection);

// Eliminar la entrada de la base de datos
$sql = "DELETE FROM antiguos_usuarios WHERE mac = '$mac'";
$datos = mysqli_query($enlace, $sql);

if (!$datos) {
    echo "<p class='error'>Error al ejecutar la consulta: " . mysqli_error($enlace) . "</p>";
    exit;
} else {
   
    header("Location: pantalla2.php");
    exit;
}

?>



