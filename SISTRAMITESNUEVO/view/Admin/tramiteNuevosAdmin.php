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
        <title>Consultar Trámites</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <style>
         
        </style>
    </head>
    <style>
body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background-color: #f4f6f9;
    color: #2f4050;
}

header {
    background-color: #2f4050;
    color: white;
    padding: 10px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

header .logo img {
    height: 50px;
}

.itemsNav a, .itemsPerfil a {
    color: white;
    text-decoration: none;
    margin-left: 15px;
    font-weight: bold;
}

.itemsNav a:hover, .itemsPerfil a:hover {
    text-decoration: underline;
}

main {
    padding: 30px;
}

.dato .botones {
    margin-bottom: 15px;
}

#buscar {
    padding: 10px;
    width: 300px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 16px;
}

table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border-radius: 10px;
    overflow: hidden;
}

th, td {
    padding: 12px 15px;
    text-align: center;
    border-bottom: 1px solid #eee;
}

th {
    background-color: #2f4050;
    color: white;
}

td a {
    color: #1ab394;
    text-decoration: none;
    font-weight: bold;
}

.open-modal {
    background-color: #1ab394;
    color: white;
    border: none;
    padding: 7px 10px;
    margin: 2px;
    border-radius: 5px;
    cursor: pointer;
}

.open-modal:hover {
    background-color: #17a589;
}

/* MODAL STYLING */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0; top: 0;
    width: 100%; height: 100%;
    background-color: rgba(0,0,0,0.5);
    justify-content: center;
    align-items: center;
}

.modal-content {
    background-color: white;
    padding: 30px;
    border-radius: 10px;
    width: 400px;
    max-width: 90%;
    position: relative;
    box-shadow: 0 2px 10px rgba(0,0,0,0.3);
}

.modal-content h2 {
    margin-top: 0;
}

.modal-content textarea {
    width: 100%;
    height: 100px;
    margin-top: 10px;
    padding: 10px;
    font-family: 'Segoe UI';
    border: 1px solid #ccc;
    border-radius: 5px;
}

.modal-content button {
    background-color: #1ab394;
    color: white;
    border: none;
    padding: 10px 20px;
    margin-top: 15px;
    border-radius: 5px;
    cursor: pointer;
}

