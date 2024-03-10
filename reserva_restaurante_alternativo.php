<?php
require_once 'conecta.php';
require_once 'funciones.php';
require_once 'menu.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['consultar_restaurante'])) {

    $alternativo = $_SESSION['alternativo'];
    $fecha = $_SESSION['fecha'];
    $hora = $_SESSION['hora'];
    $comensales = $_SESSION['comensales'];

    //testing
    //var_dump($_SESSION);

    $mesasDisponibles = obtenerMesasDisponibles($con, $alternativo, $comensales, $fecha, $hora);

    if (count($mesasDisponibles) == 0) {
        $mesasDisponibles = obtenerMesasDisponibles($con, $alternativo, $comensales * 2, $fecha, $hora);

        if (count($mesasDisponibles) == 0) {
            echo "<h2>Lo sentimos, no tenemos mesas para ese día. Intente realizar una nueva reserva con una fecha y hora diferentes<h2>";
            echo "<h2>Sentimos las molestias</h2>";
        }
    }
} else if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reservar'])){

    $alternativo = $_SESSION['alternativo'];
    $fecha = $_SESSION['fecha'];
    $hora = $_SESSION['hora'];
    $comensales = $_SESSION['comensales'];
    $_SESSION['numMesa'] = $_POST['mesa'];


    require_once 'desconecta.php';
    header("Location: realizar_reserva_alternativo.php");
    exit();
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
        <p>Restaurante: <?php echo $alternativo ?></p>
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