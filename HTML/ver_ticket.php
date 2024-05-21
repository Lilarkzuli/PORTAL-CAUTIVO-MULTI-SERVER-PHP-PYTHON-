
<?php 

	session_start(); 
    if(!$_SESSION['registrado']){
        //encabezado de redirección
        header("location:lista.php");
        die;
     }
	// Establecer la conexión a la base de datos
	$enlace = mysqli_connect("192.168.80.20", "root", "123", "Acceso");

	// Verificar si la conexión fue exitosa
	if (!$enlace) {
		echo "<p class='error'>Error en la base de datos: " . mysqli_connect_error() . "</p>";
	exit;
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Css/tabla.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <title>Usuarios Antiguos</title>
</head>
<body>
    <a class="button" href='pantalla.php'> USUARIOS CONECTADOS </a>
    <a class="button" href='pantalla2.php'>Exusuarios logeados</a>
    <a class="button" href='usuariosbloqueados.php'>Usuarios Bloqueados</a>
    <a class="button" href='salir.php'>Cerrar Session</a>
    <div class="container">
        
        <h1>TOKENS DE USUARIOS</h1>
        <?php
          
  

            
            $sql = "SELECT * FROM Tokens";
            $datos = mysqli_query($enlace, $sql);
            echo "<a class='button' href='generarmas.php'>Generar mas tokens</a>";
            
            if ($datos) {
               
                echo "<table class='scroll'>";
                echo "<tr><th>ID</th><th>token</th><th>nombre</th>";

               
                while ($fila = mysqli_fetch_assoc($datos)) {
                    echo "<tr>";
                    echo "<td>" . $fila['id'] . "</td>";
                    echo "<td>" . $fila['token'] . "</td>";
                    echo "<td>" . $fila['nombre'] . "</td>";
             
                    
					echo '<td><a href="borrarticket.php?id=' .  $fila['id'] .'"> <span class="material-symbols-outlined"> delete </span> </a></td>';

					

			
                    echo "</tr>";


                }

                echo "</table>";
            } else {
                echo "<p class='error'>Error al ejecutar la consulta: " . mysqli_error($enlace) . "</p>";
            }

            // Cerrar la conexión a la base de datos
            mysqli_close($enlace);
        ?>
    </div>
</body>
</html>
