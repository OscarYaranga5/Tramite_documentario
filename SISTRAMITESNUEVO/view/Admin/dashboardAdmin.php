<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: ../login.php');
    exit();
}

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "sistemacolegio";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$estados = ['Enviado', 'Subsanar', 'Aceptado', 'Eliminado'];
$conteos = [];
foreach ($estados as $estado) {
    $sql = "SELECT COUNT(*) as total FROM tramites WHERE Estado = '$estado'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $conteos[$estado] = $row['total'];
}

// Manejo de filtro por fechas
$filtro = "";
$fechaInicio = isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : '';
$fechaFin = isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : '';

if ($fechaInicio && $fechaFin) {
    $filtro = "WHERE fecha_envio BETWEEN '$fechaInicio' AND '$fechaFin'";
}

$sqlUltimos = "SELECT * FROM tramites $filtro ORDER BY fecha_envio DESC";
$resultUltimos = $conn->query($sqlUltimos);
$ultimosTramites = [];
while ($row = $resultUltimos->fetch_assoc()) {
    $ultimosTramites[] = $row;
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Trámites</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6f8;
            color: #2f4050;
        }
        header {
            background-color: #2f4050;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        header .logo img {
            height: 50px;
        }
        .itemsNav a, .itemsPerfil a {
            color: white;
            margin-left: 20px;
            text-decoration: none;
            font-weight: bold;
        }
        .itemsNav a:hover, .itemsPerfil a:hover {
            color: #1ab394;
        }
        main {
            padding: 30px;
            max-width: 1200px;
            margin: auto;
        }
        .cards {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }
        .card {
            flex: 1 1 200px;
            background-color: white;
            border-left: 5px solid #1ab394;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .card h2 {
            margin: 0 0 5px;
            font-size: 18px;
            color: #666;
        }
        .card p {
            font-size: 24px;
            font-weight: bold;
        }
        .grafico-container {
            margin-bottom: 30px;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            text-align: center;
        }
        canvas {
            max-width: 300px;
            margin: auto;
        }
        .filtro-fecha {
            margin-bottom: 20px;
        }
        .filtro-fecha input[type="date"] {
            padding: 5px;
            font-size: 16px;
            margin-right: 10px;
        }
        .filtro-fecha button {
            padding: 7px 15px;
            font-size: 16px;
            background-color: #1ab394;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        th {
            background-color: #1ab394;
            color: white;
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
        <h1>Dashboard de Trámites</h1>

        <div class="cards">
            <div class="card">
                <h2>Trámites Nuevos</h2>
                <p><?php echo $conteos['Enviado']; ?></p>
            </div>
            <div class="card">
                <h2>Trámites a Subsanar</h2>
                <p><?php echo $conteos['Subsanar']; ?></p>
            </div>
            <div class="card">
                <h2>Trámites Aceptados</h2>
                <p><?php echo $conteos['Aceptado']; ?></p>
            </div>
            <div class="card">
                <h2>Trámites Rechazados</h2>
                <p><?php echo $conteos['Eliminado']; ?></p>
            </div>
        </div>

        <div class="grafico-container">
            <canvas id="graficoTramites"></canvas>
        </div>

        <div class="filtro-fecha">
            <form method="GET">
                <label for="fecha_inicio">Desde: </label>
                <input type="date" name="fecha_inicio" id="fecha_inicio" value="<?php echo $fechaInicio; ?>">
                <label for="fecha_fin">Hasta: </label>
                <input type="date" name="fecha_fin" id="fecha_fin" value="<?php echo $fechaFin; ?>">
                <button type="submit">Filtrar</button>
            </form>
        </div>

        <h2>Trámites <?php echo ($fechaInicio && $fechaFin) ? "filtrados" : "recientes"; ?></h2>
        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Remitente</th>
                    <th>Correo</th>
                    <th>Estado</th>
                    <th>Fecha Envío</th>
                    <th>Descargar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ultimosTramites as $t) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($t['codigo_tramite']); ?></td>
                        <td><?php echo htmlspecialchars($t['Remitente']); ?></td>
                        <td><?php echo htmlspecialchars($t['email']); ?></td>
                        <td><?php echo htmlspecialchars($t['Estado']); ?></td>
                        <td><?php echo htmlspecialchars($t['fecha_envio']); ?></td>
                                <td>
        <a href="../../pdf/<?php echo htmlspecialchars($t['archivo']); ?>" download>
            <i class="fas fa-file-download" style="color: #1ab394;"> VER</i>
        </a>
    </td>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

    <script>
        const ctx = document.getElementById('graficoTramites').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Nuevos', 'Subsanar', 'Aceptados', 'Eliminado'],
                datasets: [{
                    data: [
                        <?php echo $conteos['Enviado']; ?>,
                        <?php echo $conteos['Subsanar']; ?>,
                        <?php echo $conteos['Aceptado']; ?>,
                        <?php echo $conteos['Eliminado']; ?>
                    ],
                    backgroundColor: [
                        '#3498db', '#f39c12', '#2ecc71', '#e74c3c'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed;
                                return label + ': ' + value;
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>

