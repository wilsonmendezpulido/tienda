<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: inicio_sesion.php");
    exit();
}

include '../incluir/conexion.php';

// 🔴 ELIMINAR
if (isset($_GET['accion']) && $_GET['accion'] == 'eliminar' && isset($_GET['id'])) {
    $id_producto = (int)$_GET['id'];
    $conexion->query("DELETE FROM productos WHERE id_producto = $id_producto");
    header("Location: gestion_productos.php");
    exit();
}

// 🔍 BUSCADOR
$busqueda = isset($_GET['buscar']) ? trim($_GET['buscar']) : "";

// 📄 PAGINACIÓN
$limite = 5;
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$inicio = ($pagina - 1) * $limite;

// 🔢 TOTAL REGISTROS
$sql_total = "SELECT COUNT(*) as total FROM productos WHERE nombre LIKE '%$busqueda%'";
$total_result = $conexion->query($sql_total);
$total_fila = $total_result->fetch_assoc();
$total_registros = $total_fila['total'];

$total_paginas = ceil($total_registros / $limite);

// 📦 CONSULTA PRINCIPAL
$consulta = "
SELECT * FROM productos 
WHERE nombre LIKE '%$busqueda%' 
LIMIT $inicio, $limite
";

$resultado = $conexion->query($consulta);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        body {
            background: #f4f6f9;
        }

        /* HEADER */
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        /* TABLA */
        .table {
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
        }

        /* PAGINACIÓN */
        .pagination {
            justify-content: center;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-dark bg-dark shadow-sm">
        <div class="container d-flex justify-content-between">

            <div>
                <a href="panel_control.php" class="navbar-brand">
                    ⚡ TechStore Admin
                </a>

                <a href="panel_control.php" class="btn btn-outline-light btn-sm ml-3">
                    ← Panel
                </a>
            </div>

            <div class="d-flex align-items-center">

                <span class="text-white mr-3">
                    👤 <?php echo $_SESSION['admin']; ?>
                </span>

                <a href="cerrar_sesion.php" class="btn btn-danger btn-sm">
                    Salir
                </a>

            </div>

        </div>
    </nav>

    <div class="container mt-5">

        <h3 class="mb-4">📦 Gestión de Productos</h3>

        <div class="top-bar">

            <!-- BUSCADOR -->
            <form method="GET" class="form-inline">
                <input type="text" name="buscar" class="form-control mr-2" placeholder="Buscar producto..." value="<?php echo $busqueda; ?>">
                <button class="btn btn-primary">Buscar</button>
            </form>

            <div>
                <a href="agregar_producto.php" class="btn btn-success">+ Producto</a>
                <a href="cerrar_sesion.php" class="btn btn-danger">Salir</a>
            </div>

        </div>

        <table class="table table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>

                <?php
                if ($resultado->num_rows > 0) {
                    while ($producto = $resultado->fetch_assoc()) {
                        echo '
        <tr>
            <td>' . $producto['id_producto'] . '</td>
            <td>' . $producto['nombre'] . '</td>
            <td>$' . number_format($producto['precio'], 0, ',', '.') . '</td>
            <td>' . $producto['stock'] . '</td>
            <td>
                <a href="editar_producto.php?id=' . $producto['id_producto'] . '" class="btn btn-warning btn-sm">Editar</a>
                <a href="gestion_productos.php?accion=eliminar&id=' . $producto['id_producto'] . '" 
                class="btn btn-danger btn-sm"
                onclick="return confirm(\'¿Eliminar producto?\')">Eliminar</a>
            </td>
        </tr>
        ';
                    }
                } else {
                    echo '<tr><td colspan="5" class="text-center">No hay resultados</td></tr>';
                }
                ?>

            </tbody>
        </table>

        <!-- PAGINACIÓN -->
        <nav>
            <ul class="pagination">

                <?php for ($i = 1; $i <= $total_paginas; $i++) { ?>

                    <li class="page-item <?php echo ($i == $pagina) ? 'active' : ''; ?>">
                        <a class="page-link" href="?pagina=<?php echo $i; ?>&buscar=<?php echo $busqueda; ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>

                <?php } ?>

            </ul>
        </nav>

    </div>

</body>

</html>