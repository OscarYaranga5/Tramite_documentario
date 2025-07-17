<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MESA DE PARTES VIRTUAL</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
      margin: auto;
    }

    .paso {
      background: #ffffff;
      border-radius: 16px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.08);
      padding: 30px;
      margin-bottom: 40px;
      transition: all 0.3s ease;
    }

    .paso h2 {
      margin-top: 0;
      color: #5e60ce;
      font-size: 1.5rem;
      display: flex;
      align-items: center;
      gap: 10px;
      border-bottom: 2px solid #eee;
      padding-bottom: 10px;
      margin-bottom: 20px;
    }

    .documentos {
      display: flex;
      flex-direction: column;
      gap: 15px;
      margin-top: 15px;
    }

    .documentos label {
      font-weight: bold;
      color: #333;
    }

    .descargar {
      display: inline-block;
      margin-top: 5px;
      text-decoration: none;
      color: #5e60ce;
      font-weight: 600;
    }

    .descargar i {
      margin-right: 5px;
    }

    .imagen-mini {
      width: 100%;
      max-width: 300px;
      border-radius: 12px;
      margin-top: 20px;
      display: block;
      margin-left: auto;
      margin-right: auto;
    }

    form .campo {
      margin-bottom: 20px;
    }

    form label {
      font-weight: 600;
      display: block;
      margin-bottom: 5px;
      color: #444;
    }

    form input[type="text"],
    form input[type="email"],
    form input[type="file"] {
      width: 100%;
      padding: 10px;
      border-radius: 8px;
      border: 1px solid #ccc;
      transition: border-color 0.3s;
    }

    form input:focus {
      border-color: #5e60ce;
    }

    form input[type="submit"] {
      padding: 14px;
      background: linear-gradient(to right, #43e97b, #38f9d7);
      border: none;
      border-radius: 10px;
      color: white;
      font-weight: bold;
      font-size: 1rem;
      width: 100%;
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

    <section class="paso paso1">
      <h2><i class="fas fa-info-circle"></i> Paso 1: Informacion Importante</h2>
      <p>Por favor, revisa los documentos antes de realizar tu trámite:</p>
      <p>PASO 1: Rellena el Formato Unico de Trámite</p>
      <p>PASO 2: Revisa el tarifario de acuerdo al trámite solicitado </p>
      <p>PASO 3: Rellena los datos en el formulario </p>
      <p>TAMBIEN PUEDE OPTAR POR DIGITAR EL NUMERO DE TELEFONO : 999 999 999 </p>

      <div class="documentos">
        <div>
          <label>Formato Único de Trámite (FUT)</label>
          <a href="fut.docx" class="descargar" download><i class="fas fa-file-word"></i> Descargar FUT</a>
        </div>
        <div>
          <label>Tarifario</label>
          <a href="TARIFAS.pdf" class="descargar" download><i class="fas fa-file-pdf"></i> Descargar Tarifario</a>
        </div>
      </div>

      <img src="YAPECITO.jpg" alt="Decorativo" class="imagen-mini">
    </section>

    <section class="paso paso2">
      <h2><i class="fas fa-edit"></i> Paso 2: Registrar Trámite</h2>
      <form action="" method="post" enctype="multipart/form-data">
        <div class="campo">
          <label for="nombre"><i class="fas fa-user"></i> Nombres y Apellidos</label>
          <input type="text" id="nombre" name="nombre" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+" oninput="soloLetras(this)" required>
        </div>
        <div class="campo">
          <label for="cedula"><i class="fas fa-id-card"></i> DNI</label>
          <input type="text" id="cedula" name="cedula" pattern="\d+" oninput="soloNumeros(this)" required>
        </div>
        <div class="campo">
          <label for="telefono"><i class="fas fa-phone-alt"></i> Celular</label>
          <input type="text" id="telefono" name="telefono" pattern="\d{9}" maxlength="9" oninput="soloNumeros(this)" required>
        </div>
        <div class="campo">
          <label for="correo"><i class="fas fa-envelope"></i> Correo Electrónico</label>
          <input type="email" id="correo" name="correo" required>
        </div>
        <div class="campo">
          <label for="archivo"><i class="fas fa-upload"></i> Adjuntar archivo (PDF)</label>
          <input type="file" id="archivo" name="archivo" accept="application/pdf" required>
        </div>
        <div class="campo">
          <label for="comprobante"><i class="fas fa-money-check-alt"></i> Comprobante de Pago Yape (PDF o imagen)</label>
          <input type="file" id="comprobante" name="comprobante" accept="application/pdf,image/*" required>
        </div>
        <input type="submit" name="submit_tramite" value="Enviar Trámite">
      </form>
    </section>
  </main>

  <script>
    function soloLetras(input) {
      input.value = input.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '');
    }
    function soloNumeros(input) {
      input.value = input.value.replace(/\D/g, '');
    }
  </script>
</body>
</html>
