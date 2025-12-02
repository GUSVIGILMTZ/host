<?php
include "conexion.php";

$bd = $_GET['bd'];
$tabla = $_GET['tabla'];
$id = $_GET['id'];
$conexion->ferreteria($bd);

$pk = $conexion->query("SHOW KEYS FROM $tabla WHERE Key_name='PRIMARY'")
               ->fetch_assoc()['Column_name'];

$conexion->query("DELETE FROM $tabla WHERE $pk = '$id'");

echo "<script>alert('Registro eliminado');window.location='mostrar.php?bd=$bd&tabla=$tabla';</script>";
?>
