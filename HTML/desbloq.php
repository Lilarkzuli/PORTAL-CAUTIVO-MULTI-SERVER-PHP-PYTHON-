<?php 

session_start();


$id=$_GET['id'];
// Establecer la conexión a la base de datos
$enlace = mysqli_connect("192.168.80.20", "root", "123", "Acceso");

// Verificar si la conexión a la base de datos fue exitosa
if (!$enlace) {
    echo "<p class='error'>Error en la base de datos: " . mysqli_connect_error() . "</p>";
    exit;
}







$sql = "DELETE FROM usuarios_bloqueados WHERE id=". $id;
$datos = mysqli_query($enlace, $sql);

if (!$datos) {
    echo "<p class='error'>Error al ejecutar la consulta: " . mysqli_error($enlace) . "</p>";
    exit;
} else {
   
    header("Location: usuariosbloqueados.php");
    exit;
}

?>