.modal-content .close {
    position: absolute;
    top: 10px;
    right: 15px;
    font-size: 20px;
    cursor: pointer;
}
    </style>
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
            <div class="encabezado"></div>
            <div class="dato">
                <div class="botones">
                    <input type="text" name="" id="buscar" placeholder="Buscar...">
                </div>
                <div class="contenedorTable">
                    <table id="tablaTramites">
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
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $resultado = [];

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
                                // Preparar y ejecutar la consulta SQL
                                $sql = "SELECT * FROM tramites WHERE Estado = 'Enviado'";
                                $result = $conn->query($sql);

                                // Obtener los resultados
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $resultado[] = $row;
                                    }
                                } else {
                                    echo "<tr><td colspan='9'>No se encontraron trámites nuevo.</td></tr>";
                                }

                                // Cerrar la conexión después de su uso
                                $conn->close();
                            }
                            $base_url = 'http://localhost/SISTRAMITESNUEVO/pdf/'; // Ajusta esto según tu entorno

                            if (isset($resultado)) {
                                foreach ($resultado as $tramite) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($tramite['codigo_tramite']) . "</td>";
                                    echo "<td>" . htmlspecialchars($tramite['Remitente']) . "</td>";
                                    echo "<td>" . htmlspecialchars($tramite['email']) . "</td>";
                                    echo "<td>" . htmlspecialchars($tramite['documento_identidad']) . "</td>";
                                    echo "<td>" . htmlspecialchars($tramite['telefono']) . "</td>";
                                    echo "<td>" . htmlspecialchars($tramite['fecha_envio']) . "</td>";
                                    echo "<td>" . htmlspecialchars($tramite['fecha_recepcion']) . "</td>";
                                    
                                    // Usa la ruta base para los archivos
                                    $archivo_relativo = $tramite['archivo'];
                                    $archivo_ruta = $base_url . basename($archivo_relativo);

                                    // Para depuración: Muestra la ruta completa del archivo
                                    echo "<td><a href='$archivo_ruta' download><i class='fas fa-file-pdf'></i>Desc.</a></td>";

                                    echo "<td>
                                            <button id='open-modal1' class='open-modal' data-modal='modalAceptar' data-codigo='" . htmlspecialchars($tramite['codigo_tramite']) . "'>Aceptar</button>
                                            <button id='open-modal2' class='open-modal' data-modal='modalSubsanar' data-codigo='" . htmlspecialchars($tramite['codigo_tramite']) . "'>Subsanar</button>
                                            <button id='open-modal3' class='open-modal' data-modal='modalEliminar' data-codigo='" . htmlspecialchars($tramite['codigo_tramite']) . "'>Eliminar</button>
                                        </td>";
                                    echo "</tr>";
                                }
                            }
                            
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>

        <!-- Modal Aceptar -->
        <div id="modalAceptar" class="modal">
            <div class="modal-content">
                <span class="close" data-modal="modalAceptar">&times;</span>
                <h2>Aceptar Trámite</h2>
                <p>Código de Trámite: <span id="codigoAceptar"></span></p>
                <textarea id="mensajeAceptar" placeholder="Escribe un mensaje"></textarea>
                <button id="btnAceptar">Aceptar</button>
            </div>
        </div>

        <!-- Modal Subsanar -->
        <div id="modalSubsanar" class="modal">
            <div class="modal-content">
                <span class="close" data-modal="modalSubsanar">&times;</span>
                <h2>Subsanar Trámite</h2>
                <p>Código de Trámite: <span id="codigoSubsanar"></span></p>
                <textarea id="mensajeSubsanar" placeholder="Escribe un mensaje"></textarea>
                <button id="btnSubsanar">Subsanar</button>
            </div>
        </div>

        <!-- Modal Eliminar -->
        <div id="modalEliminar" class="modal">
            <div class="modal-content">
                <span class="close" data-modal="modalEliminar">&times;</span>
                <h2>Eliminar Trámite</h2>
                <p>Código de Trámite: <span id="codigoEliminar"></span></p>
                <textarea id="mensajeEliminar" placeholder="Escribe un mensaje"></textarea>
                <button id="btnEliminar">Eliminar</button>
            </div>
        </div>

        <script>
            const baseURL = '../../php/';
            function openModal(modalId, codigo) {
            document.getElementById(modalId).style.display = 'block';
            document.getElementById(`codigo${modalId.charAt(5).toUpperCase() + modalId.slice(6)}`).innerText = codigo;
        }


            function closeModal(modalId) {
                document.getElementById(modalId).style.display = 'none';
            }

            // Manejar clic en el botón de cerrar del modal
            document.querySelectorAll('.close').forEach(span => {
                span.addEventListener('click', function() {
                    var modalId = this.getAttribute('data-modal');
                    closeModal(modalId);
                });
            });

            // Manejar clic en los botones de acción
            document.querySelectorAll('.open-modal').forEach(button => {
                button.addEventListener('click', function() {
                    var modalId = this.getAttribute('data-modal');
                    var codigo = this.getAttribute('data-codigo');
                    openModal(modalId, codigo);
                });
            });

            // Manejar el envío del formulario para Aceptar
            document.getElementById('btnAceptar').addEventListener('click', function() {
                var codigo = document.getElementById('codigoAceptar').innerText;
                var mensajeAceptar = document.getElementById('mensajeAceptar').value;
                fetch(baseURL + 'update_aceptar.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        'codigo_tramite': codigo,
                        'mensaje': mensajeAceptar
                    })
                }).then(response => {
                    if (!response.ok) {
                        return response.text().then(text => {
                            throw new Error('Error: ' + response.status + ' ' + response.statusText + ' - ' + text);
                        });
                    }
                    return response.text();
                }).then(data => {
                    Swal.fire({
                        title: 'Éxito',
                        text: data,
                        icon: 'success'
                    });
                    closeModal('modalAceptar');
                }).catch(error => {
                    Swal.fire({
                        title: 'Error',
                        text: error.message,
                        icon: 'error'
                    });
                });
            });

            // Manejar el envío del formulario para Aceptar
    document.getElementById('btnAceptar').addEventListener('click', function() {
        var codigo = document.getElementById('codigoAceptar').innerText;
        var mensajeAceptar = document.getElementById('mensajeAceptar').value;
        fetch(baseURL + 'update_aceptar.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                'codigo_tramite': codigo,
                'mensaje': mensajeAceptar
            })
        }).then(response => {
            if (!response.ok) {
                return response.text().then(text => {
                    throw new Error('Error: ' + response.status + ' ' + response.statusText + ' - ' + text);
                });
            }
            return response.text();
        }).then(data => {
            Swal.fire({
                title: 'Éxito',
                text: data,
                icon: 'success',
                confirmButtonText: 'Aceptar' // Cambia el texto del botón si lo deseas
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.reload(); // Recargar la página después de que el usuario haga clic en "Aceptar"
                }
            });
            closeModal('modalAceptar');
        }).catch(error => {
            Swal.fire({
                title: 'Error',
                text: error.message,
                icon: 'error'
            });
        });
    });

    // Manejar el envío del formulario para Subsanar
    document.getElementById('btnSubsanar').addEventListener('click', function() {
        var codigo = document.getElementById('codigoSubsanar').innerText;
        var mensajeSubsanar = document.getElementById('mensajeSubsanar').value;
        fetch(baseURL + 'update_subsanar.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                'codigo_tramite': codigo,
                'mensaje': mensajeSubsanar
            })
        }).then(response => {
            if (!response.ok) {
                return response.text().then(text => {
                    throw new Error('Error: ' + response.status + ' ' + response.statusText + ' - ' + text);
                });
            }
            return response.text();
        }).then(data => {
            Swal.fire({
                title: 'Éxito',
                text: data,
                icon: 'success',
                confirmButtonText: 'Aceptar' // Cambia el texto del botón si lo deseas
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.reload(); // Recargar la página después de que el usuario haga clic en "Aceptar"
                }
            });
            closeModal('modalSubsanar');
        }).catch(error => {
            Swal.fire({
                title: 'Error',
                text: error.message,
                icon: 'error'
            });
        });
    });

    // Manejar el envío del formulario para Eliminar
    document.getElementById('btnEliminar').addEventListener('click', function() {
        var codigo = document.getElementById('codigoEliminar').innerText;
        var mensajeEliminar = document.getElementById('mensajeEliminar').value;
        fetch(baseURL + 'update_eliminar.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                'codigo_tramite': codigo,
                'mensaje': mensajeEliminar
            })
        }).then(response => {
            if (!response.ok) {
                return response.text().then(text => {
                    throw new Error('Error: ' + response.status + ' ' + response.statusText + ' - ' + text);
                });
            }
            return response.text();
        }).then(data => {
            Swal.fire({
                title: 'Éxito',
                text: data,
                icon: 'success',
                confirmButtonText: 'Aceptar' // Cambia el texto del botón si lo deseas
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.reload(); // Recargar la página después de que el usuario haga clic en "Aceptar"
                }
            });
            closeModal('modalEliminar');
        }).catch(error => {
            Swal.fire({
                title: 'Error',
                text: error.message,
                icon: 'error'
            });
        });
    });
            // Función para realizar la búsqueda en tiempo real
            document.getElementById('buscar').addEventListener('input', function() {
                var filter = this.value.toLowerCase();
                var table = document.getElementById('tablaTramites');
                var rows = table.getElementsByTagName('tr');

                for (var i = 1; i < rows.length; i++) { // Comenzamos desde 1 para omitir la fila del encabezado
                    var cells = rows[i].getElementsByTagName('td');
                    var match = false;

                    for (var j = 0; j < cells.length; j++) {
                        if (cells[j].innerText.toLowerCase().includes(filter)) {
                            match = true;
                            break;
                        }
                    }

                    rows[i].style.display = match ? '' : 'none';
                }
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