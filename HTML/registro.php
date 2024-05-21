<?php

//session_start
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
    <h2>Registro de Usuario</h2>
    
  
    </div>
    <a class="button" href='index2.php'>  <-- Volver atras </a>
    <form action="process_registro.php" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
        
        <label for="email">Correo electrónico:</label>
        <input type="email" id="email" name="email" required>
        <br>
       <label> <input type="checkbox" id="checkbox" name="checkbox" required> <a href="condiciones.php" > nuestros terminos y condiciones </a></label> 
        <input type="hidden" id="tipo"  name="tipo" value="gratis"> </input>

        
        <input type="submit" value="Registrarse" >
      
    </form>"
</body>
</html>











