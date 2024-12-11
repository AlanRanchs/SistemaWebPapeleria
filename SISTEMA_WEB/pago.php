<?php
session_start();
include "modelo/conexion.php";

// Función para contar los productos en el carrito
function contarProductosEnCarrito() {
    if (!isset($_SESSION['carrito'])) {
        return 0;
    }
    $totalProductos = 0;
    foreach ($_SESSION['carrito'] as $producto) {
        $totalProductos += $producto['cantidad'];
    }
    return $totalProductos;
}

// Redirigir a carrito.php si no hay productos en el carrito
if (contarProductosEnCarrito() == 0) {
    header('Location: carrito.php');
    exit();
}

// Calcular el total del carrito
$total = 0;
if (isset($_SESSION['carrito'])) {
    foreach ($_SESSION['carrito'] as $producto) {
        $total += $producto['precio'] * $producto['cantidad'];
    }
}

// Función para guardar el pedido en la base de datos
function guardarPedido() {
    global $conexion;

    if (!isset($_SESSION['id_cliente'])) {
        echo "Datos de sesión no disponibles.";
        error_log("Datos de sesión no disponibles.");
        return false;
    }

    $id_cliente = $_SESSION['id_cliente'];
    $nombre_cliente = $_SESSION['nombre_cliente'];
    $fecha = date('Y-m-d H:i:s');
    $total_pago = 0;

    if (isset($_SESSION['carrito'])) {
        foreach ($_SESSION['carrito'] as $id_producto => $producto) {
            $nombre_producto = $producto['nombre'];
            $cantidad_producto = $producto['cantidad'];
            $precio_producto = $producto['precio'];
            $subtotal = $cantidad_producto * $precio_producto;
            $total_pago += $subtotal;

            // Inserción en la tabla pedidos
            $consulta = "
                INSERT INTO pedidos (id_producto, nombre_producto, cantidad_producto, id_cliente, nombre_cliente, fecha_compra, total_pago)
                VALUES ('$id_producto', '$nombre_producto', '$cantidad_producto', '$id_cliente', '$nombre_cliente', '$fecha', '$subtotal')
            ";
            $resultado = mysqli_query($conexion, $consulta);
            if (!$resultado) {
                echo "Error en la consulta: " . mysqli_error($conexion);
                error_log("Error en la consulta: " . mysqli_error($conexion));
                return false;
            }
        }
    }
    return true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (guardarPedido()) {
        header('Location: confirmacion.php');
        exit();
    } else {
        echo "Error al guardar el pedido.";
        error_log("Error al guardar el pedido.");
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PapelPlus - Pago</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/estiloindex.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet"> <!-- Font Awesome -->
    <link rel="icon" href="img/logo2.jpeg" type="image/png">
    <style>
        .navbar .btn {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
        }
        .navbar .input-group .form-control {
            width: 150px;
        }
        .navbar .input-group .btn {
            padding: 0.375rem 0.75rem;
        }
        .order-label {
            font-size: 0.875rem;
            margin-right: 0.5rem;
        }
        .order-select {
            width: auto;
            font-size: 0.875rem;
        }
        .cart-counter {
            background-color: #dc3545;
            border-radius: 50%;
            color: white;
            padding: 0.25em 0.6em;
            font-size: 0.875rem;
            position: absolute;
            top: -10px;
            right: -10px;
        }
        .footer {
            padding: 1rem 0;
            text-align: center;
            position: absolute;
            bottom: 0;
            width: 100%;
        }
        .list-group-item {
            display: flex;
            justify-content: space-between;
        }
        .list-group-item .text-muted {
            font-size: 0.875rem;
        }
        .total {
            font-weight: bold;
            font-size: 1.25rem;
        }
    </style>
</head>
<body>

<header>
    <div class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a href="#" class="navbar-brand">
                <strong>PapelPlus</strong>
            </a>
            <button class="navbar-toggler" type="button" 
            data-bs-toggle="collapse" 
            data-bs-target="#navbarHeader" 
            aria-controls="navbarHeader" 
            aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarHeader">
                <!-- Navegación eliminada -->
            </div>
        </div>
    </div>
</header>

<main class="container mt-4">
    <h1 class="mb-4">Pago</h1>
    <div class="row">
        <div class="col-md-6">
        <h4>Resumen del Pedido</h4>
            <ul class="list-group mb-4">
                <?php if (isset($_SESSION['carrito'])): ?>
                    <?php foreach ($_SESSION['carrito'] as $producto): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>
                                <?php echo htmlspecialchars($producto['nombre']); ?>
                                <span class="text-muted">(<?php echo $producto['cantidad']; ?>)</span>
                            </span>
                            <span>$<?php echo number_format($producto['precio'] * $producto['cantidad'], 2); ?></span>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <strong>Total</strong>
                    <strong>$<?php echo number_format($total, 2); ?></strong>
                </li>
            </ul>
            <form method="POST">
                <button type="submit" name="pagar_efectivo" class="btn btn-secondary">Pagar en efectivo</button>
            </form>
        </div>
    </div>
</main>

<footer class="footer">
    <div class="container">
        <p>&copy; 2024 PapelPlus. Todos los derechos reservados.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

