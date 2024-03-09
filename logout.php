<?php
session_start();
session_destroy();
$con = null;

header("Location: menu.php");


?>