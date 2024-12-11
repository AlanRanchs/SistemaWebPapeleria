<?php
session_start();
if (empty($_SESSION["id"])) {
    header("location: login.php");
    exit();
}
include "modelo/conexion.php";

// Consulta para obtener el total de productos y el valor total de productos
$query_productos = "SELECT SUM(cantidad_producto) AS total_productos, SUM(precio_producto * cantidad_producto) AS valor_total FROM inventario";
$result_productos = mysqli_query($conexion, $query_productos);

if ($result_productos) {
    $row_productos = mysqli_fetch_assoc($result_productos);
    $total_productos = $row_productos['total_productos'];
    $valor_total = $row_productos['valor_total'];
} else {
    $total_productos = 0;
    $valor_total = 0;
}

// Consulta para obtener el total de clientes (activos)
$query_clientes_activos = "SELECT COUNT(*) AS total_clientes_activos FROM clientes";
$result_clientes_activos = mysqli_query($conexion, $query_clientes_activos);

if ($result_clientes_activos) {
    $row_clientes_activos = mysqli_fetch_assoc($result_clientes_activos);
    $total_clientes_activos = $row_clientes_activos['total_clientes_activos'];
} else {
    $total_clientes_activos = 0;
}

// Consulta para obtener el total de clientes bloqueados
$query_clientes_baneados = "SELECT COUNT(*) AS total_clientes_bloqueados FROM clientes_baneados";
$result_clientes_baneados = mysqli_query($conexion, $query_clientes_baneados);

if ($result_clientes_baneados) {
    $row_clientes_bloqueados = mysqli_fetch_assoc($result_clientes_baneados);
    $total_clientes_bloqueados = $row_clientes_bloqueados['total_clientes_bloqueados'];
} else {
    $total_clientes_bloqueados = 0;
}

// Consulta para obtener el total de pedidos
$query_pedidos = "SELECT COUNT(*) AS total_pedidos FROM pedidos";
$result_pedidos = mysqli_query($conexion, $query_pedidos);

if ($result_pedidos) {
    $row_pedidos = mysqli_fetch_assoc($result_pedidos);
    $total_pedidos = $row_pedidos['total_pedidos'];
} else {
    $total_pedidos = 0;
}

// Consulta para obtener el total de ventas
$query_ventas = "SELECT COUNT(*) AS total_ventas FROM ventas";
$result_ventas = mysqli_query($conexion, $query_ventas);

if ($result_ventas) {
    $row_ventas = mysqli_fetch_assoc($result_ventas);
    $total_ventas = $row_ventas['total_ventas'];
} else {
    $total_ventas = 0;
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Inicio</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styleinicio.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <link rel="icon" href="img/logo.jpeg" type="image/png">
    <style>



        /* Estilo para los elementos del menú */
        .menu-item {
            position: relative;
            display: inline-block;
            padding: 10px 15px;
            color: #000; /* Color del texto antes de pasar el cursor */
            background-color: #fff; /* Color de fondo antes de pasar el cursor */
            text-decoration: none;
            transition: color 0.3s, background-color 0.3s;
        }

        /* Pseudo-elementos antes y después de cada elemento del menú */
        .menu-item::before,
        .menu-item::after {
            content: '';
            position: absolute;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: #000; /* Color de las burbujas */
            transform: scale(0);
            transition: transform 0.3s;
        }

        /* Pseudo-elemento antes */
        .menu-item::before {
            top: 0;
            left: 50%;
            transform: translateX(-50%) scale(0);
        }

        /* Pseudo-elemento después */
        .menu-item::after {
            bottom: 0;
            right: 50%;
            transform: translateX(50%) scale(0);
        }

        /* Animación de burbuja al pasar el cursor */
        .menu-item:hover {
            color: #fff; /* Color del texto al pasar el cursor */
            background-color: #007bff; /* Color de fondo al pasar el cursor */
        }

        .menu-item:hover::before,
        .menu-item:hover::after {
            transform: translateX(-50%) scale(1);
        }

        .menu-item:hover::after {
            transform: translateX(50%) scale(1);
        }

        /* Estilos para las estadísticas */
        .stats-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            margin-top: 20px;
        }

        .stat-item {
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 10px;
            flex: 1 1 30%;
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .stat-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .stat-item h2 {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .stat-item p {
            font-size: 1.25rem;
            color: #007bff;
        }

    </style>
</head>

<body>
    <nav class="main-menu">
        <ul>
            <!-- Logo de la empresa -->
            <li><a href="inicio.php"><img src="img/logo.jpeg" class="menu-logo"></a></li>
            <!-- Enlaces del menú con animación de burbuja -->
            <li><a href="inventario.php" class="menu-item">Inventario</a></li>
            <li><a href="clientes.php" class="menu-item">Clientes</a></li>
            <li><a href="pedidos.php" class="menu-item">Pedidos</a></li>
            <li><a href="ventas.php" class="menu-item">Ventas</a></li>
        </ul>
        <!-- Sección de usuario -->
        <li class="user-section">
            <span class="username"><?php echo $_SESSION["nombre"] . " " . $_SESSION["apellido"]; ?></span>
            <a id="logout-button" class="logout-button" href="controlador/controlador_cerrar_sesion.php">Cerrar Sesión</a>
        </li>
    </nav>
    <div class="container">
        <h1 class="welcome-message">Bienvenido a la papelería</h1>
        <div class="stats-container">
            <!-- Estadísticas generales -->
            <div class="stat-item" data-aos="fade-up">
                <h2>Total de productos</h2>
                <p><?php echo $total_productos ? $total_productos : 0; ?></p>
            </div>
            <div class="stat-item" data-aos="fade-up" data-aos-delay="100">
                <h2>Valor total de productos</h2>
                <p>$<?php echo $valor_total ? number_format($valor_total, 2) : 0.00; ?></p>
            </div>
            <div class="stat-item" data-aos="fade-up" data-aos-delay="200">
                <h2>Total de clientes activos</h2>
                <p><?php echo $total_clientes_activos ? $total_clientes_activos : 0; ?></p>
            </div>
            <div class="stat-item" data-aos="fade-up" data-aos-delay="300">
                <h2>Total de clientes bloqueados</h2>
                <p><?php echo $total_clientes_bloqueados ? $total_clientes_bloqueados : 0; ?></p>
            </div>
            <div class="stat-item" data-aos="fade-up" data-aos-delay="400">
                <h2>Total de pedidos</h2>
                <p><?php echo $total_pedidos ? $total_pedidos : 0; ?></p>
            </div>
            <div class="stat-item" data-aos="fade-up" data-aos-delay="500">
                <h2>Total de ventas</h2>
                <p><?php echo $total_ventas ? $total_ventas : 0; ?></p>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000, // Duración de las animaciones en milisegundos
            easing: 'ease-in-out', // Efecto de easing para las animaciones
            once: true, // Si las animaciones deberían ejecutarse solo una vez
        });
    </script>
</body>

</html>