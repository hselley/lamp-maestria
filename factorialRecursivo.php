<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factorial Recursivo</title>
</head>
<body>
    <h1>Factorial Recursivo</h1>
    <p>Ingrese un número positivo</p>
    <form action="" method="get">
        <label for="numero">Ingrese un numero:</label>
        <input type="number" name="numero" id="numero" min="0" step="1" required>
        <input type="submit" value="Calcular">
    </form>

    <?php
        if($_SERVER["REQUEST_METHOD"] == "GET") {
            $n = intval($_GET["numero"]);
            echo "<p>" . factorial($n) . "</p>";
        }

        function factorial($n) {
            if($n == 0 || $n == 1) {
                return(1);
            } else {
                return($n * factorial($n-1));
            }
        }
    ?>
</body>
</html>