<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MESA DE PARTES VIRTUAL</title>
    <link rel="stylesheet" href="Css/index1.css">
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
            <a href="">Nuevo Tramite</a>
            <a href="consulta.php">Consultar Tramites</a>
            <a href=""></a>
        </div>
    </header>
    <main>
        <?php
        include 'php/guardar_tramite.php';
        if (isset($message)) {
            echo "<script>
                Swal.fire({
                    title: 'Mensaje',
                    text: '$message',
                    icon: '" . ($success ? "success" : "error") . "'
                });
                </script>";
        }
        ?>
        <div class="info">
            <h3><i class="fas fa-download"></i> Primer Paso</h3>
            <p>Debe descargar el fut, el tupac y hacer pago correspondiente para iniciar el tramite.</p>
            <img src="yape.jpg" alt="">
            <label for="">Descargar FUT:</label>
            <a href="fut 21001.doc" download>Fut 21001.doc</a>
            <label for="">Descargar TUPAC:</label>
            <a href="tupa 21001.pdf" download>tupac 21001.pdf</a>
        </div>
        <form action="" method="post" enctype="multipart/form-data">
            <h3><i class="fas fa-edit"></i> Segundo Paso</h3>
            <p>Debe rellenar los datos para enviar dicho tramite.</p>
            <label for="nombre">Nombres y Apellidos:</label>
            <input type="text" id="nombre" name="nombre" required>
            <label for="cedula">Documento de Identidad (DNI):</label>
            <input type="text" id="cedula" name="cedula" required>
            <label for="telefono">Teléfono o Celular:</label>
            <input type="text" id="telefono" name="telefono" required>
            <label for="correo">Correo Electrónico:</label>
            <input type="email" id="correo" name="correo" required>
            <label for="archivo">Archivo (PDF):</label>
            <input type="file" id="archivo" name="archivo" required>
            <input type="submit" name="submit_tramite" value="Enviar">
        </form>
    </main>
</body>
</html>
