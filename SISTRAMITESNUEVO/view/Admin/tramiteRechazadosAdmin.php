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
    <title>Trámites Eliminados</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f4f6f8;
    margin: 0;
    padding: 0;
}

header {
    background-color: #2f4050;
    color: #ffffff;
    padding: 15px 30px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

header .logo img {
    height: 60px;
    margin-right: 15px;
}

header .itemsNav,
header .itemsPerfil {
    display: flex;
    gap: 20px;
}

header a {
    color: #ffffff;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s;
}

header a:hover {
    color: #1ab394;
}

.encabezado {
    text-align: center;
    padding: 30px 0 10px;
    background-color: #ffffff;
    border-bottom: 1px solid #e5e5e5;
}

main {
    max-width: 1200px;
    margin: auto;
    padding: 30px;
}

.dato {
    background-color: #ffffff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

#buscar {
    width: 100%;
    padding: 12px 15px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 16px;
}

#buscar:focus {
    border-color: #1ab394;
    outline: none;
    box-shadow: 0 0 5px rgba(26, 179, 148, 0.5);
}

.contenedorTable {
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
    font-size: 15px;
}

thead {
    background-color: #1ab394;
    color: white;
}

thead th {
    padding: 12px 15px;
    text-align: left;
}

tbody tr {
    border-bottom: 1px solid #dddddd;
}

tbody tr:nth-child(even) {
    background-color: #f9f9f9;
}

tbody tr:hover {
    background-color: #f1f1f1;
}

tbody td {
    padding: 12px 15px;
    transition: background-color 0.3s ease;
}

a i.fa-file-pdf {
    margin-right: 5px;
    color: #e74c3c;
    transition: all 0.2s ease-in-out;
}

a i.fa-file-pdf:hover {
    color: #c0392b;
    transform: scale(1.1);
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
    <div class="encabezado">
        <h1>Trámites Rechazados</h1>
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
                        <th>Pago</th>
                    </tr>
                </thead>
                <tbody id="tablaTramites">
                    <?php
                    $conn = new mysqli("localhost", "root", "root", "sistemacolegio");
                    if ($conn->connect_error) {
                        die("Error en la conexión: " . $conn->connect_error);
                    }

                    $sql = "SELECT * FROM tramites WHERE Estado = 'Eliminado'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['codigo_tramite']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['Remitente']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['documento_identidad']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['telefono']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['fecha_envio']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['fecha_recepcion']) . "</td>";
                            echo "<td><a href='../../pdf/" . htmlspecialchars($row['archivo']) . "' download class='download-link'><i class='fas fa-file-download' style='color: #1ab394; margin-right: 6px;'></i><span style='color: #2f4050; font-weight: bold;'>VER</span></a></td>";
                            
                            if (!empty($row['comprobante_pago'])) {
                                echo "<td><a href='../../comprobantes/" . htmlspecialchars($row['comprobante_pago']) . "' target='_blank'><i class='fas fa-money-check-alt' style='color: #1ab394; margin-right: 5px;'></i>VER</a></td>";
                            } else {
                                echo "<td><span style='color:red;'>Sin pago</span></td>";
                            }

                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9'>No se encontraron trámites rechazados.</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</main>
<script>
    document.getElementById('buscar').addEventListener('input', function () {
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
        e.preventDefault();
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
                window.location.href = '../../php/logout.php';
            }
        });
    });
</script>
</body>
</html>
