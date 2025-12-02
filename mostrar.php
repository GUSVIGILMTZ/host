<?php
include "conexion.php";

// Validar parámetros
if (!isset($_GET['bd'], $_GET['tabla'])) {
    die("Error: Parámetros incompletos.");
}

$bd    = $_GET['bd'];
$tabla = $_GET['tabla'];

// Validación básica
if (!preg_match('/^[a-zA-Z0-9_]+$/', $bd) ||
    !preg_match('/^[a-zA-Z0-9_]+$/', $tabla)) {
    die("Nombre de base de datos o tabla inválido.");
}

// Seleccionar base
$conexion->select_db($bd);

// Obtener Primary Key
$pkQuery = $conexion->query("SHOW KEYS FROM `$tabla` WHERE Key_name='PRIMARY'");
$pkRow   = $pkQuery ? $pkQuery->fetch_assoc() : null;
$pk      = $pkRow ? $pkRow['Column_name'] : null;

// Buscar registros
$buscar = isset($_GET['buscar']) ? $_GET['buscar'] : "";

if ($buscar != "") {
    $buscarEsc = $conexion->real_escape_string($buscar);
    $cols = [];
    $q = $conexion->query("DESCRIBE `$tabla`");

    while ($c = $q->fetch_assoc()) {
        $cols[] = "`{$c['Field']}` LIKE '%$buscarEsc%'";
    }

    $query = "SELECT * FROM `$tabla` WHERE " . implode(" OR ", $cols);
} else {
    $query = "SELECT * FROM `$tabla`";
}

$resultado = $conexion->query($query);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?= htmlspecialchars($tabla) ?></title>
</head>
<body>

<h2>Tabla: <?= htmlspecialchars($tabla) ?> (BD: <?= htmlspecialchars($bd) ?>)</h2>

<a href="tablas.php?bd=<?= urlencode($bd) ?>">← Volver</a>
<br><br>

<form method="GET">
    <input type="hidden" name="bd" value="<?= htmlspecialchars($bd) ?>">
    <input type="hidden" name="tabla" value="<?= htmlspecialchars($tabla) ?>">
    
    Buscar: 
    <input type="text" name="buscar" value="<?= htmlspecialchars($buscar) ?>">
    <button type="submit">Buscar</button>
</form>

<br>

<a href="insertar.php?bd=<?= urlencode($bd) ?>&tabla=<?= urlencode($tabla) ?>">
    ➕ Insertar Nuevo Registro
</a>

<br><br>

<table border="1" cellpadding="8">
<tr>
    <?php 
    // Mostrar encabezados
    while ($col = $resultado->fetch_field()) {
        echo "<th>" . htmlspecialchars($col->name) . "</th>";
    }
    ?>
    <th>Acciones</th>
</tr>

<?php 
// Mostrar registros
while ($fila = $resultado->fetch_assoc()) { ?>
<tr>
    <?php foreach ($fila as $v) { ?>
        <td><?= htmlspecialchars($v) ?></td>
    <?php } ?>

    <td>
        <?php if ($pk): ?>
            <a href="editar.php?bd=<?= urlencode($bd) ?>&tabla=<?= urlencode($tabla) ?>&id=<?= urlencode($fila[$pk]) ?>">✏ Editar</a> |
            <a href="eliminar.php?bd=<?= urlencode($bd) ?>&tabla=<?= urlencode($tabla) ?>&id=<?= urlencode($fila[$pk]) ?>" 
               onclick="return confirm('¿Eliminar este registro?');">🗑 Eliminar</a>
        <?php else: ?>
            Sin PK
        <?php endif; ?>
    </td>
</tr>
<?php } ?>

</table>

</body>
</html>

