<?php
session_start();


if (isset($_POST['usuario']) && isset($_POST['password'])) {
    $user = $_POST['usuario'];
    $pass = $_POST['password'];

    if ($user === "isc_dany" && $pass === "123asd") {
        $_SESSION['logueado'] = true;
    } else {
        $error = "Usuario o contraseña incorrectos";
    }
}


if (!isset($_SESSION['logueado'])) {
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Login</title>
</head>
<body>

<h2>Iniciar sesión</h2>

<?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

<form method="POST">
    Usuario: <input type="text" name="usuario" required><br><br>
    Contraseña: <input type="password" name="password" required><br><br>
    <button type="submit">Entrar</button>
</form>

</body>
</html>
<?php
    exit(); // Detener aquí y no mostrar el resto
}
?>

<?php include "conexion.php"; ?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Proyecto</title>
</head>
<body>

<h2>Seleccione una base de datos</h2>

<form action="tablas.php" method="GET">
    <select name="bd">
        <?php
        $dbs = $conexion->query("SHOW DATABASES");
        while ($db = $dbs->fetch_assoc()) {
            echo "<option value='{$db['Database']}'>{$db['Database']}</option>";
        }
        ?>
    </select>
    <button type="submit">Entrar</button>
</form>

</body>
</html>
