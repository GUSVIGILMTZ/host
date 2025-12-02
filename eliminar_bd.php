<?php
include "conexion.php";

$bd = $_GET['bd'];
$conexion->query("DROP DATABASE $bd");

echo "<script>alert('La base de datos ha sido eliminada');window.location='index.php';</script>";
?>
