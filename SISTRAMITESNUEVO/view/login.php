<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INICIO DE SESION</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<style>
body {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    margin: 0;
    padding: 0;
    font-family: 'Inter', sans-serif;
    background: linear-gradient(135deg, #667eea, #764ba2);
}

.login {
    width: 600px;
    margin-top: 50px;
    border-radius: 20px;
    padding: 0;
    border: none;
    display: flex;
    justify-content: center;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
    overflow: hidden;
    background: linear-gradient(to bottom right, #ffffff, #f0f0f0);
}

img {
    width: 80%;
    object-fit: cover;
}

form {
    width: 50%;
    padding: 40px 30px;
    display: flex;
    flex-direction: column;
    gap: 18px;
    background: linear-gradient(to bottom right, #ffffff, #f9f9f9);
    color: #333;
}

h2 {
    text-align: center;
    color: #5e60ce;
    margin-bottom: 10px;
    font-size: 24px;
    font-weight: 600;
}

label {
    font-weight: 600;
    font-size: 0.95rem;
}

input[type="text"],
input[type="password"] {
    padding: 12px;
    border-radius: 10px;
    border: 1px solid #ccc;
    outline: none;
    font-size: 1rem;
    background: #fefefe;
    box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
    transition: 0.3s;
}

input[type="text"]:focus,
input[type="password"]:focus {
    border-color: #5e60ce;
    box-shadow: 0 0 0 3px rgba(94, 96, 206, 0.2);
}

button {
    width: 100%;
    padding: 12px;
    background: linear-gradient(90deg, #43e97b, #38f9d7);
    border: none;
    border-radius: 10px;
    color: #fff;
    font-weight: 600;
    font-size: 1rem;
    cursor: pointer;
    transition: 0.3s;
}

button:hover {
    background: linear-gradient(90deg, #2cc67c, #29d3c2);
}

</style>
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
