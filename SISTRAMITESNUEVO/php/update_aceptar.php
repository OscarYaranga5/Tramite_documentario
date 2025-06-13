<?php
// Configuración de conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "sistemacolegio";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obtener los datos enviados
$codigo_tramite = $_POST['codigo_tramite'];
$mensaje = $_POST['mensaje'];

// Preparar la consulta SQL
$sql = "UPDATE tramites SET Estado = 'Aceptado', mensaje = ?, fecha_recepcion = NOW() WHERE codigo_tramite = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $mensaje, $codigo_tramite);

// Ejecutar la consulta
if ($stmt->execute()) {
    echo "Trámite aceptado exitosamente.";
} else {
    echo "Error: " . $stmt->error;
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>
