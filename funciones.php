<?php

function obtenerRestaurantes($con)
{

    $sql = "SELECT DISTINCT restaurante FROM mesa GROUP BY restaurante";

    $stmt = $con->prepare($sql);
    $stmt->execute();

    while ($restaurantes = $stmt->fetch(PDO::FETCH_ASSOC)) {
        yield $restaurantes;
    }
}

function obtenerCapacidadMaxima($con)
{
    $sql = "SELECT MAX(capacidad) AS max_capacidad FROM mesa;";

    $stmt = $con->prepare($sql);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);


    return $result['max_capacidad'];
}

//Función para leer un archivo

function leerDatos($archivo)
{
    $datos = [];
    $handle = fopen($archivo, "r");

    if ($handle) {
        while (($line = fgets($handle)) !== false) {
            // Elimina espacios en blanco al principio y al final de la línea
            $line = trim($line);
            // Agrega la línea al array de datos
            $datos[] = $line;
        }

        fclose($handle);
    }

    return $datos;
}

//Función para comprobar si hay mesa disponible con los datos que proporciona el cliente

function obtenerMesasDisponibles($con, $restaurante, $comensales, $fecha, $hora){
    // Calcular la hora anterior y posterior a la hora especificada
    $horaInicio = date('H:i:s', strtotime('-1 hour', strtotime($hora)));
    $horaFin = date('H:i:s', strtotime('+1 hour', strtotime($hora)));

    // Calcular la capacidad requerida en función del número de comensales
    if ($comensales <= 2) {
        $capacidadRequerida = 2;
    } elseif ($comensales <= 4) {
        $capacidadRequerida = 4;
    } else {
        $capacidadRequerida = 8;
    }

    // Consulta para obtener las mesas disponibles
    $sql = "SELECT mesa.numMesa, mesa.capacidad
            FROM mesa
            LEFT JOIN reservas
            ON mesa.numMesa = reservas.numMesa
            AND mesa.restaurante = reservas.restaurante
            AND reservas.fecha = :fecha
            AND reservas.hora > :hora_inicio
            AND reservas.hora < :hora_fin
            WHERE mesa.restaurante = :restaurante
            GROUP BY mesa.numMesa
            HAVING COUNT(reservas.numMesa) = 0
            AND mesa.capacidad = :capacidad_requerida";

  
    $stmt = $con->prepare($sql);

    
    $stmt->execute(array(
        ':fecha' => $fecha,
        ':hora_inicio' => $horaInicio,
        ':hora_fin' => $horaFin,
        ':restaurante' => $restaurante,
        ':capacidad_requerida' => $capacidadRequerida
    ));

    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
