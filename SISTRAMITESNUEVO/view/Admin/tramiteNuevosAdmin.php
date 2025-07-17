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

.itemsNav a,
.itemsPerfil a {
    color: white;
    text-decoration: none;
    margin-left: 15px;
    font-weight: bold;
}

.itemsNav a:hover,
.itemsPerfil a:hover {
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
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
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
    background-color: rgba(0, 0, 0, 0.5);
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
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
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
        <a href="dashboardAdmin.php"><i class="fas fa-chart-bar"></i> Dashboard</a>
    </div>
    <div class="itemsPerfil">
        <a href="../../php/logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>
    </div>
</header>
<main>
    <div class="dato">
        <div class="botones">
            <input type="text" id="buscar" placeholder="Buscar...">
        </div>
        <div class="contenedorTable">
            <table id="tablaTramites">
                <thead>
                <tr>
                    <th>Código</th>
                    <th>Remitente</th>
                    <th>Correo</th>
                    <th>DNI</th>
                    <th>Teléfono</th>
                    <th>Enviado</th>
                    <th>Recepción</th>
                    <th>Descargar</th>
                    <th>Pago</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $conn = new mysqli("localhost", "root", "root", "sistemacolegio");
                if ($conn->connect_error) {
                    echo "<tr><td colspan='9'>Error de conexión.</td></tr>";
                } else {
                    $sql = "SELECT * FROM tramites WHERE Estado = 'Enviado'";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
echo "<tr>";
echo "<td>{$row['codigo_tramite']}</td>";
echo "<td>{$row['Remitente']}</td>";
echo "<td>{$row['email']}</td>";
echo "<td>{$row['documento_identidad']}</td>";
echo "<td>{$row['telefono']}</td>";
echo "<td>{$row['fecha_envio']}</td>";
echo "<td>{$row['fecha_recepcion']}</td>";
echo "<td><a href='../../pdf/" . basename($row['archivo']) . "' download><i class='fas fa-file-pdf'></i> Desc.</a></td>";

// 🔽 AQUÍ SE AÑADE LA COLUMNA PAGO
echo !empty($row['comprobante']) ?
    "<td><a href='../../comprobantes/" . basename($row['comprobante']) . "' target='_blank'><i class='fas fa-money-check-alt'></i> Ver</a></td>" :
    "<td><span style='color:red;'>Sin pago</span></td>";

// Botones
echo "<td>
    <button class='open-modal' data-modal='modalAceptar' data-codigo='{$row['codigo_tramite']}'>Aceptar</button>
    <button class='open-modal' data-modal='modalSubsanar' data-codigo='{$row['codigo_tramite']}'>Subsanar</button>
    <button class='open-modal' data-modal='modalEliminar' data-codigo='{$row['codigo_tramite']}'>Eliminar</button>
</td>";
echo "</tr>";
                    }
                    $conn->close();
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<!-- MODALES -->
<div id="modalAceptar" class="modal">
    <div class="modal-content">
        <span class="close" data-modal="modalAceptar">&times;</span>
        <h2>Aceptar Trámite</h2>
        <p>Código de Trámite: <span id="codigoAceptar"></span></p>
        <textarea id="mensajeAceptar" placeholder="Escribe un mensaje"></textarea>
        <button id="btnAceptar">Aceptar</button>
    </div>
</div>

<div id="modalSubsanar" class="modal">
    <div class="modal-content">
        <span class="close" data-modal="modalSubsanar">&times;</span>
        <h2>Subsanar Trámite</h2>
        <p>Código de Trámite: <span id="codigoSubsanar"></span></p>
        <textarea id="mensajeSubsanar" placeholder="Escribe un mensaje"></textarea>
        <button id="btnSubsanar">Subsanar</button>
    </div>
</div>

<div id="modalEliminar" class="modal">
    <div class="modal-content">
        <span class="close" data-modal="modalEliminar">&times;</span>
        <h2>Eliminar Trámite</h2>
        <p>Código de Trámite: <span id="codigoEliminar"></span></p>
        <textarea id="mensajeEliminar" placeholder="Escribe un mensaje"></textarea>
        <button id="btnEliminar">Rechazar</button>
    </div>
</div>

<script>
    const baseURL = '../../php/';

    function openModal(modalId, codigo) {
        document.getElementById(modalId).style.display = 'flex';
        if (modalId === 'modalAceptar') {
            document.getElementById('codigoAceptar').innerText = codigo;
        } else if (modalId === 'modalSubsanar') {
            document.getElementById('codigoSubsanar').innerText = codigo;
        } else if (modalId === 'modalEliminar') {
            document.getElementById('codigoEliminar').innerText = codigo;
        }
    }

    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }

    document.querySelectorAll('.close').forEach(span => {
        span.addEventListener('click', function () {
            closeModal(this.getAttribute('data-modal'));
        });
    });

    document.querySelectorAll('.open-modal').forEach(button => {
        button.addEventListener('click', function () {
            openModal(this.getAttribute('data-modal'), this.getAttribute('data-codigo'));
        });
    });

    // Botón Aceptar
    document.getElementById('btnAceptar').addEventListener('click', function () {
        var codigo = document.getElementById('codigoAceptar').innerText;
        var mensaje = document.getElementById('mensajeAceptar').value;
        fetch(baseURL + 'update_aceptar.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ codigo_tramite: codigo, mensaje: mensaje })
        }).then(res => res.text()).then(data => {
            Swal.fire('Éxito', data, 'success').then(() => location.reload());
        }).catch(err => {
            Swal.fire('Error', err.message, 'error');
        });
    });

    // Botón Subsanar
    document.getElementById('btnSubsanar').addEventListener('click', function () {
        var codigo = document.getElementById('codigoSubsanar').innerText;
        var mensaje = document.getElementById('mensajeSubsanar').value;
        fetch(baseURL + 'update_subsanar.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ codigo_tramite: codigo, mensaje: mensaje })
        }).then(res => res.text()).then(data => {
            Swal.fire('Éxito', data, 'success').then(() => location.reload());
        }).catch(err => {
            Swal.fire('Error', err.message, 'error');
        });
    });

    // Botón Eliminar
    document.getElementById('btnEliminar').addEventListener('click', function () {
        var codigo = document.getElementById('codigoEliminar').innerText;
        var mensaje = document.getElementById('mensajeEliminar').value;
        fetch(baseURL + 'update_eliminar.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ codigo_tramite: codigo, mensaje: mensaje })
        }).then(res => res.text()).then(data => {
            Swal.fire('Éxito', data, 'success').then(() => location.reload());
        }).catch(err => {
            Swal.fire('Error', err.message, 'error');
        });
    });
</script>
</body>
</html>




 
