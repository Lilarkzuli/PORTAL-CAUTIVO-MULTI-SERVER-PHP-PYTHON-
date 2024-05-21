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
    <h2>Canjeado de Tickets</h2>
    
    </div>
    <a class="button" href='index2.php'>  <-- Volver atras </a>
    <form action="process_ticket.php" method="POST">
        <label for="nombre">Ticket</label>
        <input type="text" id="tic" name="tic" required>
       
        <input type="hidden" id="tipo"  name="tipo" value="ticket"> </input>
        <label> <input type="checkbox" id="checkbox" name="checkbox" required> <a href="condiciones.php" > nuestros terminos y condiciones </a></label> 
        
        <input type="submit" value="Canjear" >
      
    </form>
</body>
</html>











