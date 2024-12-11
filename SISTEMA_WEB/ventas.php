<?php
session_start();
if (empty($_SESSION["id"])) {
    header("location: login.php");
}
include "modelo/conexion.php";
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Ventas</title>
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
                <th>ID Venta</th>
                <th>ID Producto</th>
                <th>Nombre Producto</th>
                <th>Cantidad Producto</th>
                <th>ID Cliente</th>
                <th>Nombre Cliente</th>
                <th>Fecha Compra</th>
                <th>Total Pago</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM ventas";
            $resultado = $conexion->query($sql);

            if ($resultado->num_rows > 0) {
                while ($fila = $resultado->fetch_assoc()) {
            ?>
                    <tr>
                        <td><?php echo $fila['id_venta']; ?></td>
                        <td><?php echo $fila['id_producto']; ?></td>
                        <td><?php echo $fila['nombre_producto']; ?></td>
                        <td><?php echo $fila['cantidad_producto']; ?></td>
                        <td><?php echo $fila['id_cliente']; ?></td>
                        <td><?php echo $fila['nombre_cliente']; ?></td>
                        <td><?php echo $fila['fecha_compra']; ?></td>
                        <td><?php echo $fila['total_pago']; ?></td>
                    </tr>
            <?php
                }
            } else {
                echo "<tr><td colspan='8'>No hay ventas</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
<script src="script.js"></script>
</html>
