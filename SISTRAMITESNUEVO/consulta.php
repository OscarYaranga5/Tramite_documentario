<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Trámites</title>
    <link rel="stylesheet" href="Css/consulta1.css">
    <style>
        * {
  box-sizing: border-box;
  font-family: 'Inter', sans-serif;
}

body {
  margin: 0;
  background: linear-gradient(to right, #f7f7f7, #e0e0e0);
  color: #333;
}

header {
  background: linear-gradient(90deg, #667eea, #764ba2);
  color: white;
  padding: 20px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
}

.logo {
  display: flex;
  align-items: center;
  gap: 15px;
}

.logo img {
  height: 40px;
}

.logo h1 {
  margin: 0;
  font-size: 20px;
}

.nav {
  display: flex;
  gap: 15px;
  flex-wrap: wrap;
}

.nav a {
  text-decoration: none;
  color: white;
  font-weight: bold;
  background-color: rgba(255, 255, 255, 0.15);
  padding: 10px 15px;
  border-radius: 8px;
  transition: background 0.3s;
}

.nav a:hover {
  background-color: rgba(255, 255, 255, 0.35);
}

main {
  max-width: 1000px;
  margin: 40px auto;
  padding: 20px;
}

form {
  background: white;
  padding: 25px;
  border-radius: 12px;
  box-shadow: 0 8px 20px
}
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="logo.png" alt="">
            <h1>Mesa de Partes Virtual</h1>
        </div>
        <div class="nav">
            <a href="index.php">Nuevo Trámite</a>
        </div>
    </header>
    <main>
        <form action="" method="post" >
            <label for="query">Ingrese su Documento de Identidad o Correo Electrónico:</label>
            <input type="text" id="query" name="query" required>
            <input type="submit" name="consultar" value="Consultar">
        </form>

        <?php
        $resultado = [];

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['consultar'])) {
            // Configuración de conexión a la base de datos
            $servername = "localhost";
            $username = "root";
            $password = "root";
            $dbname = "sistemacolegio";

            // Crear conexión
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Verificar conexión
            if ($conn->connect_error) {
                echo "<script>
                    Swal.fire({
                        title: 'Error',
                        text: 'Error en la conexión: " . $conn->connect_error . "',
                        icon: 'error'
                    });
                    </script>";
            } else {
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
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['codigo_tramite'])) {
            // Código para manejar la subida del archivo PDF
            $codigo_tramite = $_POST['codigo_tramite'];
            $target_dir = "pdf/"; // Cambia aquí a la carpeta correcta
            $target_file = $target_dir . $codigo_tramite . ".pdf";
            $uploadOk = 1;
            $fileType = strtolower(pathinfo($_FILES["archivo"]["name"], PATHINFO_EXTENSION));

            // Check if file is a PDF
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

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "<script>
                    Swal.fire({
                        title: 'Error',
                        text: 'El archivo no se subió.',
                        icon: 'error'
                    });
                    </script>";
            // If everything is ok, try to upload file
            } else {
                if (!is_dir($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }

                if (move_uploaded_file($_FILES["archivo"]["tmp_name"], $target_file)) {
                    // Aquí puedes agregar el código para guardar la ruta del archivo en la base de datos
                    // Configuración de conexión a la base de datos
                    $servername = "localhost";
                    $username = "root";
                    $password = "root";
                    $dbname = "sistemacolegio";

                    // Crear conexión
                    $conn = new mysqli($servername, $username, $password, $dbname);

                    // Verificar conexión
                    if ($conn->connect_error) {
                        echo "<script>
                            Swal.fire({
                                title: 'Error',
                                text: 'Error en la conexión: " . $conn->connect_error . "',
                                icon: 'error'
                            });
                            </script>";
                    } else {
                        $fecha_envio = date('Y-m-d H:i:s'); // Obtener la fecha y hora actuales
                        $sql = "UPDATE tramites SET archivo = ?, Estado = 'Enviado', fecha_envio = ? WHERE codigo_tramite = ?";
                        $stmt = $conn->prepare($sql);

                        if ($stmt) {
                            $stmt->bind_param("sss", $target_file, $fecha_envio, $codigo_tramite);
                            if ($stmt->execute()) {
                                echo "<script>
                                    Swal.fire({
                                        title: 'Éxito',
                                        text: 'El archivo " . basename($_FILES["archivo"]["name"]) . " Documento Reenviado con Exito',
                                        icon: 'success'
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

                        // Cerrar la conexión después de su uso
                        if ($conn && !$conn->connect_error) {
                            $conn->close();
                        }
                    }
                } else {
                    echo "<script>
                        Swal.fire({
                            title: 'Error',
                            text: 'Hubo un error subiendo el archivo.',
                            icon: 'error'
                        });
                        </script>";
                }
            }
        }

        if (isset($resultado)) {
            echo "<h2>Resultados de la consulta:</h2>";
            if (count($resultado) > 0) {
                echo "<table border='1'>
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Remitente</th>
                                <th>Email</th>
                                <th>Documento Identidad</th>
                                <th>Teléfono</th>
                                <th>Fecha Envío</th>
                                <th>Fecha Recepción</th>
                                <th>Estado</th>
                                <th>Mensaje</th>
                                <th>Archivo</th>
                            </tr>
                        </thead>
                        <tbody>";
                foreach ($resultado as $tramite) {
                    echo "<tr>";
                    echo "<td>" . $tramite['codigo_tramite'] . "</td>";
                    echo "<td>" . $tramite['Remitente'] . "</td>";
                    echo "<td>" . $tramite['email'] . "</td>";
                    echo "<td>" . $tramite['documento_identidad'] . "</td>";
                    echo "<td>" . $tramite['telefono'] . "</td>";
                    echo "<td>" . $tramite['fecha_envio'] . "</td>";
                    echo "<td>" . $tramite['fecha_recepcion'] . "</td>";
                    echo "<td>" . $tramite['Estado'] . "</td>";
                    echo "<td>" . $tramite['mensaje'] . "</td>";

                    // Mostrar botón de subir PDF si el estado es "Subsanar"
                    if ($tramite['Estado'] === 'Subsanar') {
                        echo "<td><button onclick=\"subirPDF('{$tramite['codigo_tramite']}')\"><i class='fas fa-file-pdf'></i>Reenviar</button></td>";
                    } else {
                        // Asegúrate de que la ruta del archivo comience desde la raíz del servidor web
                        $archivo_ruta = str_replace('../', '', $tramite['archivo']);
echo "<td><a href='$archivo_ruta' download class='download-link' style='display: inline-flex; align-items: center; text-decoration: none; font-weight: bold; color: #2f4050;'>
<i class='fas fa-file-download' style='color: #1ab394; margin-right: 6px;'></i>Descargar</a></td>";

                    }

                    echo "</tr>";
                }
                echo "</tbody>
                    </table>";
            } else {
                echo "<p>No se encontraron trámites.</p>";
            }
        }
        ?>

        <!-- Modal -->
        <div id="pdfModal" class="modal">
            <div class="modal-content">
                <h2>Subir PDF</h2>
                <form id="uploadForm" action="" method="post" enctype="multipart/form-data" class="formularioModal">
                    <input type="hidden" id="codigo_tramite" name="codigo_tramite">
                    <label for="archivo">Seleccione el archivo PDF:</label>
                    <input type="file" id="archivo" name="archivo" accept="application/pdf" required>
                    <div class="button-container">
                        <input type="submit" class="submit-btn" value="Subir">
                        <button type="button" class="close-btn" onclick="cerrarModal()">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            function subirPDF(codigoTramite) {
                document.getElementById('codigo_tramite').value = codigoTramite;
                document.getElementById('pdfModal').style.display = 'block';
            }

            function cerrarModal() {
                document.getElementById('pdfModal').style.display = 'none';
            }
        </script>
    </main>
</body>
</html>

