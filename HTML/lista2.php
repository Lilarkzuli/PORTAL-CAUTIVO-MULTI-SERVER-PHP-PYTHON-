
<?php 

session_start(); 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Css/Principal.css">
</head>
<body>
<?php   
    $nom = $_POST['nombre'];
    $contraseña = $_POST['contra']; 
    if ($nom == 'pacos'  and $contraseña=='123'){
        $_SESSION['registrado'] = true;
       
        header("Location: pantalla.php ");
       
    }
    else{
        header("Location: lista.php ");

    }
            
    
    
    


    
    ?>
   
</body>
</html>