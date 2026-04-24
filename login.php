
<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['usuario'];
    $pass = $_POST['password'];

    // Validación básica para evitar inyección SQL simple
    $user = mysqli_real_escape_string($conexion, $user);
    $pass = mysqli_real_escape_string($conexion, $pass);

    $query = "SELECT * FROM usuarios WHERE usuario='$user' AND password='$pass'";
    $resultado = mysqli_query($conexion, $query);

    if (mysqli_num_rows($resultado) > 0) {
        $_SESSION['usuario'] = $user;
        header("Location: admin.php"); // Redirige al formulario de ingreso
        exit();
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login UGB</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Acceso al Sistema</h2>
    <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST" action="">
        <label>Usuario:</label><br>
        <input type="text" name="usuario" required><br><br>
        <label>Contraseña:</label><br>
        <input type="password" name="password" required><br><br>
        <button type="submit">Ingresar</button>
    </form>
    <br>
    <a href="index.php">Volver al inicio</a>
</body>
</html>