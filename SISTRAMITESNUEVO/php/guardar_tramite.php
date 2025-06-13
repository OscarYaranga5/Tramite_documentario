<?php

$success = false; // Variable para el estado de la operación

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_tramite'])) {
    include 'conexion.php'; // Incluir archivo de conexión

    // Generar el código del trámite basado en la fecha y hora actual en formato de 24 horas sin guiones
    $codigo_tramite = date('YmdHis'); // Formato: YYYYMMDDHHMMSS

    $remitente = $_POST['nombre'];
    $email = $_POST['correo'];
    $documento_identidad = $_POST['cedula'];
    $telefono = $_POST['telefono'];
    $fecha_envio = date('Y-m-d H:i:s'); // Fecha y hora actual para fecha_envio
    $fecha_recepcion = "Sin recepcionar"; // Estado inicial para fecha_recepcion
    $estado = "Enviado"; // Estado del trámite
    $mensaje = "Trámite enviado"; // Mensaje del trámite

    // Manejar la carga del archivo
    if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] == 0) {
        $archivo_tmp = $_FILES['archivo']['tmp_name'];
        $archivo_extension = pathinfo($_FILES['archivo']['name'], PATHINFO_EXTENSION); // Obtener la extensión del archivo
        $archivo_nombre = $codigo_tramite . '.' . $archivo_extension; // Nombre del archivo guardado
        $archivo_destino = __DIR__ . '/../pdf/' . $archivo_nombre; // Cambiar ruta para la carpeta pdf y renombrar el archivo

        // Mover el archivo a la carpeta de destino
        if (move_uploaded_file($archivo_tmp, $archivo_destino)) {
            // Preparar y ejecutar la consulta SQL
            $sql = "INSERT INTO tramites (codigo_tramite, Remitente, email, documento_identidad, telefono, fecha_envio, fecha_recepcion, archivo, Estado, mensaje) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);

            // Verificar si la conexión está abierta antes de usarla
            if ($stmt) {
                $archivo_ruta = '../pdf/' . $archivo_nombre; // Ruta completa del archivo guardado
                $stmt->bind_param("ssssssssss", $codigo_tramite, $remitente, $email, $documento_identidad, $telefono, $fecha_envio, $fecha_recepcion, $archivo_ruta, $estado, $mensaje);

                if ($stmt->execute()) {
                    $success = true;
                    $message = "Trámite guardado exitosamente con código: $codigo_tramite";
                } else {
                    $message = "Error: " . $stmt->error;
                }

                $stmt->close();
            } else {
                $message = "Error al preparar la consulta: " . $conn->error;
            }
        } else {
            $message = "Error al mover el archivo";
        }
    } else {
        $message = "Error al cargar el archivo";
    }

    // Cerrar la conexión después de su uso
    if ($conn && !$conn->connect_error) {
        $conn->close();
    }
}
?>








