<?php
session_start();
if (empty($_SESSION["id"])) {
    header("location: login.php");
    exit();
}
include "modelo/conexion.php";

$order = 'ASC';
$order_by = 'id_cliente';

// Inicializar la variable $mensaje para evitar errores
$mensaje = '';

function mostrarDireccionOrden($order_by, $order) {
    if ($order == 'ASC') {
        $direccion = 'Menor a mayor';
    } else {
        $direccion = 'Mayor a menor';
    }

    if ($order_by == 'nombre_cliente') {
        $columna = 'Nombre';
    } elseif ($order_by == 'email_cliente') {
        $columna = 'Email';
    } elseif ($order_by == 'telefono_cliente') {
        $columna = 'Teléfono';
    } else {
        $columna = 'ID Cliente';
    }

    echo "Ordenado por $columna: $direccion";
}

function fetchClientes($conexion, $order_by, $order, $search_term = '') {
    $query = "SELECT id_cliente, nombre_cliente, email_cliente, telefono_cliente FROM clientes";

    if (!empty($search_term)) {
        $search_term = mysqli_real_escape_string($conexion, $search_term);
        $query .= " WHERE nombre_cliente LIKE '%$search_term%' OR email_cliente LIKE '%$search_term%'";
    }

    $query .= " ORDER BY $order_by $order";

    $result = $conexion->query($query);

    if (!$result) {
        die("Error en la consulta: " . $conexion->error);
    }

    return $result;
}

if (isset($_GET['ordenar'])) {
    if ($_GET['ordenar'] == 'nombre_desc') {
        $order_by = 'nombre_cliente';
        $order = 'DESC';
    } elseif ($_GET['ordenar'] == 'nombre_asc') {
        $order_by = 'nombre_cliente';
        $order = 'ASC';
    } elseif ($_GET['ordenar'] == 'email_desc') {
        $order_by = 'email_cliente';
        $order = 'DESC';
    } elseif ($_GET['ordenar'] == 'email_asc') {
        $order_by = 'email_cliente';
        $order = 'ASC';
    } elseif ($_GET['ordenar'] == 'telefono_desc') {
        $order_by = 'telefono_cliente';
        $order = 'DESC';
    } elseif ($_GET['ordenar'] == 'telefono_asc') {
        $order_by = 'telefono_cliente';
        $order = 'ASC';
    }
}

if (isset($_GET['buscar'])) {
    $search_term = $_GET['buscar'];
    $result = fetchClientes($conexion, $order_by, $order, $search_term);
} else {
    $result = fetchClientes($conexion, $order_by, $order);
}
?>

<html>
<head>
    <meta charset="UTF-8">
    <title>Clientes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styleinicio.css">
    <link rel="stylesheet" href="css/styleclientes.css">
    <link rel="icon" href="img/logo.jpeg" type="image/png">
</head>
<body>
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

    <div class="container">
        <div class="messages">
            <?php echo $mensaje; ?>
        </div>

        <div class="sub-banner">
            <ul>
                <li>
                    <form class="search-form" method="GET" action="clientes.php">
                        <input type="text" name="buscar" class="search-input" placeholder="Buscar por nombre o email">
                        <button type="submit" class="search-button">Buscar</button>
                    </form>
                </li>
            </ul>
        </div>

        <div class="orden-info">
            <?php mostrarDireccionOrden($order_by, $order); ?>
        </div>

        <table border="1" id="clientes-table">
            <thead>
                <tr>
                    <th>ID Cliente</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id_cliente"] . "</td>";
                    echo "<td>" . $row["nombre_cliente"] . "</td>";
                    echo "<td>" . $row["email_cliente"] . "</td>";
                    echo "<td>" . $row["telefono_cliente"] . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <?php $conexion->close(); ?>
</body>
</html>
