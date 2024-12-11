<?php
session_start();
include "modelo/conexion.php";

// Verificar si la sesión está iniciada y contiene el nombre del cliente
if (!isset($_SESSION['id_cliente']) || empty($_SESSION['nombre_cliente'])) {
    echo "<script>
            alert('Debe iniciar sesión para realizar un pedido.');
            window.location.href = 'iniciosesion.php';
          </script>";
    exit();
}

// Capturar valores de la sesión
$id_cliente = $_SESSION['id_cliente'];
$nombre_cliente = $_SESSION['nombre_cliente']; // Asegúrate de que este valor se establece correctamente al iniciar sesión

// Verificar que el nombre del cliente no sea vacío o nulo
if (empty($nombre_cliente)) {
    echo "<script>
            alert('El nombre del cliente no está disponible. Inicie sesión nuevamente.');
            window.location.href = 'iniciosesion.php';
          </script>";
    exit();
}

// Capturar el método de pago y procesar el total
$metodo_pago = $_POST['metodo_pago'];
$total_pago = 0; // Inicializar el total del pago

// Procesar los productos en el carrito
if (!empty($_SESSION['carrito'])) {
    foreach ($_SESSION['carrito'] as $id_producto => $producto) {
        $nombre_producto = $producto['nombre'];
        $cantidad_producto = $producto['cantidad'];
        $subtotal = $producto['precio'] * $cantidad_producto;
        $total_pago += $subtotal; // Sumar el subtotal al total del pago

        // Insertar el pedido en la base de datos
        $query = "INSERT INTO pedidos (id_producto, nombre_producto, cantidad_producto, id_cliente, nombre_cliente, total_pago, metodo_pago, fecha_compra) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
        $stmt = $conexion->prepare($query);

        // Manejar errores en la preparación
        if (!$stmt) {
            echo "Error en la preparación de la consulta: " . $conexion->error;
            exit();
        }

        // Vincular parámetros a la consulta
        $stmt->bind_param(
            "isiisds",
            $id_producto,
            $nombre_producto,
            $cantidad_producto,
            $id_cliente,
            $nombre_cliente,
            $subtotal,
            $metodo_pago
        );

        // Ejecutar la consulta y manejar errores
        if (!$stmt->execute()) {
            echo "Error al insertar el pedido: " . $stmt->error;
            exit();
        }
    }

    // Guardar los datos necesarios en la sesión para la confirmación
    $_SESSION['confirmacion_pedido'] = [
        'productos' => $_SESSION['carrito'],
        'total_a_pagar' => $total_pago,
        'metodo_pago' => $metodo_pago
    ];

    // Vaciar el carrito después de procesar el pedido
    unset($_SESSION['carrito']);

    // Redirigir a la página de confirmación
    header('Location: confirmacion.php');
    exit();
} else {
    echo "<script>
            alert('El carrito está vacío.');
            window.location.href = 'carrito.php';
          </script>";
    exit();
}
?>







