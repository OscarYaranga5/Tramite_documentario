<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica si el archivo y el código del trámite están presentes
    if (isset($_FILES['archivo_pdf']) && isset($_POST['codigo_tramite'])) {
        $codigoTramite = $_POST['codigo_tramite'];
        $archivo = $_FILES['archivo_pdf'];

        $target_dir = "../pdf/";
        $target_file = $target_dir . basename($archivo["name"]);
        $uploadOk = 1;
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Verificar si es un archivo PDF
        if ($fileType != "pdf") {
            echo "<script>
                Swal.fire({
                    title: 'Error',
                    text: 'Solo se permiten archivos PDF.',
                    icon: 'error'
                });
                </script>";
            $uploadOk = 0;
        }

        // Verificar si el archivo ya existe
        if (file_exists($target_file)) {
            echo "<script>
                Swal.fire({
                    title: 'Error',
                    text: 'El archivo ya existe.',
                    icon: 'error'
                });
                </script>";
            $uploadOk = 0;
        }

        // Verificar el tamaño del archivo
        if ($archivo["size"] > 5000000) {
            echo "<script>
                Swal.fire({
                    title: 'Error',
                    text: 'El archivo es demasiado grande.',
                    icon: 'error'
                });
                </script>";
            $uploadOk = 0;
        }

        // Subir el archivo
        if ($uploadOk == 1) {
            if (move_uploaded_file($archivo["tmp_name"], $target_file)) {
                // Actualizar la base de datos con la ruta del archivo
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "sistemacolegio";

                $conn = new mysqli($servername, $username, $password, $dbname);

                if ($conn->connect_error) {
                    echo "<script>
                        Swal.fire({
                            title: 'Error',
                            text: 'Error en la conexión: " . $conn->connect_error . "',
                            icon: 'error'
                        });
                        </script>";
                } else {
                    $sql = "UPDATE tramites SET archivo = ?, Estado = 'Subsanado' WHERE codigo_tramite = ?";
                    $stmt = $conn->prepare($sql);

                    if ($stmt) {
                        $stmt->bind_param("ss", $target_file, $codigoTramite);
                        if ($stmt->execute()) {
                            echo "<script>
                                Swal.fire({
                                    title: 'Éxito',
                                    text: 'El archivo se ha subido correctamente.',
                                    icon: 'success'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = '../consultar_tramites.php';
                                    }
                                });
                                </script>";
                        } else {
                            echo "<script>
                                Swal.fire({
                                    title: 'Error',
                                    text: 'Error al actualizar la base de datos: " . $stmt->error . "',
                                    icon: 'error'
                                });
                                </script>";
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

                    if ($conn && !$conn->connect_error) {
                        $conn->close();
                    }
                }
            } else {
                echo "<script>
                    Swal.fire({
                        title: 'Error',
                        text: 'Hubo un error al subir el archivo.',
                        icon: 'error'
                    });
                    </script>";
            }
        }
    } else {
        echo "<script>
            Swal.fire({
                title: 'Error',
                text: 'Datos incompletos.',
                icon: 'error'
            });
            </script>";
    }
}
?>

