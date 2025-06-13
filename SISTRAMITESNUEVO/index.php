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
            <h1>SISTEMA DE TRÁMITE DOCUMENTARIO</h1>
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
            <p>Nadie desea situaciones indeseadas :c, por ello te invitamos a revisar el manual de uso para una mejor experiencia, asi como tambien los tarifarios por operación</p>
            <img src="YAPECITO.jpg" alt="">
            <label for="">Descargar Formato Unico de Tramite (FUT):</label>
            <a href="fut.docx" download>Descargar Formato Unico de Tramite (FUT)</a>
            <label for="">Descargar Tarifario:</label>
            <a href="TARIFAS.pdf" download>DESCARGAR TARIFARIO</a>
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
