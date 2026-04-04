<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechStore - Tecnología</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/app.css">
    <link rel="stylesheet" href="css/chatbot.css">
</head>

<body>
    <?php include 'incluir/encabezado.php'; ?>
    <div class="hero">
        <h1>Tecnología de Última Generación</h1>
        <p>Encuentra lo mejor en tecnología</p>

        <div class="search-box">
            <input type="text" id="buscador" class="form-control" placeholder="🔍 Buscar producto...">
        </div>
    </div>

    <div class="container mt-4">
        <div class="product-grid" id="productos">
            <?php include 'api/productos.php'; ?>
        </div>
    </div>

    <!-- MODAL -->
    <div class="modal fade" id="modalProducto">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <img id="modalImg" class="img-fluid">
                        </div>
                        <div class="col-md-6">
                            <h4 id="modalNombre"></h4>
                            <p id="modalDescripcion"></p>
                            <h3 class="text-success" id="modalPrecio"></h3>
                            <a id="modalBtn" class="btn btn-primary btn-block">
                                🛒 Agregar al carrito
                            </a>
                        </div>
                    </div>
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

    <?php include 'incluir/pie.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="js/app.js"></script>
    <script src="js/chatbot.js"></script>

</body>

</html>