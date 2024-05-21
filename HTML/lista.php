<?php
	session_start(); 
    

?>




<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="Css/Registro.css">
</head>
<body>
    <div class="cuadrado">
    <h2>Acceso Administrador</h2>
    </div>
    <form action="lista2.php" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
        
        <label for="contraseña">contraseña</label>
        <input type="password" id="contra" name="contra" required>


        
        <input type="submit" value="Entrar" >
      
    </form>"
</body>
</html>
