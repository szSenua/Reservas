<?php
require_once 'conecta.php';
require_once 'funciones.php';
require_once 'menu.php';

// Obtener la fecha y hora actual
$fechaHoraActual = new DateTime();

// Calcular la fecha y hora de hace una hora
$fechaHoraHaceUnaHora = (clone $fechaHoraActual)->modify('-1 hour');

// Convertir las fechas y horas en strings
$fechaActual = $fechaHoraActual->format('Y-m-d');
$horaHaceUnaHora = $fechaHoraHaceUnaHora->format('H:i:s');

// Consulta para seleccionar las reservas caducadas
$sql_select = "SELECT * FROM reservas WHERE fecha <= :fecha AND hora <= :hora";
$stmt_select = $con->prepare($sql_select);
$stmt_select->bindParam(':fecha', $fechaActual, PDO::PARAM_STR);
$stmt_select->bindParam(':hora', $horaHaceUnaHora, PDO::PARAM_STR);
$stmt_select->execute();
$reservas_borradas_datos = $stmt_select->fetchAll(PDO::FETCH_ASSOC);

// Obtener las reservas que se van a eliminar
$sql_delete = "DELETE FROM reservas WHERE fecha <= :fecha AND hora <= :hora";
$stmt_delete = $con->prepare($sql_delete);
$stmt_delete->bindParam(':fecha', $fechaActual, PDO::PARAM_STR);
$stmt_delete->bindParam(':hora', $horaHaceUnaHora, PDO::PARAM_STR);
$stmt_delete->execute();

// Obtener el número de reservas borradas
$reservas_borradas = $stmt_delete->rowCount();

// HTML directo para mostrar el resultado
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrar Reservas Caducadas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-top: 0;
            text-align: center;
        }

        p {
            text-align: center;
        }

        .reserva {
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if ($reservas_borradas > 0): ?>
            <h2>Reservas borradas:</h2>
            <?php foreach ($reservas_borradas_datos as $reserva): ?>
                <div class="reserva">
                    <p><strong>Restaurante:</strong> <?php echo $reserva['restaurante']; ?></p>
                    <p><strong>Número de Mesa:</strong> <?php echo $reserva['numMesa']; ?></p>
                    <p><strong>Fecha:</strong> <?php echo $reserva['fecha']; ?></p>
                    <p><strong>Hora:</strong> <?php echo $reserva['hora']; ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No se han encontrado reservas caducadas para borrar.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
require_once 'desconecta.php';
?>
