<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MESA DE PARTES VIRTUAL</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<style>
 * {
      box-sizing: border-box;
      font-family: 'Inter', sans-serif;
    }

    body {
      margin: 0;
      background: linear-gradient(135deg, #fdfcfb, #e2d1c3);
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
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }

    .logo {
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .logo img {
      height: 50px;
    }

    .logo h1 {
      margin: 0;
      font-size: 20px;
    }

    .nav {
      display: flex;
      gap: 20px;
      flex-wrap: wrap;
    }

    .nav a {
      text-decoration: none;
      color: white;
      font-weight: bold;
      padding: 10px 15px;
      border-radius: 8px;
      background-color: rgba(255, 255, 255, 0.1);
      transition: background 0.3s;
    }

    .nav a:hover {
      background-color: rgba(255, 255, 255, 0.3);
    }

    main {
      padding: 40px 20px;
      max-width: 900px;
      margin: 0 auto;
    }

    .info {
      background: #fff;
      padding: 25px;
      border-radius: 12px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
      margin-bottom: 30px;
    }

    .info h3 {
      margin-top: 0;
      color: #5e60ce;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .info img {
      max-width: 100%;
      margin-top: 10px;
      border-radius: 10px;
    }

    .info a {
      display: inline-block;
      margin-top: 10px;
      color: #5e60ce;
      text-decoration: none;
      font-weight: 600;
    }

    .info a:hover {
      text-decoration: underline;
    }

    form {
      background: #fff;
      padding: 25px;
      border-radius: 12px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    form h3 {
      margin-top: 0;
      color: #38b6ff;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    form label {
      margin-top: 15px;
      font-weight: 600;
    }

    form input[type="text"],
    form input[type="email"],
    form input[type="file"] {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border-radius: 8px;
      border: 1px solid #ccc;
      outline: none;
      transition: border-color 0.3s;
    }

    form input:focus {
      border-color: #5e60ce;
    }

    form input[type="submit"] {
      margin-top: 20px;
      padding: 12px;
      background: linear-gradient(to right, #43e97b, #38f9d7);
      border: none;
      border-radius: 10px;
      color: white;
      font-weight: bold;
      font-size: 1rem;
      cursor: pointer;
      transition: background 0.3s;
    }

    form input[type="submit"]:hover {
      background: linear-gradient(to right, #2cc67c, #29d3c2);
    }

    @media (max-width: 768px) {
      header {
        flex-direction: column;
        text-align: center;
      }

      .nav {
        justify-content: center;
      }
    }
</style>
<body>
    <header>
        <div class="logo">
            <img src="logo.png" alt="">
            <h1>SISTEMA DE TRÁMITE DOCUMENTARIO</h1>
        </div>
        <div class="nav">
            <a href="">Nuevo Tramite</a>
            <a href="consulta.php">Consultar Tramites</a>
            <a href="view/login.php">INICIAR SESION</a>
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
