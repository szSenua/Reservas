<?php

require_once 'conecta.php';
require_once 'funciones.php';

session_start();

$restaurante = $_SESSION['restaurante'];
$comensales = $_SESSION['comensales'];
$fecha = $_SESSION['fecha'];
$hora = $_SESSION['hora'];

//funciona
$mesasDisponibles = obtenerMesasDisponibles($con, $restaurante, $comensales, $fecha, $hora);

//mostrar las mesas si mesasDisponibles contiene datos
echo "<pre>";
var_dump($mesasDisponibles);
echo "</pre>";

if(count($mesasDisponibles) > 0){
    echo "hay mesas";
} else {
    header("Location : opciones.php");
}


?>