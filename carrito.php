<?php
include 'incluir/conexion.php';
session_start();

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// ACCIONES
if (isset($_GET['accion']) && isset($_GET['id'])) {

    $id_producto = (int)$_GET['id'];

    // 👉 AGREGAR
    if ($_GET['accion'] == 'agregar') {

        $encontrado = false;

        foreach ($_SESSION['carrito'] as $index => $item) {
            if ($item['id_producto'] == $id_producto) {
                $_SESSION['carrito'][$index]['cantidad']++;
                $encontrado = true;
                break;
            }
        }

        if (!$encontrado) {
            $_SESSION['carrito'][] = [
                'id_producto' => $id_producto,
                'cantidad' => 1
            ];
        }
    }

    // 👉 SUMAR
    if ($_GET['accion'] == 'sumar') {
        foreach ($_SESSION['carrito'] as $index => $item) {
            if ($item['id_producto'] == $id_producto) {
                $_SESSION['carrito'][$index]['cantidad']++;
            }
        }
    }

    // 👉 RESTAR
    if ($_GET['accion'] == 'restar') {
        foreach ($_SESSION['carrito'] as $index => $item) {
            if ($item['id_producto'] == $id_producto) {

                $_SESSION['carrito'][$index]['cantidad']--;

                if ($_SESSION['carrito'][$index]['cantidad'] <= 0) {
                    unset($_SESSION['carrito'][$index]);
                }
            }
        }
    }

    // 👉 ELIMINAR
    if ($_GET['accion'] == 'eliminar') {
        foreach ($_SESSION['carrito'] as $index => $item) {
            if ($item['id_producto'] == $id_producto) {
                unset($_SESSION['carrito'][$index]);
            }
        }
    }

    // 🔧 REINDEXAR ARRAY (IMPORTANTE)
    $_SESSION['carrito'] = array_values($_SESSION['carrito']);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/chatbot.css">

    <style>
        body {
            background: #f5f7fa;
        }

        /* CARD */
        .cart-card {
            background: #fff;
            border-radius: 15px;
            padding: 15px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        /* IMG */
        .cart-img {
            width: 80px;
            height: 80px;
            object-fit: contain;
        }

        /* CONTROLES */
        .qty-control {
            display: flex;
            align-items: center;
        }

        .qty-control a {
            padding: 5px 10px;
            background: #ddd;
            margin: 0 5px;
            border-radius: 5px;
            text-decoration: none;
            color: #000;
        }

        /* TOTAL BOX */
        .total-box {
            background: #fff;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>

<body>
    <?php include 'incluir/encabezado.php'; ?>
    <div class="container mt-5">

        <h2 class="mb-4">🛒 Tu Carrito</h2>

        <div class="row">

            <div class="col-md-8">

                <?php
                $total = 0;

                if (!empty($_SESSION['carrito'])) {

                    foreach ($_SESSION['carrito'] as $item) {

                        $consulta = "SELECT * FROM productos WHERE id_producto = " . $item['id_producto'];
                        $res = $conexion->query($consulta);

                        if ($res->num_rows > 0) {
                            $producto = $res->fetch_assoc();

                            $subtotal = $producto['precio'] * $item['cantidad'];
                            $total += $subtotal;

                            $ruta = 'recursos/imagenes/' . $producto['imagen'];

                            echo '
                        <div class="cart-card">

                            <div class="d-flex align-items-center">

                                <img src="' . $ruta . '" class="cart-img mr-3">

                                <div>
                                    <h6>' . $producto['nombre'] . '</h6>
                                    <small>$' . number_format($producto['precio'], 0, ',', '.') . '</small>
                                </div>

                            </div>

                            <div class="qty-control">

                                <a href="carrito.php?accion=restar&id=' . $producto['id_producto'] . '">-</a>
                                <strong>' . $item['cantidad'] . '</strong>
                                <a href="carrito.php?accion=sumar&id=' . $producto['id_producto'] . '">+</a>

                            </div>

                            <div>
                                <strong>$' . number_format($subtotal, 0, ',', '.') . '</strong>
                            </div>

                            <div>
                                <a href="carrito.php?accion=eliminar&id=' . $producto['id_producto'] . '" 
                                class="btn btn-sm btn-outline-danger">✕</a>
                            </div>

                        </div>
                        ';  
                        }
                    }
                } else {
                    echo '<div class="alert alert-info">Tu carrito está vacío</div>';
                }
                ?>

            </div>

            <!-- RESUMEN -->
            <div class="col-md-4">
                <div class="total-box">
                    <h4>Total</h4>
                    <h2 class="text-success">$<?php echo number_format($total, 0, ',', '.'); ?></h2>
                    <a href="pago.php" class="btn btn-success btn-block mt-3">
                        Finalizar Compra
                    </a>
                </div>
            </div>
        </div>

    </div>

    <!-- BOTÓN FLOTANTE -->
    <div id="chat-toggle">💬</div>
    <!-- VENTANA CHAT -->
    <div id="chat-container">
        <div id="chat-header">
            <span>Asistente Virtual</span>
            <button onclick="nuevoChat()" style="background:red;color:white;border:none;padding:5px 10px;border-radius:5px;">
                Nuevo Chat
            </button>
            <button onclick="toggleChat()">✖</button>
        </div>

        <div id="chat-body"></div>

        <div id="chat-footer">
            <input type="text" id="chat-input" placeholder="Escribe tu mensaje...">
            <button onclick="enviarMensaje()">➤</button>
        </div>
    </div>

    <script src="js/app.js"></script>
    <script src="js/chatbot.js"></script>
    <?php include 'incluir/pie.php'; ?>
</body>
</html>