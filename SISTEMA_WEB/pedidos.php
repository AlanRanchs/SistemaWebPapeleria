<?php
session_start();
if (empty($_SESSION["id"])) {
    header("location: login.php");
}
include "modelo/conexion.php";

function actualizarInventario($conexion, $producto_id, $cantidad) {
    $sql = "UPDATE inventario SET cantidad_producto = cantidad_producto - ? WHERE id_producto = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ii", $cantidad, $producto_id);
    $stmt->execute();
}

function moverAPedidos($conexion, $pedido_id) {
    // Obtener datos del pedido
    $sql = "SELECT * FROM pedidos WHERE id_pedido = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $pedido_id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $pedido = $resultado->fetch_assoc();

    // Insertar en ventas
    $sql_insert = "INSERT INTO ventas (id_producto, nombre_producto, cantidad_producto, id_cliente, nombre_cliente, fecha_compra, total_pago) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert = $conexion->prepare($sql_insert);
    $stmt_insert->bind_param("isiissi", $pedido['id_producto'], $pedido['nombre_producto'], $pedido['cantidad_producto'], $pedido['id_cliente'], $pedido['nombre_cliente'], $pedido['fecha_compra'], $pedido['total_pago']);
    $stmt_insert->execute();

    // Eliminar de pedidos
    $sql_delete = "DELETE FROM pedidos WHERE id_pedido = ?";
    $stmt_delete = $conexion->prepare($sql_delete);
    $stmt_delete->bind_param("i", $pedido_id);
    $stmt_delete->execute();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['completado'])) {
        $pedido_id = $_POST['pedido_id'];
        $producto_id = $_POST['producto_id'];
        $cantidad = $_POST['cantidad'];

        moverAPedidos($conexion, $pedido_id);
        actualizarInventario($conexion, $producto_id, $cantidad);
    }

    if (isset($_POST['cancelar'])) {
        $pedido_id = $_POST['pedido_id'];

        // Eliminar de pedidos
        $sql_delete = "DELETE FROM pedidos WHERE id_pedido = ?";
        $stmt_delete = $conexion->prepare($sql_delete);
        $stmt_delete->bind_param("i", $pedido_id);
        $stmt_delete->execute();
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Pedidos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styleinicio.css">
    <link rel="stylesheet" href="css/styleinventario.css">
    <link rel="icon" href="img/logo.jpeg" type="image/png">
    <nav class="main-menu">
        <ul>
            <li><a href="inicio.php"><img src="img/logo.jpeg" class="menu-logo"></a></li>
            <li><a href="inventario.php" class="menu-item">Inventario</a></li>
            <li><a href="clientes.php" class="menu-item">Clientes</a></li>
            <li><a href="pedidos.php" class="menu-item">Pedidos</a></li>
            <li><a href="ventas.php" class="menu-item">Ventas</a></li>
        </ul>
        <li class="user-section">
            <span class="username"><?php echo $_SESSION["nombre"] . " " . $_SESSION["apellido"]; ?></span>
            <a id="logout-button" class="logout-button" href="controlador/controlador_cerrar_sesion.php">Cerrar Sesión</a>
        </li>
    </nav>
</head>

<body>
    <table>
        <thead>
            <tr>
                <th>ID Pedido</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Cliente</th>
                <th>Fecha</th>
                <th>Total Pago</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT p.id_pedido, p.id_producto, p.nombre_producto, p.cantidad_producto, c.nombre_cliente, p.fecha_compra, p.total_pago FROM pedidos p JOIN clientes c ON p.id_cliente = c.id_cliente";
            $resultado = $conexion->query($sql);
            while ($fila = $resultado->fetch_assoc()) {
            ?>
                <tr>
                    <td><?php echo $fila['id_pedido']; ?></td>
                    <td><?php echo $fila['nombre_producto']; ?></td>
                    <td><?php echo $fila['cantidad_producto']; ?></td>
                    <td><?php echo $fila['nombre_cliente']; ?></td>
                    <td><?php echo $fila['fecha_compra']; ?></td>
                    <td><?php echo $fila['total_pago']; ?></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="pedido_id" value="<?php echo $fila['id_pedido']; ?>">
                            <input type="hidden" name="producto_id" value="<?php echo $fila['id_producto']; ?>">
                            <input type="hidden" name="cantidad" value="<?php echo $fila['cantidad_producto']; ?>">
                            <button type="submit" name="completado">Completado</button>
                            <button type="submit" name="cancelar">Cancelar</button>
                        </form>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</body>

</html>
