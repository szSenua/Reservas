<?php
require_once 'conecta.php';
require_once 'funciones.php';
require_once 'menu.php';

// Verificar si se ha enviado el formulario de edición
if (isset($_GET['editar'])) {
    // Recuperar los datos del formulario
    $restaurante = $_GET['restaurante'];
    $numMesa = $_GET['numMesa'];
    $fecha = $_GET['fecha'];
    $hora = $_GET['hora'];

    // Obtener la reserva específica que se desea editar
    $reserva = obtenerReservaPorDatos($con, $restaurante, $numMesa, $fecha, $hora);

    if ($reserva) {
        // Obtener todos los estados de la base de datos
        $estados = obtenerEstados($con);

        // Mostrar el formulario de edición
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Editar Reserva</title>
            <!DOCTYPE html>
            <html lang="en">

            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Editar Reserva</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        margin: 0;
                        padding: 0;
                        background-color: #f4f4f4;
                    }

                    .container {
                        max-width: 500px;
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

                    form {
                        display: flex;
                        flex-direction: column;
                    }

                    label {
                        margin-bottom: 5px;
                    }

                    input[type="text"],
                    input[type="email"],
                    input[type="number"],
                    select {
                        width: 100%;
                        padding: 8px;
                        margin-bottom: 10px;
                        border: 1px solid #ccc;
                        border-radius: 4px;
                        box-sizing: border-box;
                    }

                    input[type="submit"] {
                        background-color: #4CAF50;
                        color: white;
                        padding: 10px 20px;
                        border: none;
                        border-radius: 4px;
                        cursor: pointer;
                    }

                    input[type="submit"]:hover {
                        background-color: #45a049;
                    }
                </style>
            </head>

        <body>
            <div class="container">
                <h2>Editar Reserva</h2>
                <form action="actualizar_reserva.php" method="POST">
                    <input type="hidden" name="restaurante" value="<?php echo htmlspecialchars($reserva['restaurante']); ?>">
                    <input type="hidden" name="numMesa" value="<?php echo htmlspecialchars($reserva['numMesa']); ?>">
                    <input type="hidden" name="fecha" value="<?php echo htmlspecialchars($reserva['fecha']); ?>">
                    <input type="hidden" name="hora" value="<?php echo htmlspecialchars($reserva['hora']); ?>">
                    <label for="estado">Estado:</label>
                    <select name="estado">
                        <?php foreach ($estados as $estado) : ?>
                            <option value="<?php echo htmlspecialchars($estado); ?>" <?php echo ($reserva['estado'] == $estado) ? 'selected' : ''; ?>><?php echo htmlspecialchars($estado); ?></option>
                        <?php endforeach; ?>
                    </select>

                    <input type="submit" name="actualizar" value="Actualizar">
                </form>
            </div>
        </body>

        </html>

<?php
    } else {
        echo 'Reserva no encontrada.';
    }
}
?>