<?php
$resultado = [];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['consultar'])) {
    include 'conexion.php'; // Incluir archivo de conexión

    $query = $_POST['query'];

    // Preparar y ejecutar la consulta SQL
    $sql = "SELECT * FROM tramites WHERE documento_identidad = ? OR email = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ss", $query, $query);
        $stmt->execute();
        $result = $stmt->get_result();

        // Obtener los resultados
        while ($row = $result->fetch_assoc()) {
            $resultado[] = $row;
        }

        $stmt->close();
    } else {
        echo "<script>
            Swal.fire({
                title: 'Error',
                text: 'Error al preparar la consulta: " . $conn->error . "',
                icon: 'error'
            });
            </script>";
    }

    // Cerrar la conexión después de su uso
    if ($conn && !$conn->connect_error) {
        $conn->close();
    }
}
?>
