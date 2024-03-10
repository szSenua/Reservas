<?php

require_once "conecta.php";
require_once "funciones.php";
require_once 'menu.php';

$fecha = $_SESSION['fecha'];
$hora = $_SESSION['hora'];

// Obtener los nombres de los restaurantes disponibles
$restaurantes = obtenerRestaurantes($con);

// Verificar el restaurante seleccionado por el usuario en la variable de sesión
$restauranteSeleccionado = $_SESSION['restaurante'];

// Determinar el restaurante alternativo
$restauranteAlternativo = "";
foreach ($restaurantes as $restaurante) {
    if ($restaurante['restaurante'] !== $restauranteSeleccionado) {
        $restauranteAlternativo = $restaurante['restaurante'];
        break; // Solo necesitamos uno alternativo, así que salimos del bucle
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Opciones</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            margin-top: 20px;
        }

        .form-container {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            gap: 3em;
            margin-top: 20px;
        }

        .form-container form {
            text-align: center;
        }

        select,
        input[type="submit"] {
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
            transition: border-color 0.3s;
        }

        select:focus,
        input[type="submit"]:focus {
            outline: none;
            border-color: #342042;
        }

        input[type="submit"] {
            background-color: #342042;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #714c8f;
        }
    </style>
</head>

<body>

    <h2>Actualmente no existen reservas para la fecha <?php echo $fecha ?>, hora <?php echo $hora ?> en el restaurante <?php echo $restauranteSeleccionado ?>. 
Le ofrecemos las siguientes alternativas:</h2>

    <div class="form-container">
        <form action="reserva_restaurante_alternativo.php" method="post">
            <h3>Seleccione otro restaurante:</h3>
            <select name="nuevo_restaurante">
                <option value="<?php echo $restauranteAlternativo; ?>"><?php echo $restauranteAlternativo; ?></option>
            </select>
            <input type="submit" value="Seleccionar" name="consultar_restaurante">
        </form>

        <form action="nueva_reserva.php" method="post">
            <h3>Seleccione el tiempo de espera máximo:</h3>
            <select name="tiempo_espera">
                <option value="5">5 minutos</option>
                <option value="10">10 minutos</option>
                <option value="60">1 hora</option>
                <option value="90">1 hora y media</option>
                <option value="105">1 hora y 45 minutos</option>
            </select>
            <input type="submit" value="Seleccionar" name="consultar_tiempo" >
        </form>
    </div>

</body>

</html>
