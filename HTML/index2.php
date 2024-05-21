

<?php

	$enlace=mysqli_connect("192.168.80.20", "root", "123", "Acceso");

		if (!$enlace){
			echo "Error en la base de datos" . mysqli_connect_error();
   			exit;


		
	
}


?>	
	


<html>	

<head>
	<link rel="stylesheet" href="Css/Principal.css">

</head>


<body>
	<div class="container">
		<h1 class=inicio> Portal cautivo</h1>


	</div>
	<div class="texto">
	   <p>Hola bienvenido, antes de continuar necesitamos tus datos para que usted pueda acceder a la red </p>
        <p>Actualmente disponemos de 2 opciones de acceso</p>
	</div>
	<div class="cubo">
	<div class="cubo2">
	
		<a class="color" href="./registro.php"><p>GRATIS</p></a>
	</div>
	<div class="cubo2">


		<a class="color" href="./pago.php"><p>PAGO</p></a>

	</div>
	<div class="cubo2">


		<a class="color" href="./ticket.php"><p>Ticket</p></a>

		</div>
	</div>

	<?php

		echo "PHP FUNCIONA";
		echo $ip;
	
		

	?>


</body>



</html>

