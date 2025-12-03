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

// Conexión a la base de datos usando MySQLi
$conexion = new mysqli($host, $username, $password, $dbname);

// Verificar conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Función para mostrar imagen desde la base de datos
function mostrarImagen($conexion, $idImagen) {
    $sql = "SELECT nombre, tipo, imagen FROM imagenes WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $idImagen);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    if ($resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        header("Content-Type: " . $fila['tipo']);
        echo $fila['imagen'];
    } else {
        // Mostrar imagen por defecto si no se encuentra
        header("Content-Type: image/png");
        echo base64_decode("iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8/5+hHgAHggJ/PchI7wAAAABJRU5ErkJggg==");
    }
    $stmt->close();
}

// Función para obtener todas las imágenes
function obtenerImagenes($conexion) {
    $sql = "SELECT id, nombre, tipo, tamaño, fecha_creacion FROM imagenes ORDER BY id DESC";
    $resultado = $conexion->query($sql);
    
    $imagenes = [];
    if ($resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
            $imagenes[] = $fila;
        }
    }
    return $imagenes;
}

// Si se solicita una imagen específica por ID
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    mostrarImagen($conexion, $_GET['id']);
    exit;
}

// Obtener todas las imágenes para mostrar en la página
$imagenes = obtenerImagenes($conexion);
$conexion->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Galería de Imágenes</title>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .image-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        .image-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        .image-container {
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f9f9f9;
        }
        .image-container img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
        .image-info {
            padding: 15px;
            background-color: #fafafa;
        }
        .image-info h3 {
            margin: 0 0 10px 0;
            font-size: 14px;
            color: #555;
        }
        .image-info p {
            margin: 5px 0;
            font-size: 12px;
            color: #777;
        }
        .no-images {
            text-align: center;
            padding: 50px;
            color: #777;
            font-style: italic;
        }
        .image-link {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
            font-size: 12px;
        }
        .image-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Galería de Imágenes</h1>
        
        <?php if (empty($imagenes)): ?>
            <div class="no-images">
                <p>No hay imágenes almacenadas en la base de datos.</p>
                <p>Por favor, sube algunas imágenes primero.</p>
            </div>
        <?php else: ?>
            <div class="gallery">
                <?php foreach ($imagenes as $imagen): ?>
                    <div class="image-card">
                        <div class="image-container">
                            <a href="javascript:void(0)" onclick="window.open('<?= $_SERVER['PHP_SELF'] ?>?id=<?= $imagen['id'] ?>', '_blank')">
                                <img src="<?= $_SERVER['PHP_SELF'] ?>?id=<?= $imagen['id'] ?>" alt="<?= htmlspecialchars($imagen['nombre']) ?>" onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgZmlsbD0iI2RkZCIvPjx0ZXh0IHg9IjUwIiB5PSI1MCIgZm9udC1zaXplPSIxNCIgZmlsbD0iI2ZmZiIgdGV4dC1hbmNob3I9Im1pZGRsZSI+SW1hZ2VuIG5vIGZvdW5kPC90ZXh0Pjwvc3ZnPg=='">
                            </a>
                        </div>
                        <div class="image-info">
                            <h3><?= htmlspecialchars($imagen['nombre']) ?></h3>
                            <p>Tamaño: <?= $imagen['tamaño'] ?> bytes</p>
                            <p>Fecha: <?= $imagen['fecha_creacion'] ?></p>
                            <a href="<?= $_SERVER['PHP_SELF'] ?>?id=<?= $imagen['id'] ?>" class="image-link" target="_blank">Ver imagen completa</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>