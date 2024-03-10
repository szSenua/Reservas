<?php
require_once 'conecta.php';
require_once 'funciones.php';
require_once 'menu.php';

$errores = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reservar'])) {
    if (empty($_POST['email'])) {
        $errores[] = "Debes introducir un email correcto";
    } else {
        $email = $_POST['email'];
    }


    if (count($errores) == 0) {

        //Procesas la reserva
        $restaurante = $_SESSION['datos_nueva_reserva']['restaurante'];
        $numMesa = $_SESSION['datos_nueva_reserva']['numMesa'];
        $comensales = $_SESSION['datos_nueva_reserva']['comensales'];
        $fecha = $_SESSION['datos_nueva_reserva']['fecha'];
        $hora = $_SESSION['datos_nueva_reserva']['nuevaHoraReserva'];

        $estado = reservarMesa($con, $email, $restaurante, $numMesa, $fecha, $hora, $comensales);


        if ($estado) {

            $_SESSION['mensaje_reserva'] = "La reserva se ha realizado con éxito.";
            $_SESSION['datos_reserva'] = [
                'restaurante' => $restaurante,
                'numMesa' => $numMesa,
                'fecha' => $fecha,
                'hora' => $hora,
                'comensales' => $comensales
            ];
            require_once 'desconecta.php';
            header("Location: mensajes.php");
            exit();
        } else {
            $_SESSION['mensaje_reserva'] = "No se ha podido realizar la reserva.";
            require_once 'desconecta.php';
            header("Location: mensajes.php");
            exit();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        form {
            max-width: 400px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #342042;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 800;
            transition: background-color 0.3s;
            font-size: 1em;
        }

        input[type="submit"]:hover {
            background-color: #714C8F;
            font-weight: 800;
            font-size: 1em;
        }

        h2 {
            text-align: center;
            color: #342042;
            font-weight: 600;
        }

        .error {
            color: red;
            text-align: center;
        }
    </style>
</head>

<body>
    <form action="" method="POST">

        <?php if (!empty($errores)) : ?>
            <div class="error">
                <?php foreach ($errores as $error) : ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <h2>Introduce una cuenta de correo:</h2>
        <input type="email" name="email">
        <input type="submit" name="reservar" value="Reservar">
    </form>
</body>

</html>
