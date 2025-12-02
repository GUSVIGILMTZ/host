<?php
include "conexion.php";

$bd = $_GET['bd'];
$tabla = $_GET['tabla'];
$id = $_GET['id'];
$conexion->bd_ferreteria($bd);

$pk = $conexion->query("SHOW KEYS FROM $tabla WHERE Key_name='PRIMARY'")
               ->fetch_assoc()['Column_name'];

$registro = $conexion->query("SELECT * FROM $tabla WHERE $pk = '$id'")->fetch_assoc();

if ($_POST) {
    $set = [];
    foreach ($_POST as $campo => $valor) {
        $set[] = "$campo = '" . $conexion->real_escape_string($valor) . "'";
    }
    $sql = "UPDATE $tabla SET " . implode(",", $set) . " WHERE $pk = '$id'";
    $conexion->query($sql);

    echo "<script>alert('Registro actualizado');window.location='mostrar.php?bd=$bd&tabla=$tabla';</script>";
}
?>

<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>Editar</title></head>
<body>

<h2>Editar registro en <?= $tabla ?></h2>

<form method="POST">
<?php foreach ($registro as $campo => $valor) { ?>
    <?= $campo ?>:<br>
    <input type="text" name="<?= $campo ?>" value="<?= htmlspecialchars($valor) ?>"><br><br>
<?php } ?>
    <button type="submit">Actualizar</button>
</form>

</body>
</html>
