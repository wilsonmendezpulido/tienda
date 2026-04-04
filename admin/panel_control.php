<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: inicio_sesion.php");
    exit();
}

include '../incluir/conexion.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin - TechStore</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f4f6f9;
        }

        /* NAVBAR */
        .navbar {
            background: #111;
        }

        /* TARJETAS */
        .dashboard-card {
            border: none;
            border-radius: 15px;
            padding: 20px;
            transition: 0.3s;
            background: #fff;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.1);
        }

        .dashboard-icon {
            font-size: 40px;
            margin-bottom: 10px;
        }

        /* COLORES */
        .bg-products {
            background: linear-gradient(45deg, #007bff, #00c6ff);
            color: white;
        }

        .bg-orders {
            background: linear-gradient(45deg, #28a745, #85e085);
            color: white;
        }

        .bg-users {
            background: linear-gradient(45deg, #6f42c1, #a084e8);
            color: white;
        }

        .bg-sales {
            background: linear-gradient(45deg, #fd7e14, #ffb347);
            color: white;
        }

        .card a {
            text-decoration: none;
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-dark">
        <div class="container d-flex justify-content-between">
            <span class="navbar-brand">⚡ TechStore Admin</span>
            <a href="cerrar_sesion.php" class="btn btn-danger btn-sm">
                <i class="bi bi-box-arrow-right"></i> Salir
            </a>
        </div>
    </nav>

    <div class="container mt-5">

        <h3 class="mb-4">Bienvenido, <?php echo $_SESSION['admin']; ?></h3>

        <div class="row">

            <!-- PRODUCTOS -->
            <div class="col-md-3 mb-4">
                <a href="gestion_productos.php">
                    <div class="dashboard-card bg-products text-center">
                        <div class="dashboard-icon">
                            <i class="bi bi-box-seam"></i>
                        </div>
                        <h5>Productos</h5>
                        <p>Gestiona tu catálogo</p>
                    </div>
                </a>
            </div>

            <!-- PEDIDOS -->
            <div class="col-md-3 mb-4">
                <div class="dashboard-card bg-orders text-center">
                    <div class="dashboard-icon">
                        <i class="bi bi-bag-check"></i>
                    </div>
                    <h5>Pedidos</h5>
                    <p>Ver ventas</p>
                </div>
            </div>

            <!-- USUARIOS -->
            <div class="col-md-3 mb-4">
                <div class="dashboard-card bg-users text-center">
                    <div class="dashboard-icon">
                        <i class="bi bi-people"></i>
                    </div>
                    <h5>Usuarios</h5>
                    <p>Administrar usuarios</p>
                </div>
            </div>

            <!-- REPORTES -->
            <div class="col-md-3 mb-4">
                <div class="dashboard-card bg-sales text-center">
                    <div class="dashboard-icon">
                        <i class="bi bi-graph-up"></i>
                    </div>
                    <h5>Reportes</h5>
                    <p>Estadísticas</p>
                </div>
            </div>

        </div>

    </div>

</body>

</html>