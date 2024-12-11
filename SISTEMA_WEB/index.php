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

// Obtener el criterio de ordenación y el término de búsqueda desde la URL, si están presentes
$order = isset($_GET['order']) ? $_GET['order'] : '';
$queryTerm = isset($_GET['query']) ? $_GET['query'] : '';

// Definir la consulta SQL básica
$query = "SELECT id_producto, nombre_producto, precio_producto, imagen_producto FROM inventario";

// Modificar la consulta SQL según el criterio de búsqueda
if (!empty($queryTerm)) {
    $query .= " WHERE nombre_producto LIKE '%" . $conexion->real_escape_string($queryTerm) . "%'";
}

// Modificar la consulta SQL según el criterio de ordenación
switch ($order) {
    case 'price_high':
        $query .= " ORDER BY precio_producto DESC";
        break;
    case 'price_low':
        $query .= " ORDER BY precio_producto ASC";
        break;
    case 'name_az':
        $query .= " ORDER BY nombre_producto ASC";
        break;
    case 'name_za':
        $query .= " ORDER BY nombre_producto DESC";
        break;
}

// Ejecutar la consulta
$result = mysqli_query($conexion, $query);

if (!$result) {
    echo "<div class='alert alert-danger' role='alert'>
            Error al realizar la consulta a la base de datos.
          </div>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PapelPlus</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" 
    rel="stylesheet" 
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" 
    crossorigin="anonymous">
    <link href="css/estiloindex.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="icon" href="img/logo2.jpeg" type="image/png">
    
    <style>
        .card {
            text-align: center;
        }
        .card-title {
            font-size: 1.2rem;
            font-weight: bold;
        }
        .card-text {
            font-size: 1.5rem; /* Hacer el precio más grande */
            font-weight: bold;
        }
        .btn-primary {
            margin-top: 15px;
        }
        .navbar .btn {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
        }
        .navbar .input-group .form-control {
            width: 150px;
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
        .carrito-btn {
            margin-top: 2px; /* Ajusta este valor para mover más arriba */
            position: relative;
            display: flex;
            align-items: center;
        }
        .carrito-btn {
    margin-top: 2px; /* Ajusta según lo que necesites */
    position: relative;
    display: flex;
    align-items: center;
}
    </style>

</head>
<body>

<header>
  <div class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a href="index.php" class="navbar-brand"> 
        <strong>PapelPlus</strong>
      </a>
      <button class="navbar-toggler" type="button" 
      data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" 
      aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarHeader">
        <div class="d-flex ms-auto align-items-center gap-2"> 
          <!-- Barra de búsqueda -->
          <form class="d-flex me-3" method="GET" action="index.php"> 
            <div class="input-group">
              <input class="form-control" type="search" placeholder="Buscar..." aria-label="Search" name="query" value="<?php echo htmlspecialchars($queryTerm); ?>">
              <button class="btn btn-outline-light" type="submit"><i class="fas fa-search"></i></button>
            </div>
          </form>
          <!-- Botón de Carrito -->
          <a href="carrito.php" class="btn btn-primary position-relative d-flex align-items-center justify-content-center carrito-btn"> 
  <i class="fas fa-shopping-cart me-1"></i> Carrito
  <?php if ($cantidadCarrito = contarProductosEnCarrito()): ?>
    <span class="cart-counter"><?php echo $cantidadCarrito; ?></span>
  <?php endif; ?>
</a>

          <!-- Botón de Usuario/Iniciar Sesión -->
<?php if(isset($_SESSION['nombre_cliente'])): ?>
    <div class="dropdown carrito-btn">
        <button class="btn btn-success dropdown-toggle d-flex align-items-center justify-content-center" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <?php echo htmlspecialchars($_SESSION['nombre_cliente']); ?>
        </button>
        <ul class="dropdown-menu" aria-labelledby="userDropdown">
            <li><a class="dropdown-item" href="logout.php">Cerrar sesión</a></li>
        </ul>
    </div>
<?php else: ?>
    <a href="iniciosesion.php" class="btn btn-success d-flex align-items-center justify-content-center carrito-btn">
        <i class="fas fa-user me-1"></i> Ingresar
    </a>
<?php endif; ?>

        </div>
      </div>
    </div>
  </div>
</header>


<main>
    <div class="container">
        <div class="d-flex justify-content-end my-3">
            <form method="GET" action="index.php" class="d-flex">
                <label for="order" class="order-label align-self-center">Ordenar por:</label>
                <select class="form-select order-select" id="order" name="order" onchange="this.form.submit()">
                    <option value="">Seleccionar</option>
                    <option value="price_high" <?php echo $order == 'price_high' ? 'selected' : ''; ?>>Precios más altos</option>
                    <option value="price_low" <?php echo $order == 'price_low' ? 'selected' : ''; ?>>Precios más bajos</option>
                    <option value="name_az" <?php echo $order == 'name_az' ? 'selected' : ''; ?>>Nombre A-Z</option>
                    <option value="name_za" <?php echo $order == 'name_za' ? 'selected' : ''; ?>>Nombre Z-A</option>
                </select>
                <input type="hidden" name="query" value="<?php echo htmlspecialchars($queryTerm); ?>">
            </form>
        </div>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
            <?php
            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $imagePath = $row['imagen_producto']; 
                    $productId = $row['id_producto'];
                    echo '<div class="col">
                            <div class="card shadow-sm">
                              <img src="' . $imagePath . '" class="card-img-top" alt="' . $row['nombre_producto'] . '">
                              <div class="card-body">
                                  <h5 class="card-title">' . $row['nombre_producto'] . '</h5>
                                  <p class="card-text">$' . number_format($row['precio_producto'], 2) . '</p>
                                  <a href="DetallesProducto.php?id=' . $productId . '" class="btn btn-primary">Detalles</a>
                              </div>
                            </div>
                          </div>';
                }
            }
            ?>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
