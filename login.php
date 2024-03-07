<?php
require_once 'conecta.php';

$email = "";
$contrasena = "";

$errores = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enviar'])) {

    if (empty($email)) {
        $errores[] = "Debes introducir un email";
    } else {
        $email = $_POST['email'];
    }

    if (empty($contrasena)) {
        $errores[] = "La contraseña es incorrecta";
    } else {
        $contrasnea = $_POST['contrasena'];
    }

    if(count($errores) === 0){

        //Verifica el usuario
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
            <input type="text" name="dni" value="<?php echo !empty($email) ? htmlspecialchars($email) : ''; ?>" placeholder="Email">
            <input type="password" name="contrasena" value="<?php echo !empty($contrasena) ? htmlspecialchars($contrasena) : ''; ?>" placeholder="Contraseña">
            <input type="submit" value="Enviar" class="submit" name="enviar">
            <a href="index.php">Volver</a>
        </form>
    </div>'

</body>

</html>