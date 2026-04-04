<?php
//header("Content-Type: application/json");

$consulta = "SELECT * FROM productos";
$resultado = $conexion->query($consulta);

while ($producto = $resultado->fetch_assoc()) {

    $ruta = 'recursos/imagenes/' . $producto['imagen'];

    echo '
            <div class="producto-item" data-nombre="' . strtolower($producto['nombre']) . '">

            <div class="product-card">

                <div class="product-img">
                    <img src="' . $ruta . '">
                </div>

                <div class="product-body">

                    <div>
                        <div class="product-title">' . $producto['nombre'] . '</div>

                        <div class="product-desc">
                            ' . substr($producto['descripcion'], 0, 60) . '
                        </div>
                    </div>

                    <div>

                        <div class="product-price mb-2">
                            $' . number_format($producto['precio'], 0, ',', '.') . '
                        </div>

                        <div class="product-actions">

                            <button class="btn btn-outline-dark btn-sm mb-2"
                            onclick="verProducto(
                            \'' . addslashes($producto['nombre']) . '\',
                            \'' . addslashes($producto['descripcion']) . '\',
                            \'' . $ruta . '\',
                            \'' . $producto['precio'] . '\',
                            \'' . $producto['id_producto'] . '\'
                            )">
                            👁 Ver
                            </button>

                            <a href="carrito.php?accion=agregar&id=' . $producto['id_producto'] . '"
                            class="btn btn-cart btn-block text-white">
                            🛒 Comprar
                            </a>

                        </div>

                    </div>

                </div>

            </div>
            </div>
            ';
}
