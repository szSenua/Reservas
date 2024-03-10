<?php
require_once "conecta.php";
require_once "funciones.php";
require_once "menu.php";

$restaurantes = array();

foreach (obtenerRestaurantes($con) as $restaurante) {
    $restaurantes[] = $restaurante;
}

$capacidad = obtenerCapacidadMaxima($con);


$restaurante;
$comensales;
$fecha;
$hora;

$errores = array();

//Si se envía el formulario, empiezo a validar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enviar'])) {


    if (empty($_POST['restaurantes'])) {
        $errores[] = "Debes seleccionar un restaurante";
    } else {
        $restaurante = $_POST['restaurantes'];
    }


    if (empty($_POST['comensales'])) {
        $errores[] = "Debes seleccionar un número de comensales";
    } else {
        $comensales = $_POST['comensales'];
    }


    if (empty($_POST['fecha'])) {
        $errores[] = "Debes seleccionar una fecha";
    } else {
        $fecha = $_POST['fecha'];
    }


    if (empty($_POST['hora'])) {
        $errores[] = "Deberes seleccionar una hora";
    } else {
        $hora = $_POST['hora'];
    }

    if (count($errores) === 0) {
        //Hacer una sesión con los parámetros y mostrar las mesas libres
        session_start();
        $_SESSION['restaurante'] = $restaurante;
        $_SESSION['comensales'] = $comensales;
        $_SESSION['fecha'] = $fecha;
        $_SESSION['hora'] = $hora;


        //Y muestro las mesas disponibles
        header("Location: mostrarMesas.php");
        exit();

    }
}


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Indice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 90dvh;
        }

        form {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
            margin-top: 0;
        }

        select,
        input[type="date"] {
            padding: 8px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
        }

        select[multiple] {
            height: auto;
        }

        select[multiple] option {
            padding: 5px;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        #fecha {
            width: 95%;
        }
    </style>
</head>

<body>
<div class="container">
    <form action="" name="form-restaurante" method="post">
        <?php
        echo "<ul>";
        foreach ($errores as $error) {
            echo "<li>" . $error . "</li>";
        }

        echo "</ul>";


        ?>


        <h2>Elige un restaurante: </h2>
        <select id="select-restaurante" name="restaurantes" multiple>
            <?php

            foreach ($restaurantes as $restaurante) {
                echo "<option value='" . $restaurante["restaurante"] . "'>" . $restaurante["restaurante"] . "</option>";
            }

            ?>
        </select>

        <h2>Número de comensales:</h2>

        <select id="select-comensales" name="comensales">

            <?php
            $contador = 1;

            while ($contador <= $capacidad) {
                echo "<option value='" . $contador . "'>" . $contador . "</option>";
                $contador++;
            }
            ?>

        </select>

        <h2>Fecha de la Reserva</h2>
        <input type="date" name="fecha" id="fecha">

        <h2>Hora</h2>
        <select id="hora_reserva" name="hora">

            <?php
            $archivo = "horas.txt";

            $horas = leerDatos($archivo);
            echo "<pre>";
            var_dump($horas);
            echo "</pre>";


            foreach ($horas as $hora) {
                echo "<option value='" . $hora . "'>" . $hora . "</option>";
            }

            ?>

        </select>
        <input type="submit" name="enviar" value="Enviar">
    </form>
        </div>
</body>

</html>