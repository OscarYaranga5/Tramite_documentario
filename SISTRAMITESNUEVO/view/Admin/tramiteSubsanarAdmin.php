<?php
    session_start();
    if (!isset($_SESSION['email'])) {
        header('Location: ../login.php');
        exit();
    }
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trámites a Subsanar</title>
    <link rel="stylesheet" href="../../Css/tramiteNuevo.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Añadir estilo para el input de búsqueda */
        #buscar {
            padding: 10px;
            margin: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: calc(100% - 40px);
            box-sizing: border-box;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <img src="../../logo.png" alt="">
        </div>
        <div class="itemsNav">
        <a href="../Admin/tramiteNuevosAdmin.php"><i class="fas fa-file-alt"></i> Trámites Nuevos</a>
        <a href="../Admin/tramiteSubsanarAdmin.php"><i class="fas fa-edit"></i> Trámites a Subsanar</a>
        <a href="../Admin/tramiteAceptadosAdmin.php"><i class="fas fa-check-circle"></i> Trámites Aceptados</a>
        <a href="../Admin/tramiteRechazadosAdmin.php"><i class="fas fa-times-circle"></i> Trámites Rechazados</a>
        </div>
        <div class="itemsPerfil">
            <a href="../../php/logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>
        </div>        
    </header>
    <main>
        <div class="encabezado">
            <h1>Trámites a Subsanar</h1>
        </div>
        <div class="dato">
            <input type="text" id="buscar" placeholder="Buscar en la tabla...">
            <div class="contenedorTable">
                <table>
                    <thead>
                        <tr>
                            <th>Código de Trámite</th>
                            <th>Remitente</th>
                            <th>Correo Electrónico</th>
                            <th>Documento de Identidad</th>
                            <th>Teléfono o Cel.</th>
                            <th>Fecha de Envío</th>
                            <th>Fecha de Recepción</th>
                            <th>Archivo</th>
                        </tr>
                    </thead>
                    <tbody id="tablaTramites">
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
                            die("Error en la conexión: " . $conn->connect_error);
                        }

                        // Preparar y ejecutar la consulta SQL para trámites a subsanar
                        $sql = "SELECT * FROM tramites WHERE Estado = 'Subsanar'";
                        $result = $conn->query($sql);

                        // Verificar si hay resultados
                        if ($result->num_rows > 0) {
                            // Mostrar datos en la tabla
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['codigo_tramite']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['Remitente']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['documento_identidad']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['telefono']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['fecha_envio']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['fecha_recepcion']) . "</td>";
                                echo "<td><a href='../../pdf/" . htmlspecialchars($row['archivo']) . "' download><i class='fas fa-file-pdf'></i>Descargar</a></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8'>No se encontraron trámites a subsanar.</td></tr>";
                        }

                        // Cerrar la conexión
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <script>
        document.getElementById('buscar').addEventListener('input', function() {
            let searchValue = this.value.toLowerCase();
            let rows = document.querySelectorAll('#tablaTramites tr');
            
            rows.forEach(row => {
                let cells = row.querySelectorAll('td');
                let match = Array.from(cells).some(cell => 
                    cell.textContent.toLowerCase().includes(searchValue)
                );
                row.style.display = match ? '' : 'none';
            });
        });
        document.querySelector('.itemsPerfil a[href="../../php/logout.php"]').addEventListener('click', function(e) {
        e.preventDefault(); // Previene el comportamiento predeterminado del enlace
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Vas a cerrar sesión.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, cerrar sesión',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '../../php/logout.php'; // Redirige a logout.php
            }
        });
    });
    </script>
</body>
</html>
