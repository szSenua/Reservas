<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        nav {
            background-color: #342042;
            overflow: hidden;
            position: sticky;
            top: 0;

        }

        nav a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            float: left;
            transition: background-color 0.3s;
        }

        nav a:hover {
            background-color: #714C8F;
        }

        h1 {
            color: #000;
            padding: 10px;
        }
    </style>
    <title></title>
</head>

<body>
    <nav>
        <?php

        session_start();

        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {

        ?>
            <a href="index.php">Realizar una reserva</a>
            <a href="panel_administracion.php">Panel de Administración</a>
            <a href="logout.php">Cerrar Sesión</a>


        <?php

        } else {
        ?>

            <a href="login.php">Zona Administrador</a>
            <a href="index.php">Realizar una reserva</a>

        <?php
        }

        ?>
    </nav>

</body>

</html>