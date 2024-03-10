<?php
require_once 'menu.php';
require_once 'conecta.php';
require_once 'funciones.php';

// Iniciar sesión si no se ha iniciado aún


$restaurante = null;
$fecha = null;
$hora = null;
$comensales = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['consultar_tiempo'])) {

    $restaurante = $_SESSION['restaurante'];
    $fecha = $_SESSION['fecha'];
    $hora = $_SESSION['hora'];
    $comensales = $_SESSION['comensales'];
    $tiempoEsperaMaximo = $_POST['tiempo_espera'];

    $mesasLibres = consultarMesasTiempoEspera($con, $restaurante, $fecha, $hora, $comensales, $tiempoEsperaMaximo);

    if(count($mesasLibres) == 0){
        echo "<h2>No existen mesas reservadas a la hora especificada</h2>";
    } else {
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

        table, th, td {
            border: 1px solid black;
        }

        th, td {
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
            margin: auto; /* Centra el círculo horizontalmente dentro de la celda */
        }

        .circle span {
            text-align: center; /* Centra el texto horizontalmente dentro del círculo */
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
<form action="" method="post">
    <p>Fecha: <?php echo (new IntlDateFormatter('es_ES', IntlDateFormatter::FULL, IntlDateFormatter::NONE))->format(new DateTime($fecha)); ?>. <p>Hora: <?php echo (new IntlDateFormatter('es_ES', IntlDateFormatter::NONE, IntlDateFormatter::SHORT))->format(new DateTime($hora)); ?></p>
    <p>Número de comensales: <?php echo $comensales; ?></p>
    <table border="1">
        <tr>
            <th>Número de Mesa</th>
            <th>Capacidad</th>
            <th>Tiempo de Espera (minutos)</th>
            <th>Nueva hora reserva</th>
            <th>Seleccionar</th>
        </tr>
        <?php foreach ($mesasLibres as $numMesa => $infoMesa) : ?>
            <tr>
                <td style="text-align: center;"><?php echo "M" . $numMesa; ?></td>
                <td style="text-align: center;"><?php echo $infoMesa['capacidad'] . "P"; ?></td>
                <td style="text-align: center;"><?php echo $infoMesa['tiempoEspera']; ?></td>
                <td style="text-align: center;"><?php echo $infoMesa['nuevaHoraReserva']; ?></td>
                <td style="text-align: center;">
                    <input type="radio" name="mesa" value="<?php echo $numMesa; ?>">
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <input type="submit" value="Reservar" name="reservar">
    <input type="hidden" name="hora_reserva" value="<?php echo $infoMesa['nuevaHoraReserva']; ?>">
</form>
<?php
    }
} else if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reservar'])){

    // Obtener datos de reserva de la sesión
    $restaurante = $_SESSION['restaurante'];
    $numMesa = $_POST['mesa'];
    $fecha = $_SESSION['fecha'];
    $hora = $_POST['hora_reserva']; // Usar la hora seleccionada en el formulario
    $comensales = $_SESSION['comensales'];

    // Almacenar los datos de reserva en una sesión
    $_SESSION['datos_nueva_reserva'] = [
        'restaurante' => $restaurante,
        'numMesa' => $numMesa,
        'fecha' => $fecha,
        'nuevaHoraReserva' => $hora,
        'comensales' => $comensales
    ];

    require_once 'desconecta.php';

    header("Location: realizar_reserva.php");

    
}
?>
</body>
</html>
