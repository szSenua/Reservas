<?php
require_once 'conecta.php';
require_once 'funciones.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar los datos del formulario
    $restaurante = $_POST['restaurante'];
    $numMesa = $_POST['numMesa'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $estado = $_POST['estado'];
    $numPersonas = $_POST['numPersonas'];

    // Actualizar la reserva en la base de datos
    $sql = "UPDATE reservas SET estado = :estado WHERE restaurante = :restaurante AND numMesa = :numMesa AND fecha = :fecha AND hora = :hora";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);
    $stmt->bindParam(':restaurante', $restaurante, PDO::PARAM_STR);
    $stmt->bindParam(':numMesa', $numMesa, PDO::PARAM_INT);
    $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
    $stmt->bindParam(':hora', $hora, PDO::PARAM_STR);

    if ($stmt->execute()) {
        // Redireccionar al panel
        header("Location: panel_administracion.php");
        exit();
    } else {
        // Mostrar mensaje de error
        echo "Error al actualizar la reserva.";
    }
}

require_once 'desconecta.php';
?>
