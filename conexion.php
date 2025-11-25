<?php
    $con = mysqli_connect('db', 'usuario', '123456', 'autos');

    // Check connection
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
?>