<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: inicio_sesion.php");
    exit();
}

include '../incluir/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {

        $nombre_imagen = basename($_FILES['imagen']['name']);
        $ruta_destino = '../recursos/imagenes/' . $nombre_imagen;

        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_destino)) {

            $consulta = "INSERT INTO productos (nombre, descripcion, precio, imagen, stock) 
                         VALUES ('$nombre', '$descripcion', $precio, '$nombre_imagen', $stock)";

            if ($conexion->query($consulta)) {
                header("Location: gestion_productos.php?ok=1");
                exit();
            } else {
                $error = "Error: " . $conexion->error;
            }
        } else {
            $error = "Error al subir la imagen";
        }
    } else {
        $error = "Debes subir una imagen";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto</title>

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

        /* PREVIEW */
        .preview-img {
            width: 100%;
            max-height: 200px;
            object-fit: contain;
            border: 1px dashed #ccc;
            border-radius: 10px;
            padding: 10px;
            display: none;
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

            <h4 class="mb-4">Agregar Producto</h4>

            <?php if (isset($error)) { ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php } ?>

            <form method="POST" enctype="multipart/form-data">

                <div class="row">

                    <!-- FORM -->
                    <div class="col-md-6">

                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" name="nombre" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Descripción</label>
                            <textarea name="descripcion" class="form-control" rows="4" required></textarea>
                        </div>

                        <div class="form-group">
                            <label>Precio</label>
                            <input type="number" step="0.01" name="precio" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Stock</label>
                            <input type="number" name="stock" class="form-control" required>
                        </div>

                        <button class="btn btn-success btn-block">
                            Guardar Producto
                        </button>

                    </div>

                    <!-- IMAGEN -->
                    <div class="col-md-6">

                        <label>Vista previa</label>

                        <img id="preview" class="preview-img mb-3">

                        <div class="form-group">
                            <label>Subir imagen</label>
                            <input type="file" name="imagen" class="form-control-file" accept="image/*" onchange="previewImage(event)" required>
                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>

    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const img = document.getElementById('preview');
                img.src = reader.result;
                img.style.display = 'block';
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>

</body>

</html>