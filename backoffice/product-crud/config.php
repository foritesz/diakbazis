<?php
$conn = mysqli_connect('localhost', 'root', '12345678', 'products');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

mysqli_select_db($conn, 'products'); // Választjuk ki az adatbázist


?>