<?php

require_once 'conecta.php';
require_once 'funciones.php';
require_once 'menu.php';

//Si no es administrador, redirigir al menú
if($_SESSION['tipoUsuario'] !== "administrador"){
    header("Location: menu.php");
}


$reservas = array();

foreach(obtenerReservas($con) as $reserva){
    $reservas [] = $reserva;
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }

        h1 {
            text-align: center;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: white;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #342042;
            color: white;
        }

        tr:hover {
            background-color: #f2f2f2;
        }

        .actions button {
            margin-right: 5px;
            padding: 5px 10px;
            border: 1px solid #4CAF50;
            background-color: #4CAF50;
            color: white;
            border-radius: 3px;
            cursor: pointer;
        }

        .actions button.delete {
            background-color: #ff0000; /* Cambiamos el color a rojo */
            border-color: #ff0000; /* También cambiamos el color del borde */
        }

        
    </style>
</head>

<body>
    <h1>Reservas</h1>
    <table border="1">
        <tr>
            <th>Restaurante</th>
            <th>Número de Mesa</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Comensales</th>
            <th>Estado</th>
            <th>Acciones</th> <!-- Nueva columna para las acciones -->
        </tr>
        <?php foreach ($reservas as $reserva) : ?>
            <tr>
                <td><?php echo $reserva['restaurante']; ?></td>
                <td><?php echo $reserva['numMesa']; ?></td>
                <td><?php echo $reserva['fecha']; ?></td>
                <td><?php echo $reserva['hora']; ?></td>
                <td><?php echo $reserva['numPersonas']; ?></td>
                <td><?php echo $reserva['estado']; ?></td>
                <td class="actions">
                    <form action="editar_reserva.php" method="GET" style="display: inline;">
                        <input type="hidden" name="restaurante" value="<?php echo $reserva['restaurante']; ?>">
                        <input type="hidden" name="numMesa" value="<?php echo $reserva['numMesa']; ?>">
                        <input type="hidden" name="fecha" value="<?php echo $reserva['fecha']; ?>">
                        <input type="hidden" name="hora" value="<?php echo $reserva['hora']; ?>">
                        <button type="submit" name="editar">Editar</button>
                    </form>
                    <form action="eliminar_reserva.php" method="POST" style="display: inline;">
                        <input type="hidden" name="restaurante" value="<?php echo $reserva['restaurante']; ?>">
                        <input type="hidden" name="numMesa" value="<?php echo $reserva['numMesa']; ?>">
                        <input type="hidden" name="fecha" value="<?php echo $reserva['fecha']; ?>">
                        <input type="hidden" name="hora" value="<?php echo $reserva['hora']; ?>">
                        <button type="submit" class="delete">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>
