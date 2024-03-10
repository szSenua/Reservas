<?php
require_once 'conecta.php';
require_once 'funciones.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar los datos del formulario
    $restaurante = $_POST['restaurante'];
    $numMesa = $_POST['numMesa'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];

    // Eliminar la reserva de la base de datos
    $sql = "DELETE FROM reservas WHERE restaurante = :restaurante AND numMesa = :numMesa AND fecha = :fecha AND hora = :hora";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(':restaurante', $restaurante, PDO::PARAM_STR);
    $stmt->bindParam(':numMesa', $numMesa, PDO::PARAM_INT);
    $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
    $stmt->bindParam(':hora', $hora, PDO::PARAM_STR);

    if ($stmt->execute()) {
        // Redireccionar a la página de éxito
        header("Location: panel_administracion.php");
        exit();
    } else {
        // Mostrar mensaje de error
        echo "Error al eliminar la reserva.";
    }
} 

require_once 'desconecta.php';
?>
