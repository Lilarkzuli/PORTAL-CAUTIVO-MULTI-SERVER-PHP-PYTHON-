

<?php
	
	$enlace=mysqli_connect("192.168.80.20", "root", "123", "Acceso");

		if (!$enlace){
			echo "Error en la base de datos" . mysqli_connect_error();
   			exit;


		
	
}
	$ip = $_SERVER['REMOTE_ADDR'];





	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	echo $user_agent;
	

?>	
	
	


<html>	

<head>
	<link rel="stylesheet" href="Css/Principal.css">

</head>


<body>
	<div class="container">
		<h1 class=inicio> Terminos y condiciones</h1>


	</div>
		
			
	
	<div class="texto2">
	<a class="colord" href="./index.php"><p> <-- Volver atras</p></a>

	<p>
		1. Condiciones Generales
		<br>
		<br> 1.1 – Las presentes condiciones de uso de los servicios de acceso WiFi tienen como finalidad regular su utilización y determinar las condiciones de acceso a los contenidos y servicios que, a través de Internet, se ponen a disposición del usuario. El acceso vía WiFI tiene carácter gratuito para los usuarios, se da dentro del establecimiento (edificio) y, por tanto, en régimen de autoprestación. Asimismo, su uso está sujeto a los términos y condiciones establecidos en el presente documento.
		<br>
		<br> 1.2 -La duración del servicio se limita al tiempo en el que el usuario se mantenga conectado a los servicios de WiFi.
		<br>
		<br> 1.3 – El usuario es responsable de proveerse su propio ordenador o dispositivo móvil para acceder a Internet. El establecimiento no suministra directamente ningún tipo de asistencia técnica o tecnológica ni fuente de alimentación.
		<br>
		<br> 1.4 – El usuario, al acceder al Portal y usar el acceso WiFi, acepta expresamente las presentes condiciones.
		<br>
		<br> 1.5 – El establecimiento dispone de un ancho de banda para el acceso a Internet limitado, por lo cual la velocidad de acceso y fiabilidad del servicio puede variar o incluso ser imposible el acceso a Internet dependiendo de numerosos factores ajenos al establecimiento, citando a título enunciativo pero no limitativo: las capacidades de su aparato o dispositivo con conexión WiFi, la calidad de la propia señal WiFi dependiendo de la localización desde la que se desee conectar, la cantidad de usuarios conectados simultáneamente, etc. Por este motivo y dado que el acceso Wifi se realiza a través de una infraestructura de red compartida, no se le garantiza el acceso a Internet en todo momento, ni de forma continua, segura o libre de fallos. Asimismo, no se responsabiliza si el acceso es inestable, inseguro, lento o indisponible. El establecimiento declina cualquier responsabilidad que de todo ello pudiera derivarse.
		<br>
		<br> 1.7 – Por la presente el usuario declara ser mayor de dieciocho años.
		<br>
		<br> 1.8 – Los menores de edad, para acceder y usar los servicios Wi-Fi, necesitan obligatoriamente autorización de sus padres y/o representantes legales. El establecimiento informa a los padres y/o representantes legales del menor que se facilita un acceso libre y transparente a Internet, lo cual permite el acceso a contenidos o servicios que pueden no ser apropiados o que pueden estar prohibidos para los menores. Se recuerda a los padres y/o representantes legales de los menores que es de su exclusiva y única responsabilidad el controlar y decidir los contenidos o servicios adecuados para los menores a su cargo.
		<br>
		<br> 2. Obligaciones de los usuarios
		<br>
		<br> 2.1 – El usuario se compromete a usar el servicio de acceso WiFi de forma diligente y correcta y se compromete a no utilizarlo para la realización de actividades contrarias a la ley, a la moral, a las buenas costumbres aceptadas y/o con fines o efectos ilícitos, prohibidos o lesivos de derechos e intereses de terceros, así como a no realizar ningún tipo de uso que de cualquier forma pueda dañar, inutilizar, sobrecargar, deteriorar o impedir la normal utilización del servicio, los documentos, archivos y toda clase de contenidos almacenados en cualquier equipo informático accesible a través de Internet. El establecimiento declina cualquier responsabilidad que de todo ello pudiera derivarse con toda la extensión que permita el ordenamiento jurídico.
		<br>
		<br> 2.2 – Los tráficos soportados en este acceso de Internet son: navegación Web (http:), Navegación Web Segura (https), Correo entrante (POP3) y Correo Saliente (SMTP). Otros tráficos derivados del uso de software o servicios con prestaciones de videoconferencias, están limitados a la capacidad del servicio en cada momento o no podrían funcionar (video streaming, juegos online, etc.). El tráfico P2P no está permitido. Con carácter enunciativo, pero no limitativo, no se permiten intercambiar contenidos que incluyan (i) material que infrinja derechos de autor no debidamente autorizados, o que infrinja cualquier otro derecho de Propiedad Intelectual o Industrial, (ii) material ofensivo para la comunidad y la moral pública (iii) material que realice apología del terrorismo, racismo, u otras conductas ilegales, (iv) material pornográfico, especialmente el que atente contra menores, (v) materiales amenazadores, difamatorios o que inciten a la violencia (vi) contenidos ilegales o ilícitos de cualquier naturaleza.
		<br>
		<br> 2.3 – Asimismo, igualmente a título enunciativo pero no limitativo, el usuario se compromete a no utilizar, transmitir o difundir: (i) lenguaje difamatorio, amenazante o que sea contrario al derecho al honor, a la intimidad personal o familiar o la propia imagen de las personas físicas y jurídicas, (ii) acceder ilegalmente o sin autorización a sistemas, o redes que pertenezcan a otra persona, o a tratar de superar medidas de seguridad del sistema de otra persona (“hacking”), cualquier actividad que pueda ser usada como causante de un ataque a un sistema (escaneo de puertos,etc.), (iii) Distribución de virus, gusanos, troyanos a través de Internet, o cualquier otra actividad destructiva; Distribuir información acerca de creación o transmisión de virus por Internet, gusanos, troyanos, saturación, “mailbombing”, o ataques de denegación de servicio; Creación o gestión de bootnets; También actividades que interrumpan o interfieran en el uso efectivo de los recursos de red de otras personas o la realización de “spamming”, (iv) Realizar un uso fraudulento de la dirección IP proporcionada en cada acceso, (v) Cualquier otra forma que sea contraria, menosprecie o atente contra los Derechos Fundamentales y las libertades públicas reconocidas en la Constitución, en los Tratados Internacionales.
		<br>
		<br> 2.4 – El establecimiento se reserva el derecho a suspender y/o bloquear el servicio de forma inmediata y sin previo aviso en caso de detectar usos del servicio incumpliendo lo dispuesto en esta cláusula.
		<br>
		<br> 3. Responsabilidades
		<br>
		<br> – El usuario acepta y comprende que el acceso y uso del Portal Wi-Fi de acceso a Internet es bajo su propia responsabilidad. El establecimiento no asume responsabilidad alguna respecto a los usos que haga de este servicio, ni de los datos o informaciones transferidas desde Internet. Asimismo, se excluye cualquier tipo de garantía o responsabilidad por la utilización del Portal, de los servicios y los contenidos. Únicamente a título enunciativo pero no limitativo, la exoneración de responsabilidad del establecimiento comprende cualesquiera responsabilidades derivadas de: la información transmitida por los usuarios a través del canal suministrado por este servicio de acceso, los daños y perjuicios de toda naturaleza que pudieran deberse al uso indebido de este servicio, la realización por parte de los usuarios de accesos no autorizados a sitios protegidos de Internet, utilizando cualquier técnica de hacking, cracking, etc., los daños y perjuicios de cualquier naturaleza que puedan deberse al conocimiento que puedan tener los terceros del uso de Internet que pueda hacer el usuario o que pueda deberse al acceso y, en su caso, a la interceptación, eliminación, alteración, modificación o manipulación de cualquier modo de los contenidos y comunicaciones de toda clase que los usuarios transmitan, difundan, almacenen, pongan a disposición, reciban, obtengan o accedan a través del servicio.
		<br>
		<br> 4. Privacidad y seguridad
		<br>
		<br> – Con la finalidad de prestarle los servicios indicados en las presentes Condiciones, el establecimiento podrá acceder a cierta información personal suya, tal como la MAC de su dispositivo móvil u otros datos requeridos por la Ley 25/2007, de conservación de datos que serán incluidos en un fichero, debidamente registrado ante la Agencia Española de Protección de Datos.
		<br>
		<br> 5. Legislación aplicable
		<br>
		<br> – El presente Aviso Legal se rige en todos y cada uno de sus extremos por la ley española Las partes, con renuncia expresa al fuero que pudiera corresponderles, se someten a los Juzgados y Tribunales de Madrid Capital. En el supuesto de que el usuario tenga la condición de consumidor, el fuero competente será aquel que determine en cada caso la normativa en materia de protección a consumidores.
		</p>
	</div>
	</div>

	

</body>



</html>

