<!DOCTYPE html>
<html lang="en">
<?php
    include "conexion.php";
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fabricante</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <h1>Fabricantes de autos registrados</h1>
    <?php
        $result = mysqli_query($con, "SELECT * FROM fabricante;");
    ?>

    <table>
        <thead>
            <th>id</th>
            <th>Nombre del fabricante</th>
        </thead>
        <tbody>
        <?php
            while($row = mysqli_fetch_array($result)) {
                echo '<tr><td>' . $row['id'] . '</td><td>' . $row['nombre'] . '</td></tr>';
            } 
            
            mysqli_close($con);
        ?>
        </tbody>
    </table>


</body>
</html>