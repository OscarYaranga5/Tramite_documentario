<?php
// Archivo: php/update_eliminar.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigo_tramite = $_POST['codigo_tramite'];
    $mensaje = $_POST['mensaje'];

    // Configuración de conexión a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "sistemacolegio";

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Actualizar el estado del trámite
    $sql = "UPDATE tramites SET Estado = 'Eliminado', mensaje = ?, fecha_recepcion = NOW() WHERE codigo_tramite = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $mensaje, $codigo_tramite);

    if ($stmt->execute()) {
        echo "El trámite ha sido rechazado.";
    } else {
        echo "Error al actualizar el trámite: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
