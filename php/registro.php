<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>

    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> 
</head>
<body>
    <div class="container">
        <h1 class="p-5 mt-5 bg-primary text-white">Registro de usuarios</h1>
        <p class="mt-5">Ingrese la información solicitada.</p>
    </div>
    <div class="container">
        <form action="confirmacion.php" method="POST">
            <div class="mb-3 mt-3">
                <label for="nombre" class="form-label">Email:</label>
                <input type="text" class="form-control" id="nombre" placeholder="Ingrese su nombre" name="nombre">
            </div>
            <div class="mb-3 mt-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" placeholder="Ingrese correo email" name="email">
            </div>
            <div class="mb-3 mt-3">
                <label for="age" class="form-label">Email:</label>
                <input type="number" class="form-control" id="age" placeholder="Ingrese su edad" name="age">
            </div>
            <button type="submit" class="btn btn-primary">Registro</button>
        </form>
        <p class="mt-3"><a href="consulta.php" class="btn btn-primary">Usuarios registrados</a></p>
    </div>
</body>
</html>