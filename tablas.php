<?php
include "conexion.php";

// Validar parámetro
if (!isset($_GET['bd']) || empty($_GET['bd'])) {
    die("Error: No se especificó la base de datos.");
}

$bd = $_GET['bd'];

// Validar que solo contenga letras, números y _
if (!preg_match('/^[a-zA-Z0-9_]+$/', $bd)) {
    die("Nombre de base de datos inválido.");
}

// Seleccionar la base de datos
$conexion->select_db($bd);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Tablas</title>
</head>
<body>

<h2>Base de datos: <?= htmlspecialchars($bd) ?></h2>

<a href="index.php">← Cambiar Base de Datos</a> |
<a href="eliminar_bd.php?bd=<?= urlencode($bd) ?>" onclick="return confirm('¿ELIMINAR BASE DE DATOS COMPLETA?');">
    🗑 Eliminar BD
</a>

<h3>Seleccionar Tabla</h3>

<?php
$tablas = $conexion->query("SHOW TABLES");

if ($tablas) {
    while ($t = $tablas->fetch_array()) {
        $tabla = $t[0];
        echo "<a href='mostrar.php?bd=" . urlencode($bd) . "&tabla=" . urlencode($tabla) . "'>$tabla</a><br>";
    }
} else {
    echo "No se pudo obtener la lista de tablas.";
}
?>

</body>
</html>


