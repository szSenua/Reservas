<?php

//Para ver los errores

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once 'conecta.php';
require_once 'funciones.php';

$email = '';
$contrasena = '';

$errores = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enviar'])) {

    if (empty($_POST['email'])) {
        $errores[] = "Debes introducir un email";
    } else {
        $email = $_POST['email'];
    }

    if (empty($_POST['contrasena'])) {
        $errores[] = "La contraseña es incorrecta";
    } else {
        $contrasena = $_POST['contrasena'];
    }

    if(count($errores) === 0){

    $adminData = existeUsuario($con, $email, $contrasena);

    if($adminData){
        session_start();
        $_SESSION['email'] = $email;
        $_SESSION['nombreUsuario'] = $adminData['nombre'];
        $_SESSION['tipoUsuario'] = $adminData['tipo'];
        $_SESSION['logged_in'] = true;

        header("Location: menu.php");
        exit();
    } else {
        // Si el usuario no es válido, mostrar el formulario de login con errores
        $errores[] = 'Usuario o contraseña incorrectos';
        
    
    }
    }
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Document</title>
</head>

<body>



    <div class="login">
        <form action="login.php" method="post" class="form">
            <?php
            echo "<ul>";
            foreach ($errores as $error) {
                echo "<li>" . $error . "</li>";
            }

            echo "</ul>";


            ?>
            <h2>Bienvenid@ al login</h2>
            <input type="text" name="email" value="<?php echo !empty($email) ? htmlspecialchars($email) : ''; ?>" placeholder="Email">
            <input type="password" name="contrasena" value="<?php echo !empty($contrasena) ? htmlspecialchars($contrasena) : ''; ?>" placeholder="Contraseña">
            <input type="submit" value="Enviar" class="submit" name="enviar">
            <a href="index.php">Volver</a>
        </form>
    </div>'

</body>

</html>