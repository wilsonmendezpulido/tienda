<?php
session_start();
include '../incluir/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);


    // CONSULTA SEGURA
    $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE TRIM(LOWER(usuario)) = TRIM(LOWER(?))");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows == 1) {

        $user = $resultado->fetch_assoc();

        // VALIDAR PASSWORD (compatible con password_hash)
        if (password_verify($password, $user['password'])) {

            $_SESSION['admin'] = $user['usuario'];

            header("Location: panel_control.php");
            exit();
        } else {
            $error = "Contraseña incorrecta";
        }
    } else {
        $error = "Usuario no encontrado";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #1d2b64, #f8cdda);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* CARD */
        .login-card {
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .login-title {
            text-align: center;
            font-weight: 600;
            margin-bottom: 20px;
        }

        /* BOTON */
        .btn-login {
            border-radius: 30px;
            font-weight: 600;
        }

        /* INPUT */
        .form-control {
            border-radius: 10px;
        }
    </style>
</head>

<body>

    <div class="login-card">

        <h4 class="login-title">🔐 Panel Administrativo</h4>

        <?php if (isset($error)) { ?>
            <div class="alert alert-danger text-center"><?php echo $error; ?></div>
        <?php } ?>

        <form method="POST">

            <div class="form-group">
                <input type="text" name="usuario" class="form-control" placeholder="👤 Usuario" required>
            </div>

            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="🔒 Contraseña" required>
            </div>

            <button type="submit" class="btn btn-primary btn-block btn-login">
                Iniciar Sesión
            </button>

        </form>

    </div>

</body>

</html>