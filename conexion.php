<?php
$server = "sql100.infinityfree.com";
$user = "if0_40570600";
$pass = "fbHEdXjuZGv";
$base_datos = "f0_40570600_vetproy3";
$conexion = new mysqli($server, $user, $pass,$base_datos);

if ($conexion->connect_errno) {
    die("Error de conexión: " . $conexion->connect_error);
}

$conexion->set_charset("utf8");
?>
