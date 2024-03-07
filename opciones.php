<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Opciones</title>
</head>
<body>
    


<?php

require_once "conecta.php";
require_once "funciones.php";

session_start();

$fecha = $_SESSION['fecha'];
$hora = $_SESSION['hora'];





?>
<h2>Actualmente no existen reservas para la fecha <?php echo $fecha ?> 
, hora <?php echo $hora ?> y restaurante <?php echo $restaurante ?></h2>

</body>
</html>