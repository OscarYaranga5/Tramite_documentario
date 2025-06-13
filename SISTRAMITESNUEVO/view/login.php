<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INICIO DE SESION</title>
    <link rel="stylesheet" href="../Css/login.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="login">
        <img src="../logo.png" alt="Logo de la empresa">
        <form action="" method="post">
            <h2> INICIO DE SESION </h2>
            <label for="email"> USUARIO (CORREO)</label>
            <input type="email" id="email" name="email" required>
            <label for="password"> CONTRASEÑA</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">INGRESAR</button>
        </form>
        <?php 
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            session_start();
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Conexión a la base de datos
            $servername = "localhost";
            $username = "root"; // Cambia esto si tienes un usuario diferente
            $dbpassword = "root"; // Cambia esto si tienes una contraseña diferente
            $dbname = "sistemacolegio";

            // Crear conexión
            $conn = new mysqli($servername, $username, $dbpassword, $dbname);

            // Verificar conexión
            if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error);
            }

            // Preparar y ejecutar consulta
            $sql = "SELECT * FROM usuario WHERE correo = ? AND contraseña = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $email, $password);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $_SESSION['email'] = $email; // Crear sesión
                echo "<script>
                    Swal.fire({
                        title: 'Bienvenido',
                        text: 'Inicio de sesión exitoso',
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'Admin/tramiteNuevosAdmin.php';
                        }
                    });
                </script>";
            } else {
                echo "<script>
                    Swal.fire({
                        title: 'Error',
                        text: 'Correo o contraseña incorrectos',
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                </script>";
            }

            // Cerrar conexión
            $stmt->close();
            $conn->close();
        }
        ?>
    </div>
</body>
</html>
