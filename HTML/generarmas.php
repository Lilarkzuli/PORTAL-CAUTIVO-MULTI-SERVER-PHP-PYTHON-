<?php


$enlace = mysqli_connect("localhost", "root", "123", "Acceso");

if (!$enlace) {
    echo "Error en la base de datos: " . mysqli_connect_error();
    exit;
}

$hora = date("Y-m-d H:i:s");

function random_strings($length_of_string) {
    return substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, $length_of_string) ;
}

function random_strings2($length_of_string) {
    return substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, $length_of_string);
}

$token1 = random_strings(8);
$token2 = random_strings2(8);

$insertar2 = "INSERT INTO Tokens (nombre, token, tiempo_acceso) VALUES ('administrador', '$token1', '$hora'), ('administrador', '$token2', '$hora')";
$resultado2 = mysqli_query($enlace, $insertar2);


if ($resultado2) {
    header("Location: ver_ticket.php");
} else {
    echo "ERROR DE GENERACION DE TICKET";

};
















?>