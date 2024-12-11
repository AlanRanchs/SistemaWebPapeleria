<?php
session_start();
include "modelo/conexion.php";

// Verificar si hay datos de confirmación en la sesión
if (isset($_SESSION['confirmacion_pedido'])) {
    $pedido = $_SESSION['confirmacion_pedido'];
    $total_a_pagar = $pedido['total_a_pagar'];
    $metodo_pago = $pedido['metodo_pago'];

    // Obtener el ID del último pedido insertado para el cliente actual
    $id_cliente = $_SESSION['id_cliente'];
    $query = "SELECT id_pedido, nombre_cliente FROM pedidos WHERE id_cliente = ? ORDER BY id_pedido DESC LIMIT 1";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $id_cliente);
    $stmt->execute();
    $stmt->bind_result($id_pedido, $nombre_cliente);
    $stmt->fetch();
    $stmt->close();

    unset($_SESSION['confirmacion_pedido']); // Limpiar la confirmación después de usarla
} else {
    $pedido = ['productos' => []];
    $total_a_pagar = 0;
    $id_pedido = null; // Si no hay pedido, el ID será nulo
    $nombre_cliente = null;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Pedido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/estiloindex.css">
    <link rel="icon" href="img/logo2.jpeg" type="image/png">
    <style>
        .confirmation-header { background-color: #232f3e; color: white; padding: 1rem; text-align: center; }
        .confirmation-message { padding: 2rem; text-align: center; }
        .product-list { padding: 2rem; }
        .footer { background-color: #007bff; color: white; padding: 1rem 0; text-align: center; position: absolute; bottom: 0; width: 100%; }
        .btn-seguir-comprando { display: block; margin: 2rem auto; padding: 1rem 2rem; font-size: 1.25rem; }
        .total-a-pagar { font-size: 1.5rem; font-weight: bold; text-align: center; margin-top: 2rem; }
        .pedido-id { font-size: 1.25rem; color: #28a745; text-align: center; margin-top: 1rem; }
    </style>
</head>
<body>
<header class="confirmation-header">
    <h1>Gracias, se ha realizado tu pedido.</h1>
</header>

<main class="container">
    <div class="confirmation-message">
        <h2>Gracias por tu compra, <?php echo htmlspecialchars($nombre_cliente); ?>!</h2>
        <p>Tu pedido ha sido procesado correctamente.</p>
    </div>
    <div class="pedido-id">
        <?php if ($id_pedido): ?>
            <p><strong>ID de tu Pedido:</strong> <?php echo htmlspecialchars($id_pedido); ?></p>
        <?php else: ?>
            <p>No se pudo recuperar el ID del pedido.</p>
        <?php endif; ?>
    </div>
    <div class="product-list">
        <h3>Productos en tu pedido</h3>
        <div class="row">
            <?php if (!empty($pedido['productos'])): ?>
                <?php foreach ($pedido['productos'] as $producto): ?>
                    <div class="col-3">
                        <p><?php echo htmlspecialchars($producto['nombre']); ?></p>
                        <p><?php echo $producto['cantidad']; ?> x $<?php echo number_format($producto['precio'], 2); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No hay productos en el pedido.</p>
            <?php endif; ?>
        </div>
        <div class="total-a-pagar">
            Total a pagar: $<?php echo number_format($total_a_pagar, 2); ?><br>
            Método de pago: <?php echo htmlspecialchars($metodo_pago); ?>
        </div>
    </div>
    <div class="text-center">
        <button onclick="window.location.href='index.php'" class="btn btn-primary btn-seguir-comprando">Seguir comprando</button>
    </div>
</main>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

