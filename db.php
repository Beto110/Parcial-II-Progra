<?php
$host = "localhost";
$user = "root"; // Tu usuario de phpmyadmin
$pass = ""; // Tu contraseña de phpmyadmin
$db = "ugb_inscripciones";

$conexion = mysqli_connect($host, $user, $pass, $db);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>