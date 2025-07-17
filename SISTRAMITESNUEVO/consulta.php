<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Consultar Trámites</title>
  <link rel="stylesheet" href="Css/consulta1.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
      height: 60px;
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

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 30px;
      background-color: white;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      border-radius: 10px;
      overflow: hidden;
    }

    th, td {
      padding: 12px 15px;
      text-align: center;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #667eea;
      color: white;
    }

    td button, td a {
      padding: 6px 12px;
      border: none;
      border-radius: 5px;
      text-decoration: none;
      font-weight: bold;
      cursor: pointer;
    }

    td button {
      background-color: #1ab394;
      color: white;
    }

    .modal {
      display: none;
      position: fixed;
      z-index: 1000;
      left: 0; top: 0;
      width: 100%; height: 100%;
      background-color: rgba(0, 0, 0, 0.6);
      justify-content: center;
      align-items: center;
    }

    .modal-content {
      background: white;
      padding: 25px 30px;
      border-radius: 10px;
      width: 90%;
      max-width: 400px;
      text-align: center;
      box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    }

    .modal-content h2 {
      margin-top: 0;
      color: #333;
    }

    .formularioModal {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }

    .formularioModal input[type="file"] {
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .button-container {
      display: flex;
      justify-content: space-between;
      gap: 10px;
    }

    .submit-btn {
      background-color: #1ab394;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      flex: 1;
    }

    .close-btn {
      background-color: #ccc;
      color: black;
      padding: 10px 20px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      flex: 1;
    }
  </style>
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
    <form action="" method="post">
      <label for="query">Ingrese su Documento de Identidad</label>
      <input type="text" id="query" name="query" required>
      <input type="submit" name="consultar" value="Consultar">
    </form>

    <?php
    $resultado = [];

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['consultar'])) {
        $conn = new mysqli("localhost", "root", "root", "sistemacolegio");
        if ($conn->connect_error) {
            echo "<script>Swal.fire('Error', 'Error en la conexión', 'error');</script>";
        } else {
            $query = $_POST['query'];
            $sql = "SELECT * FROM tramites WHERE documento_identidad = ? OR email = ?";
            $stmt = $conn->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("ss", $query, $query);
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $resultado[] = $row;
                }
                $stmt->close();
            }
            $conn->close();
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['codigo_tramite'])) {
        $codigo_tramite = $_POST['codigo_tramite'];
        $target_dir = "pdf/";
        $target_file = $target_dir . $codigo_tramite . ".pdf";
        $uploadOk = 1;
        $fileType = strtolower(pathinfo($_FILES["archivo"]["name"], PATHINFO_EXTENSION));

        if ($fileType != "pdf") {
            echo "<script>Swal.fire('Error', 'Solo se permiten archivos PDF.', 'error');</script>";
            $uploadOk = 0;
        }

        if ($uploadOk && move_uploaded_file($_FILES["archivo"]["tmp_name"], $target_file)) {
            $conn = new mysqli("localhost", "root", "root", "sistemacolegio");
            if (!$conn->connect_error) {
                $fecha_envio = date('Y-m-d H:i:s');
                $sql = "UPDATE tramites SET archivo = ?, Estado = 'Enviado', fecha_envio = ? WHERE codigo_tramite = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sss", $target_file, $fecha_envio, $codigo_tramite);
                if ($stmt->execute()) {
                    echo "<script>Swal.fire('Éxito', 'Documento reenviado con éxito.', 'success');</script>";
                } else {
                    echo "<script>Swal.fire('Error', 'Error al actualizar en la base de datos.', 'error');</script>";
                }
                $stmt->close();
                $conn->close();
            }
        } else {
            echo "<script>Swal.fire('Error', 'No se pudo subir el archivo.', 'error');</script>";
        }
    }

    if (isset($resultado)) {
        echo "<h2>Resultados de la consulta:</h2>";
        if (count($resultado) > 0) {
            echo "<table>
                    <thead>
                      <tr>
                        <th>Código</th>
                        <th>Remitente</th>
                        <th>Email</th>
                        <th>DNI</th>
                        <th>Teléfono</th>
                        <th>Fecha Envío</th>
                        <th>Fecha Recepción</th>
                        <th>Estado</th>
                        <th>Mensaje</th>
                        <th>Pago</th>
                        <th>Archivo</th>
                      </tr>
                    </thead>
                    <tbody>";
            foreach ($resultado as $tramite) {
                echo "<tr>";
                echo "<td>{$tramite['codigo_tramite']}</td>";
                echo "<td>{$tramite['Remitente']}</td>";
                echo "<td>{$tramite['email']}</td>";
                echo "<td>{$tramite['documento_identidad']}</td>";
                echo "<td>{$tramite['telefono']}</td>";
                echo "<td>{$tramite['fecha_envio']}</td>";
                echo "<td>{$tramite['fecha_recepcion']}</td>";
                echo "<td>{$tramite['Estado']}</td>";
                echo "<td>{$tramite['mensaje']}</td>";

                // Pago
                if (!empty($tramite['comprobante'])) {
                    echo "<td><a href='comprobantes/" . basename($tramite['comprobante']) . "' target='_blank'><i class='fas fa-money-check-alt'></i> Ver</a></td>";
                } else {
                    echo "<td><span style='color:red;'>Sin pago</span></td>";
                }

                // Archivo o botón reenviar
                if ($tramite['Estado'] === 'Subsanar') {
                    echo "<td><button onclick=\"subirPDF('{$tramite['codigo_tramite']}')\"><i class='fas fa-file-upload'></i> Reenviar</button></td>";
                } else {
                    $archivo_ruta = str_replace('../', '', $tramite['archivo']);
                    echo "<td><a href='$archivo_ruta' download class='download-link'><i class='fas fa-file-download' style='color: #1ab394; margin-right: 6px;'></i>Descargar</a></td>";
                }

                echo "</tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p>No se encontraron trámites.</p>";
        }
    }
    ?>

    <!-- Modal Subir PDF -->
    <div id="pdfModal" class="modal">
      <div class="modal-content">
        <h2>Subir PDF</h2>
        <form id="uploadForm" action="" method="post" enctype="multipart/form-data" class="formularioModal">
          <input type="hidden" id="codigo_tramite" name="codigo_tramite" />
          <label for="archivo">Seleccione el archivo PDF:</label>
          <input type="file" id="archivo" name="archivo" accept="application/pdf" required />
          <div class="button-container">
            <input type="submit" class="submit-btn" value="Subir" />
            <button type="button" class="close-btn" onclick="cerrarModal()">Cerrar</button>
          </div>
        </form>
      </div>
    </div>

    <script>
      function subirPDF(codigoTramite) {
        document.getElementById('codigo_tramite').value = codigoTramite;
        document.getElementById('pdfModal').style.display = 'flex';
      }

      function cerrarModal() {
        document.getElementById('pdfModal').style.display = 'none';
      }
    </script>
  </main>
</body>
</html>
