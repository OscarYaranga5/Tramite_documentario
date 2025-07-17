<?php
$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_tramite'])) {
    include 'conexion.php';

    $codigo_tramite = date('YmdHis');

    $remitente = $_POST['nombre'];
    $email = $_POST['correo'];
    $documento_identidad = $_POST['cedula'];
    $telefono = $_POST['telefono'];
    $fecha_envio = date('Y-m-d H:i:s');
    $fecha_recepcion = "Sin recepcionar";
    $estado = "Enviado";
    $mensaje = "Trámite enviado";

    if (
        isset($_FILES['archivo']) && $_FILES['archivo']['error'] == 0 &&
        isset($_FILES['comprobante']) && $_FILES['comprobante']['error'] == 0
    ) {
        // Archivos
        $archivo_tmp = $_FILES['archivo']['tmp_name'];
        $archivo_extension = pathinfo($_FILES['archivo']['name'], PATHINFO_EXTENSION);
        $archivo_nombre = $codigo_tramite . '.' . $archivo_extension;
        $archivo_destino = __DIR__ . '/../pdf/' . $archivo_nombre;

        $comprobante_tmp = $_FILES['comprobante']['tmp_name'];
        $comprobante_extension = pathinfo($_FILES['comprobante']['name'], PATHINFO_EXTENSION);
        $comprobante_nombre = 'comprobante_' . $codigo_tramite . '.' . $comprobante_extension;
        $comprobante_destino = __DIR__ . '/../comprobantes/' . $comprobante_nombre;

        if (
            move_uploaded_file($archivo_tmp, $archivo_destino) &&
            move_uploaded_file($comprobante_tmp, $comprobante_destino)
        ) {
            $sql = "INSERT INTO tramites (codigo_tramite, Remitente, email, documento_identidad, telefono, fecha_envio, fecha_recepcion, archivo, Estado, mensaje, comprobante)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                $archivo_ruta = '../pdf/' . $archivo_nombre;
                $comprobante_ruta = '../comprobantes/' . $comprobante_nombre;

                $stmt->bind_param("sssssssssss", $codigo_tramite, $remitente, $email, $documento_identidad, $telefono, $fecha_envio, $fecha_recepcion, $archivo_ruta, $estado, $mensaje, $comprobante_ruta);

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
            $message = "Error al subir archivos.";
        }
    } else {
        $message = "Debe subir ambos archivos (trámite y comprobante Yape).";
    }

    if ($conn && !$conn->connect_error) {
        $conn->close();
    }
}
?>






