<?php
session_start();
include "modelo/conexion.php";

// Verifica que la conexión se ha establecido correctamente
if (!$conexion) {
    die("Connection failed: " . mysqli_connect_error());
}

// Verifica si el usuario está conectado
$sesion_iniciada = isset($_SESSION['id_cliente']);

// Consulta del producto y la cantidad disponible
$id = $_GET['id'];
$query = "SELECT id_producto, nombre_producto, descripcion_producto, precio_producto, imagen_producto, cantidad_producto FROM inventario WHERE id_producto = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$producto = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($producto['nombre_producto']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="icon" href="img/logo2.jpeg" type="image/png">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .producto-detalle {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            display: flex;
            gap: 20px;
            margin-top: 30px;
            align-items: center;
        }
        .producto-imagen img {
            max-width: 100%;
            border-radius: 10px;
        }
        .producto-info {
            flex: 1;
        }
        .producto-info h1 {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 15px;
        }
        .producto-info .precio {
            font-size: 24px;
            font-weight: bold;
            color: #28a745;
            margin-bottom: 15px;
        }
        .producto-info .disponibles {
            font-size: 18px;
            color: #6c757d;
            margin-bottom: 20px;
        }
        .producto-info form {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .producto-info input[type="number"] {
            width: 80px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            text-align: center;
        }
        .btn-carrito {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .btn-carrito:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a href="index.php" class="navbar-brand"><strong>PapelPlus</strong></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarHeader">
                <div class="d-flex ms-auto align-items-center">
                    <form class="d-flex me-2" method="GET" action="index.php">
                        <div class="input-group">
                            <input class="form-control" type="search" placeholder="Buscar..." name="query">
                            <button class="btn btn-outline-light" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                    <a href="carrito.php" class="btn btn-primary position-relative me-2">
                        <i class="fas fa-shopping-cart"></i> Carrito
                        <?php if (!empty($_SESSION['carrito'])): ?>
                            <span class="badge bg-danger position-absolute top-0 start-100 translate-middle">
                                <?php echo array_sum(array_column($_SESSION['carrito'], 'cantidad')); ?>
                            </span>
                        <?php endif; ?>
                    </a>
                    <?php if ($sesion_iniciada): ?>
                        <div class="dropdown">
                            <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <?php echo htmlspecialchars($_SESSION['nombre_cliente']); ?>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="logout.php">Cerrar sesión</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a href="iniciosesion.php" class="btn btn-success"><i class="fas fa-user"></i> Ingresar</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
</header>

<main>
    <div class="container">
        <div class="producto-detalle">
            <div class="producto-imagen">
                <img src="<?php echo htmlspecialchars($producto['imagen_producto']); ?>" alt="<?php echo htmlspecialchars($producto['nombre_producto']); ?>">
            </div>
            <div class="producto-info">
                <h1><?php echo htmlspecialchars($producto['nombre_producto']); ?></h1>
                <p><?php echo htmlspecialchars($producto['descripcion_producto']); ?></p>
                <p class="precio">$<?php echo number_format($producto['precio_producto'], 2); ?></p>
                <p class="disponibles">Disponibles: <?php echo $producto['cantidad_producto']; ?></p>
                <form action="carrito.php" method="POST">
                    <input type="hidden" name="producto_id" value="<?php echo $producto['id_producto']; ?>">
                    <label for="cantidad">Cantidad:</label>
                    <input type="number" id="cantidad" name="cantidad" value="1" min="1" max="<?php echo $producto['cantidad_producto']; ?>" required>
                    <button type="submit" class="btn-carrito">Agregar al carrito</button>
                </form>
            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
$stmt->close();
$conexion->close();
?>



