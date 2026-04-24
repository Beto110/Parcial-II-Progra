
<?php
session_start();
include 'db.php';

// Validar que el usuario esté logueado (Cumple punto 3)
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$mensaje = "";

// Lógica de inserción y validación (Cumple punto 4)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = mysqli_real_escape_string($conexion, trim($_POST['nombre']));
    $carrera = mysqli_real_escape_string($conexion, $_POST['carrera']);
    $genero = isset($_POST['genero']) ? mysqli_real_escape_string($conexion, $_POST['genero']) : '';
    $obs = mysqli_real_escape_string($conexion, trim($_POST['observaciones']));

    // Validaciones
    if (empty($nombre) || empty($carrera) || empty($genero)) {
        $mensaje = "<p style='color:red;'>Error: Todos los campos marcados con * son obligatorios.</p>";
    } else {
        // Manejo del valor nulo (si viene vacío, lo inserta como NULL en la BD)
        $obs_sql = empty($obs) ? "NULL" : "'$obs'";

        $query = "INSERT INTO estudiantes (nombre_completo, carrera, genero, observaciones) 
                  VALUES ('$nombre', '$carrera', '$genero', $obs_sql)";

        if (mysqli_query($conexion, $query)) {
            $mensaje = "<p style='color:green;'>Estudiante registrado exitosamente.</p>";
        } else {
            $mensaje = "<p style='color:red;'>Error al registrar: " . mysqli_error($conexion) . "</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administración UGB</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Bienvenido, <?php echo $_SESSION['usuario']; ?></h2>
    <a href="logout.php">Cerrar Sesión</a> | <a href="index.php">Ver tabla pública</a>
    <hr>
    
    <h3>Registrar Nuevo Estudiante</h3>
    <?php echo $mensaje; ?>
    
    <form method="POST" action="">
        <label>Nombre Completo (*):</label><br>
        <input type="text" name="nombre" required><br><br>

        <label>Carrera (*):</label><br>
        <select name="carrera" required>
            <option value="">-- Seleccione una carrera --</option>
            <option value="Ingeniería en Sistemas">Ingeniería en Sistemas</option>
            <option value="Licenciatura en Enfermería">Licenciatura en Enfermería</option>
            <option value="Doctorado en Medicina">Doctorado en Medicina</option>
            <option value="Licenciatura en Administración">Licenciatura en Administración</option>
        </select><br><br>

        <label>Género (*):</label><br>
        <input type="radio" name="genero" value="Masculino" required> Masculino
        <input type="radio" name="genero" value="Femenino" required> Femenino
        <input type="radio" name="genero" value="Otro" required> Otro<br><br>

        <label>Observaciones (Opcional - acepta NULL):</label><br>
        <textarea name="observaciones" rows="3" cols="30"></textarea><br><br>

        <button type="submit">Guardar Estudiante</button>
    </form>
</body>
</html>