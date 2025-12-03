<?php
    $host = 'db';
    $dbname = 'registro';
    $username = 'usuario';
    $password = '123456';

    // Conexión a la base de datos usando MySQLi
    $conexion = new mysqli($host, $username, $password, $dbname);

    // Verificar conexión
    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta</title>

    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> 
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Usuarios registrados</h1>

        <?php
            $resultado = mysqli_query($conexion,"SELECT * FROM usuarios;");
            echo "<table class=\"table table-striped table-hover\">
            <thead>
            <tr>
            <th>id</th>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Edad</th>
            </tr>
            </thead>";

            echo "<tbody>";
            while($row = mysqli_fetch_array($resultado)) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['nombre'] . "</td>";
                echo "<td>" . $row['correo'] . "</td>";
                echo "<td>" . $row['edad'] . "</td>";
                echo "</tr>";
            }

            echo "</tbody></table>";

            mysqli_close($conexion);
        ?>
        <p><a href="registro.php" class="btn btn-primary">Regresar al registro</a></p>
    </div>    
</body>
</html>