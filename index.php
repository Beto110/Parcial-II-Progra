
<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>UGB - Estudiantes Inscritos</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Listado de Estudiantes (Vista Pública)</h2>
    <a href="login.php">Iniciar Sesión (Solo Personal)</a>
    <hr>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Carrera</th>
                <th>Género</th>
                <th>Observaciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Selecciona y ORDENA los datos (Cumple punto 3)
            $query = "SELECT * FROM estudiantes ORDER BY nombre_completo ASC";
            $resultado = mysqli_query($conexion, $query);

            while ($fila = mysqli_fetch_assoc($resultado)) {
                echo "<tr>";
                echo "<td>" . $fila['id'] . "</td>";
                echo "<td>" . $fila['nombre_completo'] . "</td>";
                echo "<td>" . $fila['carrera'] . "</td>";
                echo "<td>" . $fila['genero'] . "</td>";
                // Manejo del valor nulo visualmente
                echo "<td>" . ($fila['observaciones'] ? $fila['observaciones'] : '<em>Sin datos</em>') . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>