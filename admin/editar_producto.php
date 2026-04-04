<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: inicio_sesion.php");
    exit();
}

include '../incluir/conexion.php';

// OBTENER PRODUCTO
if (isset($_GET['id'])) {
    $id_producto = (int)$_GET['id'];
    $consulta = "SELECT * FROM productos WHERE id_producto = $id_producto";
    $resultado = $conexion->query($consulta);

    if ($resultado->num_rows == 1) {
        $producto = $resultado->fetch_assoc();
    } else {
        header("Location: gestion_productos.php");
        exit();
    }
} else {
    header("Location: gestion_productos.php");
    exit();
}

// ACTUALIZAR
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $nombre_imagen = $producto['imagen'];

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {

        $nombre_imagen = basename($_FILES['imagen']['name']);
        $ruta_destino = '../recursos/imagenes/' . $nombre_imagen;

        if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_destino)) {
            $error = "Error al subir la imagen";
        }
    }

    $consulta = "UPDATE productos 
        SET nombre='$nombre', descripcion='$descripcion', precio=$precio, imagen='$nombre_imagen', stock=$stock 
        WHERE id_producto=$id_producto";

    if ($conexion->query($consulta)) {
        header("Location: gestion_productos.php?ok=1");
        exit();
    } else {
        $error = "Error: " . $conexion->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        body {
            background: #f4f6f9;
        }

        /* NAV */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        /* CARD */
        .form-card {
            background: #fff;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        }

        /* IMG PREVIEW */
        .preview-img {
            width: 100%;
            max-height: 200px;
            object-fit: contain;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 10px;
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-dark bg-dark">
        <div class="container d-flex justify-content-between">

            <div>
                <a href="panel_control.php" class="navbar-brand">⚡ Admin</a>

                <a href="gestion_productos.php" class="btn btn-outline-light btn-sm ml-2">
                    ← Productos
                </a>
            </div>

            <div>
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

        <div class="form-card">

            <h4 class="mb-4">Editar Producto</h4>

            <?php if (isset($error)) { ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php } ?>

            <form method="POST" enctype="multipart/form-data">

                <div class="row">

                    <div class="col-md-6">

                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" name="nombre" class="form-control" value="<?php echo $producto['nombre']; ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Descripción</label>
                            <textarea name="descripcion" class="form-control" rows="4" required><?php echo $producto['descripcion']; ?></textarea>
                        </div>

                        <div class="form-group">
                            <label>Precio</label>
                            <input type="number" step="0.01" name="precio" class="form-control" value="<?php echo $producto['precio']; ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Stock</label>
                            <input type="number" name="stock" class="form-control" value="<?php echo $producto['stock']; ?>" required>
                        </div>

                        <button class="btn btn-primary btn-block">
                            Actualizar Producto
                        </button>

                    </div>

                    <div class="col-md-6">

                        <label>Imagen actual</label>

                        <img src="../recursos/imagenes/<?php echo $producto['imagen']; ?>" class="preview-img mb-3">

                        <div class="form-group">
                            <label>Cambiar imagen</label>
                            <input type="file" name="imagen" class="form-control-file">
                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>

</body>

</html>