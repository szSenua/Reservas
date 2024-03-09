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

// Si no hay mesas disponibles con la capacidad indicada, intentar con el doble de la capacidad
if(count($mesasDisponibles) == 0) {
    $mesasDisponibles = obtenerMesasDisponibles($con, $restaurante, $comensales, $fecha, $hora, $comensales * 2);
}

// Si todavía no hay mesas disponibles, redirigir al usuario a la página de opciones
if(count($mesasDisponibles) == 0) {
    header("Location: opciones.php");
    exit();
}


// Si hay mesas disponibles, mostrarlas en una tabla con radios
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mesas Disponibles</title>
    <style>
        .circle {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: lightblue;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: auto; /* Centra el círculo horizontalmente dentro de la celda */
        }
        .circle span {
            text-align: center; /* Centra el texto horizontalmente dentro del círculo */
        }
    </style>
</head>
<body>
    <h1>Mesas Disponibles</h1>
    <form action="reservarMesas.php" method="post">
    <p>Fecha: <?php echo (new DateTime($fecha))->format('l j F Y'); ?>. Hora: <?php echo (new DateTime($hora))->format('H:i'); ?>. Número de comensales: <?php echo $comensales; ?></p>
        <table border="1">
            <tr>
                <th>Número de Mesa</th>
                <th>Seleccionar</th>
            </tr>
            <?php foreach ($mesasDisponibles as $mesa) : ?>
            <tr>
                <td style="text-align: center;"> <!-- Centra el contenido de la celda -->
                    <div class="circle">
                        <span><?php echo "M" . $mesa['numMesa'] . " - "  .$mesa['capacidad'] . "P"; ?></span>
                    </div>
                </td>
                <td style="text-align: center;"> <!-- Centra el contenido de la celda -->
                    <input type="radio" name="mesa" value="<?php echo $mesa['numMesa']; ?>">
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <input type="submit" value="Reservar">
    </form>
</body>
</html>
