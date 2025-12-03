<?php
/* Base de datos

CREATE TABLE imagenes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    tipo VARCHAR(100),
    tamaño INT,
    imagen LONGBLOB,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

*/

// Configuración de la base de datos
$host = 'db';
$dbname = 'usuario';
$username = 'usuario';
$password = '123456';

// Conexión a la base de datos
$conexion = new mysqli($host, $username, $password, $dbname);

// Verificar conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Función para insertar imagen
function insertarImagen($conexion, $rutaImagen, $nombreImagen) {
    // Verificar que el archivo exista
    if (!file_exists($rutaImagen)) {
        throw new Exception("La imagen no existe: $rutaImagen");
    }
    
    // Leer el archivo binario
    $imagenDatos = file_get_contents($rutaImagen);
    
    // Obtener información del archivo
    $info = getimagesize($rutaImagen);
    $tipo = $info['mime'];
    $tamaño = filesize($rutaImagen);
    
    // Preparar la consulta
    $sql = "INSERT INTO imagenes (nombre, tipo, tamaño, imagen) VALUES (?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    
    if (!$stmt) {
        throw new Exception("Error en la preparación: " . $conexion->error);
    }
    
    // Vincular parámetros
    $stmt->bind_param("ssis", $nombreImagen, $tipo, $tamaño, $imagenDatos);
    
    // Ejecutar la consulta
    if ($stmt->execute()) {
        $id = $conexion->insert_id;
        $stmt->close();
        return $id;
    } else {
        throw new Exception("Error al insertar la imagen: " . $stmt->error);
    }
}

// Procesar formulario
$mensaje = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['imagen'])) {
    $imagen = $_FILES['imagen'];
    
    if ($imagen['error'] == 0) {
        // Validar tipo de archivo
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($imagen['type'], $allowedTypes)) {
            try {
                $idImagen = insertarImagen($conexion, $imagen['tmp_name'], $imagen['name']);
                $mensaje = "Imagen insertada correctamente con ID: $idImagen";
            } catch (Exception $e) {
                $mensaje = "Error: " . $e->getMessage();
            }
        } else {
            $mensaje = "Tipo de archivo no permitido. Solo se permiten JPG, PNG y GIF.";
        }
    } else {
        $mensaje = "Error al subir el archivo: " . $imagen['error'];
    }
}

// Cerrar conexión
$conexion->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Subir Imagen a Base de Datos (MySQLi)</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .form-container { max-width: 500px; margin: 20px 0; }
        .message { padding: 10px; margin: 10px 0; border-radius: 5px; }
        .success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        input[type="file"] { margin: 10px 0; }
        input[type="submit"] { background-color: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; }
        input[type="submit"]:hover { background-color: #0056b3; }
    </style>
</head>
<body>
    <h2>Subir Imagen a Base de Datos</h2>
    
    <?php if ($mensaje): ?>
        <div class="message <?php echo strpos($mensaje, 'Error') === 0 ? 'error' : 'success'; ?>">
            <?php echo htmlspecialchars($mensaje); ?>
        </div>
    <?php endif; ?>
    
    <div class="form-container">
        <form method="post" enctype="multipart/form-data">
            <label for="imagen">Seleccionar imagen:</label><br>
            <input type="file" name="imagen" id="imagen" accept="image/*" required><br>
            <input type="submit" value="Subir Imagen">
        </form>
    </div>
    
    <h3>Imágenes almacenadas:</h3>
    <?php
    // Conexión para mostrar imágenes
    $conexion = new mysqli($host, $username, $password, $dbname);
    
    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }
    
    $sql = "SELECT id, nombre, tipo, tamaño, fecha_creacion FROM imagenes ORDER BY id DESC";
    $resultado = $conexion->query($sql);
    
    if ($resultado->num_rows > 0) {
        echo "<div style='display: flex; flex-wrap: wrap; gap: 10px;'>";
        while ($img = $resultado->fetch_assoc()) {
            echo "<div style='border: 1px solid #ccc; padding: 10px; border-radius: 5px;'>";
            echo "<p><strong>Nombre:</strong> " . htmlspecialchars($img['nombre']) . "</p>";
            echo "<p><strong>Tamaño:</strong> " . $img['tamaño'] . " bytes</p>";
            echo "<p><strong>Fecha:</strong> " . $img['fecha_creacion'] . "</p>";
            echo "<img src='mostrar_imagen_mysqli.php?id=" . $img['id'] . "' width='150' alt='Imagen'>";
            echo "</div>";
        }
        echo "</div>";
    } else {
        echo "<p>No hay imágenes almacenadas.</p>";
    }
    
    $conexion->close();
    ?>
</body>
</html>