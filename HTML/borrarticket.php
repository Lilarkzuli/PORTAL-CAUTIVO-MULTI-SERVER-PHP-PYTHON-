<?php
session_start();
$id = $_GET['id'];

$enlace = mysqli_connect("192.168.80.20", "root", "123", "Acceso");


if (!$enlace) {
    echo "<p class='error'>Error en la base de datos: " . mysqli_connect_error() . "</p>";
    exit;
}


#HAY QUE RESINCRONIZAR LA HORA PUTA VIDA




$hora = date("Y-m-d H:i:s");

$sql = "DELETE FROM Tokens WHERE id = '$id'";
$datos = mysqli_query($enlace, $sql);









if (!$datos) {
    echo "<p class='error'>Error al ejecutar la consulta: " . mysqli_error($enlace) . "</p>";
} else {
    header("Location:ver_ticket.php ");
 
}


mysqli_close($enlace);
?>


