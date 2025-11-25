<?php
    $con = mysqli_connect('db', 'usuario', '123456', 'autos');

    // Check connection
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    // escape variables for security
    $nombre = mysqli_real_escape_string($con, $_POST['fab']);
    $sql = "INSERT INTO fabricante (nombre) VALUES ('$nombre');";

    if (!mysqli_query($con,$sql)) {
      die('Error: ' . mysqli_error($con));
    }
    echo "1 record added";

    mysqli_close($con);
?>