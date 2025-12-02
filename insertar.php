<?php
include "conexion.php";

$bd = $_GET['bd'];
$tabla = $_GET['tabla'];
$conexion->ferreteria($bd);

if ($_POST) {
    $campos = array_keys($_POST);
    $valores = array_map(fn($v) => "'" . $conexion->real_escape_string($v) . "'", $_POST);
    $sql = "INSERT INTO $tabla (" . implode(",", $campos) . ") VALUES (" . implode(",", $valores) . ")";
    $conexion->query($sql);

    echo "<script>alert('Registro insertado');window.location='mostrar.php?bd=$bd&tabla=$tabla';</script>";
}

$columnas = $conexion->query("DESCRIBE $tabla");
?>

<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>Insertar</title></head>
<body>

<h2>Insertar en <?= $tabla ?></h2>
<a href="mostrar.php?bd=<?= $bd ?>&tabla=<?= $tabla ?>">← Volver</a>

<form method="POST">
<?php while ($c = $columnas->fetch_assoc()) { ?>
    <?= $c['Field'] ?>:<br>
    <input type="text" name="<?= $c['Field'] ?>"><br><br>
<?php } ?>
    <button type="submit">Guardar</button>
</form>

</body>
</html>
