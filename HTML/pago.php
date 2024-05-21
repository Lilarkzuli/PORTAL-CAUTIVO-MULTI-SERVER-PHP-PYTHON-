<?php

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
        <h3>Datos del Usuario</h3>
        <label for="nombre">Nombre:</label><br>
        <input type="text" id="nombre" name="nombre" required><br>
        
        <label for="email">Correo electr�nico:</label>
        <input type="email" id="email" name="email" required>

        <h3>Datos de la Tarjeta</h3>
        <label for="nombre_tarjeta">Nombre en la Tarjeta:</label><br>
        <input type="text" id="nombre_tarjeta" name="nombre_tarjeta"required><br>

        <label for="numero_tarjeta">Número de Tarjeta:</label><br>
        <input type="text" id="numero_tarjeta" name="numero_tarjeta" maxlength="16" required><br>

        <label for="fecha_vencimiento">Fecha de Vencimiento:</label><br>
        <input type="text" id="fecha_vencimiento" name="fecha_vencimiento" placeholder="MM/YY" required><br>

        <label for="cvv">CVV:</label><br>
        <input type="text" id="cvv" name="cvv" maxlength="3" required><br><br>
        <br>
        <label> <input type="checkbox" id="checkbox" name="checkbox" required> <a href="condiciones.php" > nuestros terminos y condiciones </a></label>

        <input type="hidden"  id="tipo" name="tipo" value="pago"> </input>
        <input type="submit" value="Pagar">
     

    </form>
</body>
</html>
