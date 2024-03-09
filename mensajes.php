<?php
require_once 'menu.php';

// Verificar si existe un mensaje de reserva y datos de reserva en la sesión
if (isset($_SESSION['mensaje_reserva']) && isset($_SESSION['datos_reserva'])) {
    $mensaje_reserva = $_SESSION['mensaje_reserva'];
    $datos_reserva = $_SESSION['datos_reserva'];

    // Limpiar las variables de sesión después de utilizarlas
    unset($_SESSION['mensaje_reserva']);
    unset($_SESSION['datos_reserva']);
} else {
    // Si no hay datos en la sesión, redireccionar al usuario a otra página
    header("Location: otra_pagina.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensaje de Reserva</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        p {
            color: #555;
        }

        h2 {
            color: #333;
            margin-top: 20px;
        }

        .data {
            margin-left: 20px;
            color: #555;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Estado de la Reserva</h1>
        <p><?php echo $mensaje_reserva; ?></p>
        <h2>Datos de la Reserva:</h2>
        <div class="data">
            <p><strong>Restaurante:</strong> <?php echo $datos_reserva['restaurante']; ?></p>
            <p><strong>Número de Mesa:</strong> <?php echo $datos_reserva['numMesa']; ?></p>
            <p><strong>Fecha:</strong> <?php echo $datos_reserva['fecha']; ?></p>
            <p><strong>Hora:</strong> <?php echo $datos_reserva['hora']; ?></p>
            <p><strong>Comensales:</strong> <?php echo $datos_reserva['comensales']; ?></p>
        </div>
    </div>
</body>

</html>
