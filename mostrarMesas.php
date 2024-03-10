<?php

require_once 'conecta.php';
require_once 'funciones.php';
require_once 'menu.php';

$restaurante = $_SESSION['restaurante'];
$comensales = $_SESSION['comensales'];
$fecha = $_SESSION['fecha'];
$hora = $_SESSION['hora'];

// Obtener mesas disponibles con la capacidad indicada
$mesasDisponibles = obtenerMesasDisponibles($con, $restaurante, $comensales, $fecha, $hora);

// Crear formateadores de fecha y hora
$fecha_formatter = new IntlDateFormatter('es_ES', IntlDateFormatter::FULL, IntlDateFormatter::NONE);
$hora_formatter = new IntlDateFormatter('es_ES', IntlDateFormatter::NONE, IntlDateFormatter::NONE);

// Si no hay mesas disponibles con la capacidad indicada, intentar con el doble de la capacidad
if (count($mesasDisponibles) == 0) {
    $mesasDisponibles = obtenerMesasDisponibles($con, $restaurante, $comensales * 2, $fecha, $hora);
    
    // Si aún no hay mesas disponibles después de intentar con el doble de la capacidad, redirigir a opciones.php
    if (count($mesasDisponibles) == 0) {
        header("Location: opciones.php");
        exit(); // Asegúrate de salir después de redirigir para evitar que el script siga ejecutándose.
    }
}


$numMesa;
$errores = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reservar'])) {
    // Validar si se ha seleccionado una mesa
    if (!isset($_POST['mesa'])) {
        $errores[] = "Por favor, seleccione una mesa para reservar.";
    } else {
        $numMesa = $_POST['mesa'];
    }

    if (count($errores) == 0) {
        //Si soy administrador, proceso la reserva directamente.
        if ($_SESSION['tipoUsuario']) {
            //Si el usuario es un administrador entonces no hace falta que meta el email de la reserva.
            $email = $_SESSION['email'];
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
                header("Location: mensajes.php");
                exit();
            } else {
                $_SESSION['mensaje_reserva'] = "No se ha podido realizar la reserva.";
            }
        } else {
            $_SESSION['datos_reserva'] = [
                'restaurante' => $restaurante,
                'numMesa' => $numMesa,
                'fecha' => $fecha,
                'hora' => $hora,
                'comensales' => $comensales
            ];

            header("Location: reservarUsuario.php");
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mesas Disponibles</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        p {
            text-align: center;
        }

        h1 {
            text-align: center;
        }

        table {
            width: 20%;
            margin: 0 auto;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 10px;
            text-align: center;
        }

        .circle {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: lightblue;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: auto;
            /* Centra el círculo horizontalmente dentro de la celda */
        }

        .circle span {
            text-align: center;
            /* Centra el texto horizontalmente dentro del círculo */
        }

        input[type="submit"] {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .error {
            color: red;
            text-align: center;
        }
    </style>
</head>

<body>
    <h1>Mesas Disponibles</h1>
    <?php if (!empty($errores)) : ?>
        <div class="error">
            <?php foreach ($errores as $error) : ?>
                <p><?php echo $error; ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <form action="" method="post">
        <p>Fecha: <?php echo (new IntlDateFormatter('es_ES', IntlDateFormatter::FULL, IntlDateFormatter::NONE))->format(new DateTime($fecha)); ?>.
        <p>Hora: <?php echo (new IntlDateFormatter('es_ES', IntlDateFormatter::NONE, IntlDateFormatter::SHORT))->format(new DateTime($hora)); ?></p>

        <p>Número de comensales: <?php echo $comensales; ?></p>
        <table border="1">
            <tr>
                <th>Número de Mesa</th>
                <th>Seleccionar</th>
            </tr>
            <?php foreach ($mesasDisponibles as $mesa) : ?>
                <tr>
                    <td style="text-align: center;"> <!-- Centra el contenido de la celda -->
                        <div class="circle">
                            <span><?php echo "M" . $mesa['numMesa'] . " - "  . $mesa['capacidad'] . "P"; ?></span>
                        </div>
                    </td>
                    <td style="text-align: center;"> <!-- Centra el contenido de la celda -->
                        <input type="radio" name="mesa" value="<?php echo $mesa['numMesa']; ?>">
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <input type="submit" value="Reservar" name="reservar">
    </form>
</body>

</html>

<?php
require_once 'desconecta.php';

?>