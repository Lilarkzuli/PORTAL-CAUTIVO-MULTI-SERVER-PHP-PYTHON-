

<?php
	
$enlace = mysqli_connect("192.168.80.20", "root", "123", "Acceso");

if (!$enlace) {
	echo "Error en la base de datos" . mysqli_connect_error();
	exit;
}

$host = '192.168.80.10';
$port = 22;
$username = 'helena';
$password = '123';
$ip = $_SERVER['REMOTE_ADDR'];



$connection = ssh2_connect($host, $port);
if (!$connection) {
	die("Failed to connect to $host on port $port");
}

if (!ssh2_auth_password($connection, $username, $password)) {
	die("Authentication failed for $username");
}

$comando = "arp -n $ip | awk 'NR==2 {print \$3}'"; // Use single quotes to prevent variable interpolation for $3

$stream = ssh2_exec($connection, $comando);
if (!$stream) {
	die("Failed to execute command over SSH");
}

stream_set_blocking($stream, true);
$output = trim(stream_get_contents($stream)); 
// Close SSH connection


$sql = "SELECT * FROM exusuarios";
$datos = mysqli_query($enlace, $sql);
while ($fila = mysqli_fetch_assoc($datos)) {
    if ($fila['mac'] == $output) {
      
        header("Location: error.php");
        // Desconectar SSH

        ssh2_disconnect($connection);
        $mac_encontrada = true;
        exit;
    }
}





$sql = "SELECT * FROM usuarios_bloqueados";
$datos3 = mysqli_query($enlace, $sql);
while ($fila = mysqli_fetch_assoc($datos3)) {
    if ($fila['mac_bloqueada'] == $output) {
      
        header("Location: bloq.php?mac=".$fila['mac_bloqueada'] );
        // Desconectar SSH

        ssh2_disconnect($connection);
        $mac_encontrada = true;
        exit;
    }
}


// Consulta para recuperar los datos de antiguos usuarios
$sql = "SELECT * FROM antiguos_usuarios";
$datos2 = mysqli_query($enlace, $sql);

$mac_encontrada = false;


while ($fila = mysqli_fetch_assoc($datos2)) {
    if ($fila['mac'] == $output) {
      
        header("Location: acabar.php");
        // Desconectar SSH

        ssh2_disconnect($connection);
        $mac_encontrada = true;
        exit;
    }
}



if (!$mac_encontrada) {
    header("Location: index2.php");
    ssh2_disconnect($connection);
    
    exit;
}
?>