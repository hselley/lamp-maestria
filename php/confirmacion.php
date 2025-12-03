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
    <title>Confirmación</title>

    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> 
</head>
<body>
    <div class="container">
        <?php
            // escape variables for security
            $name = mysqli_real_escape_string($conexion, $_POST['nombre']);
            $mail = mysqli_real_escape_string($conexion, $_POST['email']);
            $age = mysqli_real_escape_string($conexion, $_POST['age']);

            $sql="INSERT INTO usuarios (nombre, correo, edad) VALUES ('$name', '$mail', '$age');";
            if (!mysqli_query($conexion, $sql)) {
                die('Error: ' . mysqli_error($conexion));
            }

            mysqli_close($conexion);
        ?>
        <h2 class="mt-5">Registro exitoso</h2>
        <p><a href="registro.php" class="btn btn-primary">Regresar</a></p>
    </div>
</body>
</html>