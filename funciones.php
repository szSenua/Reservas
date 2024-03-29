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

function obtenerMesasDisponibles($con, $restaurante, $comensales, $fecha, $hora)
{
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
    $sql = "SELECT mesa.numMesa, mesa.capacidad, mesa.ncolumna, mesa.nfila
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

function existeUsuario($con, $email, $contrasena)
{
    $sql = "SELECT * FROM administradores where email = ? and contrasena = ?";

    $stmt = $con->prepare($sql);
    $stmt->bindParam(1, $email);
    $stmt->bindParam(2, $contrasena);

    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $adminData = $stmt->fetch(PDO::FETCH_ASSOC);
        // Cerrar conexión
        require_once 'desconecta.php';
        return array(
            'tipo' => 'administrador',
            'email' => $adminData['email'],
            'nombre' => $adminData['nombre']
        );
    }
}

function reservarMesa($con, $email, $restaurante, $numMesa, $fecha, $hora, $comensales)
{

    $sql = "INSERT INTO reservas (numMesa, restaurante, email, fecha, hora, estado, numPersonas)
    VALUES (?, ?, ?, ?, ?, ?, ?)";

    $estado = 'R';

    $stmt = $con->prepare($sql);
    $stmt->bindParam(1, $numMesa);
    $stmt->bindParam(2, $restaurante);
    $stmt->bindParam(3, $email);
    $stmt->bindParam(4, $fecha);
    $stmt->bindParam(5, $hora);
    $stmt->bindParam(6, $estado);
    $stmt->bindParam(7, $comensales);

    $estado = $stmt->execute();

    return $estado;
}

function consultarMesasTiempoEspera($con, $restaurante, $fecha, $hora, $comensales, $tiempoEsperaMaximo)
{
    if ($comensales <= 2) {
        $capacidadRequerida = 2;
    } elseif ($comensales <= 4) {
        $capacidadRequerida = 4;
    } else {
        $capacidadRequerida = 8;
    }

    // Consulta SQL para obtener las mesas reservadas y sus datos
    $sql = "SELECT reservas.numMesa, mesa.capacidad, reservas.estado FROM reservas INNER JOIN mesa 
    ON reservas.numMesa = mesa.numMesa 
    AND mesa.capacidad = ?
    AND reservas.fecha = ?
    AND reservas.hora = ?";

    $stmt = $con->prepare($sql);
    $stmt->bindParam(1, $capacidadRequerida);
    $stmt->bindParam(2, $fecha);
    $stmt->bindParam(3, $hora);
    $stmt->execute();

    $mesasTiempoEspera = [];

    // Calcular el tiempo de espera estimado para cada reserva y almacenarlo en un array asociativo
    while ($reserva = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $tiempoEspera = 0;
        // Calcular el tiempo estimado basado en el estado de la reserva
        if ($reserva['estado'] == "R") {
            $tiempoEspera = 60;
        } elseif ($reserva['estado'] == 'O') {
            $tiempoEspera = 45;
        } elseif ($reserva['estado'] == 'EC' || $reserva['estado'] == 'PA') {
            $tiempoEspera = 10;
        }

        // Verificar si el tiempo de espera es menor o igual al tiempo máximo dispuesto por el cliente
        if ($tiempoEspera <= $tiempoEsperaMaximo) {
            // Calcula la nueva hora de reserva ajustando la hora original y restando el tiempo de espera máximo
            $nuevaHoraReserva = strtotime($hora . ' +1 hour -' . $tiempoEsperaMaximo . ' minute + ' . $tiempoEsperaMaximo . ' minute');




            $mesasTiempoEspera[$reserva['numMesa']] = [
                'capacidad' => $reserva['capacidad'],
                'tiempoEspera' => $tiempoEspera,
                'nuevaHoraReserva' => date('H:i:s', $nuevaHoraReserva)
            ];
        }
    }

    return $mesasTiempoEspera;
}

function obtenerReservas($con)
{
    $sql = "SELECT * FROM reservas";

    $stmt = $con->prepare($sql);
    $stmt->execute();

    while ($reservas = $stmt->fetch(PDO::FETCH_ASSOC)) {
        yield $reservas;
    }
}

function obtenerEstados($con){
    $sql = "SHOW COLUMNS FROM `reservas` LIKE 'estado'";
    $stmt = $con->query($sql);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $type = $row['Type'];
    preg_match('/enum\((.*)\)$/', $type, $matches);
    $vals = explode(',', $matches[1]);
    $enumValues = array();
    foreach ($vals as $val) {
        $enumValues[] = trim($val, "'");
    }
    return $enumValues;
}

function obtenerReservaPorDatos($conexion, $restaurante, $numMesa, $fecha, $hora) {
    $sql = "SELECT * FROM reservas WHERE restaurante = :restaurante AND numMesa = :numMesa AND fecha = :fecha AND hora = :hora";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':restaurante', $restaurante, PDO::PARAM_STR);
    $stmt->bindParam(':numMesa', $numMesa, PDO::PARAM_INT);
    $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
    $stmt->bindParam(':hora', $hora, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

