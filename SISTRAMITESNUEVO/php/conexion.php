<?php
// Parámetros de conexión
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "sistemacolegio";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
// echo "Conexión exitosa"; // Comentado para evitar el mensaje en cada inclusión
?>


