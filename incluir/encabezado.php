<?php
include 'conexion.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand font-weight-bold" href="index.php">
            ⚡ TechStore
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav ml-auto align-items-center">

                <li class="nav-item mx-2">
                    <a class="nav-link" href="index.php">Inicio</a>
                </li>

                <li class="nav-item mx-2">
                    <a class="nav-link" href="carrito.php">
                        🛒 Carrito
                        <?php
                        $totalItems = 0;

                        if (isset($_SESSION['carrito'])) {
                            foreach ($_SESSION['carrito'] as $item) {
                                $totalItems += $item['cantidad'];
                            }
                        }
                        ?>

                        <span class="badge badge-light">
                            <?php echo $totalItems; ?>
                        </span>
                    </a>
                </li>

                <li class="nav-item mx-2">
                    <a class="nav-link btn btn-primary text-white px-3" href="pago.php">
                        Comprar
                    </a>
                </li>

            </ul>
        </div>
    </div>
</nav>